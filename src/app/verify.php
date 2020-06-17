<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style/main.css">
</head>
<body>
  <?php
  if (!empty($_GET['token']) && !empty($_GET['email'])) {
      $token   = $_GET['token'];
      $email   = $_GET['email'];

      $sql = "UPDATE users SET level=?, status=? WHERE email=? AND token=? AND status=?";

      $stmt = conn()->prepare($sql);
      if ($stmt->execute([1, 1, $email, $token, 0])) {
          $stmt = null;

          $dir = 'users/'.$token;
          if (!file_exists($dir)) {
              mkdir($dir, 0777, true);
          }


          echo "User verified!";

          $subject = 'Account verified';
          $message = '<a href=http://www.rbos.pt/>Signin into your account</a>';
          $output = '<p>A thank you message has been sent to '.$email.'</p>';

          email($email, $subject, $message, $output);
      }
  } else {
      echo "Parametros de confirmação em falta.";
  }

  ?>
</body>
</html>