<?php
require_once('functions.php');
require_once('includes/head.php');

?>
<body>
  <main>
    <div class="container auth">
      <div>
        <h1>Company STA App®</h1>
        <form action="signin.php" method="post">
        <fieldset>
          <ul>
            <li>
              <label for="email">E-mail</label>
              <input type="text" name="email"></li>
            <li>
              <label for="password">Password</label>
              <input type="password" name="password"></li>
          </ul>
        </fieldset>
        <fieldset>
          <input type="submit" value="Signin">
        </fieldset>
      </form>
      <a href="signup.php">Signup</a> | <a href="reset.php">Reset password</a><br><br>

      <?php

        if (!empty($_POST)) {
            $password   = $_POST['password'];
            $email      = $_POST['email'];

            if (!empty($password) && !empty($email)) {
                $sql = "SELECT email, password, token, level, name, id FROM users WHERE email = ? AND level > ? AND status > ? LIMIT 1";

                $stmt = conn()->prepare($sql);
                if ($stmt->execute([$email, 0, 0])) {
                    $n = $stmt->rowCount();
                    $r = $stmt->fetch();

                    $stmt = null;

                    if ($n === 1 && password_verify($password, $r['password'])) {
                        session_start();
                        //session_regenerate_id();

                        $_SESSION['loggedin'] = true;

                        $_SESSION['email'] = $r['email'];
                        $_SESSION['token'] = $r['token'];
                        $_SESSION['level'] = $r['level'];
                        $_SESSION['name'] = $r['name'];
                        $_SESSION['usersid'] = $r['id'];

                        header("Location: home.php");
                    } else {
                        echo 'A autenticação falhou.';
                    }
                }
            } else {
                echo "All fields are required";
            }
        }
        ?>
      </div>
    </div>
  </main>
  <?php require_once('includes/footer.php'); ?>
</body>
</html>