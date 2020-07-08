<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  require_once('includes/head.php'); ?>

  <body class="app">
    <?php
    require_once('includes/header.php');
    require_once('functions.php');
    ?>
    <main>
      <div class="container">
        <?php require_once('includes/menu.php'); ?>
        <div class="flex flex-wrap justify-content-center align-items-start">
          <?php
          $sql = "SELECT * FROM news WHERE status = 2 ORDER BY date DESC LIMIT 6"; // NOTE If you want to limit the number os news to show: ORDER BY date DESC LIMIT (number of news to publish)
          $stmt = conn()->prepare($sql);
          if ($stmt->execute()) {
            $n = $stmt->rowCount();
            if ($n > 0) {
              echo "<h1 style='width:100%;display:block;text-align:center'>Latest News:</h1>";
              $data = $stmt->fetchAll();
              $stmt = null;
              foreach ($data as $r) { ?>
                <div class="card" onclick="location.href='crud/read.php?s=news&token=<?= $r['token'] ?>'" style="cursor: pointer;">
                  <img src="uploads/<?= $r['token'] ?>/1.jpg" alt="newsImage" style="width:100%">
                  <div class="card-container">
                    <p style="font-size:smaller;display:flex;align-items:center">by <?= $r['author'] ?> on <?= $r['date'] ?></p>
                    <h4><b><?= $r['title'] ?></b></h4>
                    <p><?= $r['summary'] ?></p>
                  </div>
                </div>
          <?php
              }
            }
          }
          ?>
          <?php
          $sql = "SELECT * FROM products WHERE status = 2 ORDER BY date DESC LIMIT 6";
          $stmt = conn()->prepare($sql);
          if ($stmt->execute()) {
            $n = $stmt->rowCount();
            if ($n > 0) {
              echo "<h1 style='width:100%;display:block;text-align:center'>Latest products:</h1>";
              $data = $stmt->fetchAll();
              $stmt = null;
              foreach ($data as $r) { ?>
                <div class="card" onclick="location.href='crud/read.php?s=products&token=<?= $r['token'] ?>'" style="cursor: pointer;">
                  <img src="uploads/<?= $r['token'] ?>/1.jpg" alt="productsImage" style="width:100%">
                  <div class="card-container">
                    <p style="font-size:smaller;display:flex;align-items:center">by <?= $r['author'] ?> on <?= $r['date'] ?></p>
                    <h4><b><?= $r['title'] ?></b></h4>
                    <p><?= $r['summary'] ?></p>
                  </div>
                </div>
          <?php
              }
            }
          }
          ?>
        </div>
    </main>
    <?php require_once('includes/footer.php'); ?>
  </body>

  </html>



<?php
} ?>