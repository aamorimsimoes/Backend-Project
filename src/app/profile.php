<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: signin.php');
        exit;
    } else {
        require_once('functions.php');
        require_once('includes/head.php');
        require_once('../vendor/claviska/simpleimage/src/claviska/SimpleImage.php');
        $token = !empty($_GET['token']) ? $_GET['token'] : null;
        $section = 'Profile';

        $sql = "SELECT * FROM users WHERE token = ?";
        $stmt = conn()->prepare($sql);
        if ($stmt->execute([$token])) {
            $n = $stmt->rowCount();
            if ($n === 1) {
                $r = $stmt->fetch();
                $stmt = null;
            }
        } ?>

<body class="app">
  <?php require_once('includes/header.php'); ?>
  <main>
    <div class="container">
      <?php require_once('includes/menu.php'); ?>
      <div>
        <div class="section-title">
          <h1><?php echo $section; ?></h1>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?><?php if (!empty($token)) echo "?token=$token"; ?>" method="post" enctype="multipart/form-data">
          <fieldset>
            <ul>
              <li>
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo !empty($r['name']) ? $r['name'] : null ; ?>">
              </li>
              <li>
                <label for="email">E-mail</label>
                <input type="text" name="email" value="<?php echo !empty($r['email']) ? $r['email'] : null ; ?>">
              </li>
              <li>
                <label for="password">Password</label>
                <input type="password" name="password">
              </li>
              <li>
                <label for="cpassword">Password (confirmation)</label>
                <input type="password" name="cpassword">
              </li>
              <li>
                <label for="pic">Picture</label>
                <input type="file" name="pic" accept="image/x-png,image/gif,image/jpeg">
              </li>
            </ul>
          </fieldset>
          <fieldset>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <input type="submit" value="Save">
          </fieldset>
        </form>
        <?php
        if (!empty($_POST)) {
            $name         = $_POST['name'];
            $email        = $_POST['email'];
            $password     = $_POST['password'];
            $cpassword    = $_POST['cpassword'];
            $token        = $_POST['token'];

            $dir          = "users/$token/";
            $file         = $_FILES["pic"]["name"];


            $allows_ext   = array('jpg');
            $allows_size  = 1048576;

            $ext    = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            //$path   = $dir.basename($file);
            $path   = $dir.basename("$token.$ext");

            if (!empty($password) && $password === $cpassword && !empty($email)) {
                $password   = password_hash($_POST['cpassword'], PASSWORD_BCRYPT);

                if (in_array($ext, $allows_ext)) {
                    if ($_FILES["pic"]["size"] > $allows_size) {
                        echo "Uploaded file is huge (".$_FILES["pic"]["size"].")";
                    } else {
                        $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE token = ?";

                        $stmt = conn()->prepare($sql);
                        $stmt->bindValue(1, $name, PDO::PARAM_STR);
                        $stmt->bindValue(2, $email, PDO::PARAM_STR);
                        $stmt->bindValue(3, $password, PDO::PARAM_STR);
                        $stmt->bindValue(4, $token, PDO::PARAM_STR);

                        if ($stmt->execute()) {
                            $stmt = null;
                            if (!is_dir($dir)) {
                              mkdir($dir, false, true);
                            }
                            move_uploaded_file($_FILES["pic"]["tmp_name"], $path);
                            try {
                              // Create a new SimpleImage object
                              $image = new \claviska\SimpleImage();
                              $path80   = $dir.basename($token."-80x80.".$ext);
                              $path320   = $dir.basename($token."-320x320.".$ext);
                              // Magic! ✨
                              $image
                                ->fromFile($path)                     // load image.jpg
                                ->autoOrient()                              // adjust orientation based on exif data
                                ->resize(320, 320)                          // resize to 320x200 pixels
                                ->toFile($path320)      // convert to PNG and save a copy to new-image.png
                                ->resize(80, 80)                          // resize to 320x200 pixels
                                ->toFile($path80);      // convert to PNG and save a copy to new-image.png
                                header("Location: ../");
                              // And much more! 💪
                            } catch(Exception $err) {
                              // Handle errors
                              echo $err->getMessage();
                            }
                            exit;
                        }
                    }
                } else {
                    echo "Uploaded file is not a valid image";
                }
            } elseif ($password !== $cpassword) {
                echo "Passwords do not match";
            } else {
                echo "All fields are required";
            }
        } ?>
      </div>
    </div>
  </main>
  <?php require_once('includes/footer.php'); ?>

</body>
</html>


<?php
    } ?>