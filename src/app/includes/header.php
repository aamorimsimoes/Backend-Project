<header>
  <div class="container">
    <div class="profile">
      <?php
      $utoken = $_SESSION['token'];
      if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/users/$utoken/$utoken.jpg")) {
        echo "<img class='avatar' src='http://".$_SERVER['SERVER_NAME']."/app/users/$utoken/$utoken.jpg' >";
      }
      echo "<div>" . $_SESSION['email'] . "</div>";
      ?>
    </div>
    <div></div>
  </div>
</header>