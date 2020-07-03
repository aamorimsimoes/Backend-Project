<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: signin.php');
  exit;
} else {
  require_once('../functions.php');
  require_once('../includes/head.php');
  $section = 'faker'; ?>

  <body class="app">
    <?php require_once('../includes/header.php'); ?>
    <main>
      <div class="container">
        <?php require_once('../includes/menu.php'); ?>
        <div>
          <div class="section-title">
            <h1>Data Generator</h1>
            <div>
              <a class="button" onclick="">
                <svg viewBox="0 0 24 24" width="24" height="24">
                  <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11H7v2h4v4h2v-4h4v-2h-4V7h-2v4z" /></svg>Add</a>
            </div>
          </div>

          <table>
            <thead>
              <tr>
                <th>generate fake users</th>
                <th>Title</th>
                <th>Date</th>
                
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>foo</th>
                <th>foo</th>
                <th>foo</th>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td>foo1</td>
                <td>foo2</td>
                <td>foo2</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </main>
    <?php require_once('../includes/footer.php'); ?>

  </body>

<?php

  require_once "../../vendor/autoload.php";
  require_once '../app/functions.php';

  
  function seederusers()
  {
    $faker = Faker\Factory::create();
    
    $input = 10;

    for ($i = 0; $i < $input; $i++) {
      $name               = $faker->name;
      $email              = $faker->email;
      $password           = $faker->password;
      $status             = 1;
      $token              = $faker->uuid;
      $level              = 1;
      $registration_date  = $faker->date;

      $sql = "INSERT INTO users (name, email, password, status, token, level, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$name, $email, $password, $status, $token, $level, $registration_date]);
      $stmt = null;
    }
  }
}
?>