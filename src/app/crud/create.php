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
              <ul>
                <li>
                  <label for="title">Title</label>
                  <input type="text" name="title" value="<?php echo !empty($r['title']) ? $r['title'] : null; ?>">
                </li>
                <?php if ($section === "news") { ?>
                  <li>
                    <label for="summary">Summary</label>
                    <textarea rows="3" name="summary"><?php echo !empty($r['summary']) ? $r['summary'] : null; ?></textarea>
                  </li>
                <?php } ?>
                <li>
                  <label for="body">Body</label>
                  <textarea rows="10" name="body"><?php echo !empty($r['body']) ? $r['body'] : null; ?></textarea>
                </li>
                <li>
                  <label for="author">Author</label>
                  <input type="text" name="author" value="<?php echo !empty($r['author']) ? $r['author'] : null; ?>">
                </li>
                <li>
                  <label for="image">Image</label>
                  <input type="file" <?= ($section === 'news') ? "multiple=\"multiple\" name=\"image[]\"" : "name=\"image\"" ?> accept="image/x-png,image/gif,image/jpeg">
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
                          echo "<option ".$active." value=".$c['id'].">" . $c['category'] . " </option>";
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
            </fieldset>
            <fieldset>
              <input type="hidden" name="section" value="<?php echo $section; ?>">
              <input type="hidden" name="token" value="<?php echo $token; ?>">
              <input type="submit" value="Save">
            </fieldset>
          </form>
          <?php
          if (!empty($_POST)) {
            $title        = $_POST['title'];
            $summary      = $_POST['summary'];
            $body         = $_POST['body'];
            $author       = $_POST['author'];
            $images       = $_FILES['image'];
            $usersId      = $_SESSION['usersid'];
            $categoriesId = $_POST['categories'];
            $errors       = [];
            
            $status     = !empty($_POST['status']) ? $_POST['status'] : 0;
            $token      = !empty($_POST['token']) ? $_POST['token'] : sha1(bin2hex(date('U')));
            $timestamp  = date('Y-m-d');
            $section    = $_POST['section'];
            if (is_array($images['tmp_name']) && $images['tmp_name'][0] == '') {
              unset($images);
            }
            if (!empty($images['tmp_name'])) {
              if (is_array($images['size'])) {
                foreach ($images['size'] as $size) {
                  if ($size > 2097152) {
                    array_push($errors, "Error: Maximum size for images is 2MB");
                    break;
                  }
                }
                foreach ($images['name'] as $name) {
                  if (strtolower(strchr($name, '.')) != '.jpeg' && strtolower(strchr($name, '.')) != '.jpg') {
                    array_push($errors, "Error: Invalid image(s) type");
                    break;
                  }
                }
              } else {
                if ($images['size'] > 2097152) {
                  array_push($errors, "Error: Maximum size for images is 2MB");
                }
                if (strtolower(strchr($images['name'], '.')) != '.jpeg' && strtolower(strchr($images['name'], '.')) != '.jpg') {
                  array_push($errors, "Error: Invalid image type");
                }
              }
            }
            if (!empty($errors)) {
              foreach ($errors as $e) {
                echo $e;
              }
              die();
            } else {
              if (!empty($images['tmp_name'])) {
                if (is_array($images['tmp_name'])) {
                  if (count($images['tmp_name']) > 0) {
                    $path = $_SERVER['DOCUMENT_ROOT'] . "/app/uploads/$token/";
                    if (is_dir($path)) {
                      deleteDirectory($path);
                    }
                    mkdir($path, 0777, true);
                    $extensions = [];
                    foreach ($images['name'] as $image) {
                      array_push($extensions, strchr($image, '.'));
                    }
                    $i = 0;
                    //echo($path);
                    //var_dump($images);
                    foreach ($images['tmp_name'] as $image) {
                      if (!move_uploaded_file($image, $path . ($i + 1) . strchr($extensions[$i], '.'))) {
                        array_push($errors, "Error: An error occurred uploading your images.");
                        break;
                      }
                      $i++;
                    }
                  }
                } else {
                  $extension = strchr($images['name'], '.');
                  $path = $_SERVER['DOCUMENT_ROOT'] . "/app/uploads/$token/";
                  if (is_dir($path)) {
                    deleteDirectory($path);
                  }
                  mkdir($path, 0777, true);
                  if (!move_uploaded_file($images['tmp_name'], $path . $token . strchr($images['name'], '.'))) {
                    array_push($errors, "Error: An error occurred uploading image.");
                  }
                }
              }
              if (!empty($files['tmp_name'])) {
                if (count($files['tmp_name']) > 0) {
                  $path = $_SERVER['DOCUMENT_ROOT'] . "app/uploads/$token/files/";
                  if (is_dir($path)) {
                    deleteDirectory($path);
                  }
                  mkdir($path, 0777, true);
                  $extensions = [];
                  foreach ($files['name'] as $file) {
                    array_push($extensions, strchr($file, '.'));
                  }
                  $i = 0;
                  foreach ($files['tmp_name'] as $file) {
                    if (!move_uploaded_file($file, $path . ($i + 1) . strchr($extensions[$i], '.'))) {
                      array_push($errors, "Error: An error occurred uploading your files.");
                      break;
                    }
                    $i++;
                  }
                }
              }
              if (!empty($errors)) {
                foreach ($errors as $e) {
                  echo $e;
                }
                die();
              }
            }
            if ($section === "news") {
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
              }
            } else if ($section === "products") {
              if (!empty($_POST['token'])) {
                if ($_SESSION['level'] >= 2) {
                  $sql = "UPDATE " . $section . " SET title = ?, body = ?, author = ?, status = ? WHERE token = ?";
                } else {
                  $sql = "UPDATE " . $section . " SET title = ?, body = ?, author = ? WHERE token = ?";
                }

                $stmt = conn()->prepare($sql);
                $stmt->bindValue(1, $title, PDO::PARAM_STR);
                $stmt->bindValue(2, $body, PDO::PARAM_STR);
                $stmt->bindValue(3, $author, PDO::PARAM_STR);


                if ($_SESSION['level'] >= 2) {
                  $stmt->bindValue(4, $status, PDO::PARAM_INT);
                  $stmt->bindValue(5, $token, PDO::PARAM_STR);
                } else {
                  $stmt->bindValue(4, $token, PDO::PARAM_STR);
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
              }
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