<header>
  <div class="container">
    <div class="profile">
      <?php
      $utoken = $_SESSION['token'];
      if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/uploads/avatar/$utoken/$utoken-80x80.jpeg")) { // FIXME
        echo "<img class='avatar' src='uploads/avatar/$utoken/$utoken-80x80.jpeg' >";
      }
      echo "<div>" . empty($_SESSION['name']) === true ? $_SESSION['email'] : $_SESSION['name'] . "</div>";
      ?>
    </div>
  </div>
</header>