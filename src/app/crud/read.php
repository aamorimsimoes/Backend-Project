<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  //'<br>Session: '.session_id().'<br><br><a href=signout.php>Sair</a>';
  require_once('../includes/head.php');
  require_once('../../vendor/claviska/simpleimage/src/claviska/SimpleImage.php');
?>

  <body class="app">
    <?php
    require_once('../includes/header.php');
    require_once('../functions.php');
    ?>
    <main>
      <div class="container">
        <?php require_once('../includes/menu.php');
        $section = !empty($_GET['s']) ? $_GET['s'] : null;
        $token = !empty($_GET['token']) ? $_GET['token'] : null;

        $sql = "SELECT * FROM " . $section . " WHERE token = ?";
        $stmt = conn()->prepare($sql);
        if ($stmt->execute([$token])) {
          $n = $stmt->rowCount();
          $data = $stmt->fetch();
          if (!empty($data)) {
        ?>
            <div class="flex flex-wrap justify-content-center align-items-start">
              <div class="card" style="position:relative;width:900px">
                <div style="border-radius:5px 5px 0 0;width:100%;height:500px;background-size:cover;background-image:url('http://<?= $_SERVER['HTTP_HOST'] ?>/app/includes/image.php?s=<?= $section ?>&token=<?= $data['token'] ?>');"></div>
                
                <div class="card-container">
                    <div>
                      <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>
                      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                  </p>
                  <h4><b><?= $data['title'] ?></b></h4>
                  <p><i><?= $data['summary'] ?></i></p>
                  <p><?= $data['body'] ?></p>
                  <div class="flex flex-right flex-center flex-wrap" style="margin-bottom:1em;">
                    <?php
                    $dir = "../uploads/" . $data['token'] . "/files/";
                    if (is_dir($dir)) {
                      $files = scandir($dir);
                      if (count($files) > 2) {
                        echo "<div><b><i>Files:</i></b></div>";
                        for ($i = 2; $i < count($files); $i++) {
                          $extension = strstr($files[$i], '.');
                    ?>
                          <a class="d-block" href="http://<?= $_SERVER['SERVER_NAME'] ?>/app/uploads/<?= $data['token'] ?>/files/<?= $files[$i] ?>"><img src="../../images/<?= ($extension == '.zip') ? 'zip' : 'pdf' ?>.svg" width="30" \></a>
                      <?php
                        }
                      }
                      ?>

                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        }
        require_once('../includes/footer.php');
        ?>
      </div>
    </main>
    <?php require_once('../includes/footer.php'); ?>
  </body>

  </html>

<?php } ?>