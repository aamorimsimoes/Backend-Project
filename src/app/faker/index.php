<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  require_once('../functions.php');
  require_once('../includes/head.php');
  require_once('../faker/users/seederu.php');
  require_once('../faker/products/seederp.php');
  require_once('../faker/news/seedern.php');

  require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

  $section = 'faker'; ?>

  <body class="app">
    <?php require_once('../includes/header.php'); ?>
    <main>
      <div class="container">
        <?php require_once('../includes/menu.php'); ?>
        <div>
          <div class="section-title">
            <h1>Data Generator</h1>
          </div>

          <div>
            <h4>Click to create dummy users</h4>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method='post'>
              <input type="number" name="amount" placeholder="how many?" />
              <input type="hidden" name="create" value="users">
              <input type="submit" value="Create users" />
            </form>
          </div>
          <div>
            <h4>Click to create dummy news</h4>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method='post'>
              <input type="number" name="amount" placeholder="how many?" />
              <input type="hidden" name="create" value="news">
              <input type="submit" value="Create news" />
            </form>
          </div>
          <div>
            <h4>Click to create dummy products</h4>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method='post'>
              <input type="number" name="amount" placeholder="how many?" />
              <input type="hidden" name="create" value="products">
              <input type="submit" value="Create products" />
            </form>
          </div>

          <?php
          if (!empty($_POST['amount'])){
            switch ($_POST['create']) {
            case 'users':
              seederusers($_POST['amount']);
              break;
            case 'products':
              seederproducts($_POST['amount']);
              break;
            case 'news':
              seedernews($_POST['amount']);
              break;
            }
          }
          ?>

        </div>
      </div>
    </main>
    <?php require_once('../includes/footer.php'); ?>

  </body>

<?php

}
?>