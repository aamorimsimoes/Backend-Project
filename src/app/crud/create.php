<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  require_once('../functions.php');
  require_once('../includes/head.php');
  $section = !empty($_GET['s']) ? $_GET['s'] : null;
  $token = !empty($_GET['token']) ? $_GET['token'] : null;


  $sql = "SELECT * FROM " . $section . " WHERE token = ?";
  $stmt = conn()->prepare($sql);
  if ($stmt->execute([$token])) {
    $n = $stmt->rowCount();
    if ($n === 1) {
      $r = $stmt->fetch();
      $stmt = null;
    }
  }
?>

  <body class="app">
    <?php require_once('../includes/header.php'); ?>
    <main>
      <div class="container">
        <?php require_once('../includes/menu.php'); ?>
        <div>

          <div class="section-title">
            <h1><?php echo $section; ?></h1>
          </div>
          <form action="create.php?s=<?= $section ?><?php if (!empty($token)) echo "&token=$token"; ?>" method="post" enctype="multipart/form-data">
            <fieldset>
              <?php if ($section === "users") { ?>
                <ul>
                  <li>
                    <label for="name">Name</label>
                    <input type="text" name="title" value="<?php echo !empty($r['name']) ? $r['name'] : null; ?>">
                  </li>
                  <li>
                    <label for="email">Email</label>
                    <input type="text" name="email" value="<?php echo !empty($r['email']) ? $r['email'] : null; ?>">
                  </li>
                  <li>
                    <label for="status">Status</label>
                    <select name="status">
                      <option value="0" <?php echo (!empty($r['status']) && $r['status'] === 0) ? 'selected' : ''; ?>>Inactive</option>
                      <option value="1" <?php echo (!empty($r['status']) && $r['status'] === 1) ? 'selected' : ''; ?>>Active</option>
                    </select>
                  </li>
                  <li>
                    <label for="level">Level</label>
                    <select name="level">
                      <option value="1" <?php echo (!empty($r['level']) && $r['level'] === 1) ? 'selected' : ''; ?>>User</option>
                      <option value="2" <?php echo (!empty($r['level']) && $r['level'] === 2) ? 'selected' : ''; ?>>Admin</option>
                    </select>
                  </li>

                  <h2>Additional information:</h2>
                  <li>
                    <label for="token">Token</label>
                    <input type="text" name="token" readonly value="<?php echo !empty($r['token']) ? $r['token'] : null; ?>">
                  </li>
                  <li>
                    <label for="registration_date">Registration Date</label>
                    <input type="text" name="registration_date" readonly value="<?php echo $r['registration_date'] ?>">
                  </li>
                </ul>
              <?php } else if ($section === "news" || "products") { ?>
                <ul>
                  <li>
                    <label for="title">Title</label>
                    <input type="text" name="title" value="<?php echo !empty($r['title']) ? $r['title'] : null; ?>">
                  </li>

                  <li>
                    <label for="summary">Summary</label>
                    <textarea rows="3" name="summary"><?php echo !empty($r['summary']) ? $r['summary'] : null; ?></textarea>
                  </li>

                  <li>
                    <label for="body">Body</label>
                    <textarea rows="10" name="body"><?php echo !empty($r['body']) ? $r['body'] : null; ?></textarea>
                  </li>
                  <li>
                    <?php if ($section === "news") { ?>
                      <label for="author">Author</label>
                      <input type="text" name="author" value="<?php echo !empty($r['author']) ? $r['author'] : null; ?>">
                  </li>
                <?php } ?>
                <li>
                  <label for="image">Image</label>
                  <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                </li>
                <?php if ($section === "products") {
                  $sql = "SELECT * FROM categories";
                  $stmt = conn()->prepare($sql);
                  if ($stmt->execute()) {
                    $n = $stmt->rowCount();
                    if ($n > 0) {
                      $cat = $stmt->fetchAll();
                      $stmt = null;
                    }
                  }
                ?>
                  <li>
                    <label for="categories">Categories</label>
                    <select name="categories">
                      <?php
                      foreach ($cat as $c) {
                        $active = $c['id'] === $r['categories_id'] ? "selected" : null;
                        echo "<option " . $active . " value=" . $c['id'] . ">" . $c['category'] . " </option>";
                      }
                      ?>
                    </select>
                  </li>
                <?php
                } ?>
                <?php
                if ($_SESSION['level'] >= 2) { ?>
                  <li>
                    <label for="author">Status</label>
                    <select name="status">
                      <option value="0" <?php echo (!empty($r['status']) && $r['status'] === 0) ? 'selected' : ''; ?>>Draft</option>
                      <option value="1" <?php echo (!empty($r['status']) && $r['status'] === 1) ? 'selected' : ''; ?>>Review</option>
                      <option value="2" <?php echo (!empty($r['status']) && $r['status'] === 2) ? 'selected' : ''; ?>>Published</option>
                      <option value="3" <?php echo (!empty($r['status']) && $r['status'] === 3) ? 'selected' : ''; ?>>Archived</option>
                    </select>
                  </li>
                <?php } ?>
                </ul>
              <?php } ?>
            </fieldset>
            <fieldset>
              <input type="hidden" name="section" value="<?php echo $section; ?>">
              <input type="hidden" name="token" value="<?php echo $token; ?>">
              <input type="submit" value="Save">
            </fieldset>
          </form>
          <?php
          if (!empty($_POST)) {
            $email        = isset($_POST['email']) ? $_POST['email'] : "";
            $title        = isset($_POST['title']) ? $_POST['title'] : "";
            $summary      = isset($_POST['summary']) ? $_POST['summary'] : "";
            $body         = isset($_POST['body']) ? $_POST['body'] : "";
            $author       = isset($_POST['author']) ? $_POST['author'] : "";
            $images       = $_FILES['image'];
            $usersId      = isset($_SESSION['usersid']) ? $_SESSION['usersid'] : "";
            $categoriesId = isset($_POST['categories']) ? $_POST['categories'] : "";
            $errors       = [];

            $status     = !empty($_POST['status']) ? $_POST['status'] : 0;
            $level     = !empty($_POST['level']) ? $_POST['level'] : 0;
            $token      = !empty($_POST['token']) ? $_POST['token'] : sha1(bin2hex(date('U')));
            $timestamp  = date('Y-m-d');
            $section    = $_POST['section'];
            if (!empty($images['tmp_name'])) {
              if ($images['size'] > 2097152) {
                array_push($errors, "Error: Maximum size for images is 2MB");
              }
              if (strtolower(strchr($images['name'], '.')) != '.jpeg' && strtolower(strchr($images['name'], '.')) != '.jpg') {
                array_push($errors, "Error: Invalid image type");
              }
            }
            if (!empty($errors)) {
              foreach ($errors as $e) {
                echo $e;
              }
            } else {
              if (!empty($images['tmp_name'])) {
                switch ($section) {
                  case 'news':
                    $path = $_SERVER['DOCUMENT_ROOT'] . "/app/uploads/news/$token/";
                    break;
                  case 'products':
                    $path = $_SERVER['DOCUMENT_ROOT'] . "/app/uploads/products/$token/";
                    break;
                  case 'users':
                    $path = $_SERVER['DOCUMENT_ROOT'] . "/app/uploads/avatar/$token/";
                    break;
                }
                if (is_dir($path)) {
                  deleteDirectory($path);
                }
                mkdir($path, 0777, true);

                if (!move_uploaded_file($images['tmp_name'], $path . "1.jpg")) {
                  array_push($errors, "Error: An error occurred uploading your images.");
                }
              }
              if (!empty($errors)) {
                foreach ($errors as $e) {
                  echo $e;
                }
                die();
              }
            }
            switch ($section) {
              case "news":
                if (!empty($_POST['token'])) {

                  if ($_SESSION['level'] >= 2) {
                    $sql = "UPDATE " . $section . " SET title = ?, summary = ?, body = ?, author = ?, status = ? WHERE token = ?";
                  } else {
                    $sql = "UPDATE " . $section . " SET title = ?, summary = ?, body = ?, author = ? WHERE token = ?";
                  }

                  $stmt = conn()->prepare($sql);
                  $stmt->bindValue(1, $title, PDO::PARAM_STR);
                  $stmt->bindValue(2, $summary, PDO::PARAM_STR);
                  $stmt->bindValue(3, $body, PDO::PARAM_STR);
                  $stmt->bindValue(4, $author, PDO::PARAM_STR);


                  if ($_SESSION['level'] >= 2) {
                    $stmt->bindValue(5, $status, PDO::PARAM_INT);
                    $stmt->bindValue(6, $token, PDO::PARAM_STR);
                  } else {
                    $stmt->bindValue(5, $token, PDO::PARAM_STR);
                  }
                } else {
                  $sql = "INSERT INTO " . $section . " (title, summary, body, author, status, token, date, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                  $stmt = conn()->prepare($sql);
                  $stmt->bindValue(1, $title, PDO::PARAM_STR);
                  $stmt->bindValue(2, $summary, PDO::PARAM_STR);
                  $stmt->bindValue(3, $body, PDO::PARAM_STR);
                  $stmt->bindValue(4, $author, PDO::PARAM_STR);
                  $stmt->bindValue(5, $status, PDO::PARAM_INT);
                  $stmt->bindValue(6, $token, PDO::PARAM_STR);
                  $stmt->bindValue(7, $timestamp, PDO::PARAM_STR);
                  $stmt->bindValue(8, $usersId, PDO::PARAM_STR);
                };
                break;

              case "products":
                if (!empty($_POST['token'])) {
                  if ($_SESSION['level'] >= 2) {
                    $sql = "UPDATE " . $section . " SET title = ?, summary = ?, body = ?, categories_id = ?, status = ? WHERE token = ?";
                  } else {
                    $sql = "UPDATE " . $section . " SET title = ?, summary = ?, body = ?, categories_id = ? WHERE token = ?";
                  }

                  $stmt = conn()->prepare($sql);
                  $stmt->bindValue(1, $title, PDO::PARAM_STR);
                  $stmt->bindValue(2, $summary, PDO::PARAM_STR);
                  $stmt->bindValue(3, $body, PDO::PARAM_STR);
                  $stmt->bindValue(4, $categoriesId, PDO::PARAM_STR);


                  if ($_SESSION['level'] >= 2) {
                    $stmt->bindValue(5, $status, PDO::PARAM_INT);
                    $stmt->bindValue(6, $token, PDO::PARAM_STR);
                  } else {
                    $stmt->bindValue(5, $token, PDO::PARAM_STR);
                  }
                } else {
                  $sql = "INSERT INTO products (title, summary, body, status, token, date, categories_id, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                  $stmt = conn()->prepare($sql);
                  $stmt->bindValue(1, $title, PDO::PARAM_STR);
                  $stmt->bindValue(2, $summary, PDO::PARAM_STR);
                  $stmt->bindValue(3, $body, PDO::PARAM_STR);
                  $stmt->bindValue(4, $status, PDO::PARAM_INT);
                  $stmt->bindValue(5, $token, PDO::PARAM_STR);
                  $stmt->bindValue(6, $timestamp, PDO::PARAM_STR);
                  $stmt->bindValue(7, $categoriesId, PDO::PARAM_STR);
                  $stmt->bindValue(8, $usersId, PDO::PARAM_STR);
                };
                break;

              case "users":
                if (!empty($_POST['token'])) {
                  if ($_SESSION['level'] >= 2) {
                    $sql = "UPDATE " . $section . " SET name = ?, email = ?, status = ?, level = ?  WHERE token = ?";
                  } else {
                    $sql = "UPDATE " . $section . " SET name = ?, email = ? WHERE token = ?";
                  }

                  $stmt = conn()->prepare($sql);
                  $stmt->bindValue(1, $title, PDO::PARAM_STR);
                  $stmt->bindValue(2, $email, PDO::PARAM_STR);


                  if ($_SESSION['level'] >= 2) {
                    $stmt->bindValue(3, $status, PDO::PARAM_INT);
                    $stmt->bindValue(4, $level, PDO::PARAM_INT);
                    $stmt->bindValue(5, $token, PDO::PARAM_STR);
                  } else {
                    $stmt->bindValue(3, $token, PDO::PARAM_STR);
                  }
                }
                break;
            }
            if ($stmt->execute()) {
              $stmt = null;
              echo "Registo inserido";
              header("Location: ../$section/");
              exit;
            }
          }
          ?>
        </div>
      </div>
    </main>
    <?php require_once('../includes/footer.php'); ?>

  </body>

  </html>

<?php
} ?>