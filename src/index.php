<?php
  header('Location: /app');
  exit;




  $arrA = array('João', 'Matilde', 2);
  $user = array('name'=>'Jorge', 'email'=>'jorgegamito@gmail.com', 'level'=>2);

  $colors = array(
    array('Amarelo', 'fome', 'energia'),
    array('Vermelho', 'paixão', 'energia'),
    array('Azul', 'serenidade', 'tecnologia'),
    array('Preto', 'luxo', 'morte')
  );

  //echo $arrA[0];
  //echo $user['name'];

  //echo $colors[2][1];
  //echo '<pre>';
  //var_dump($colors);
  //echo '</pre>';



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <?php

  function basic_validation($p)
  {
      $input = trim($p);
      $input = stripslashes($p);
      $input = htmlspecialchars($p);
      return $input;
  }


  if (!empty($_POST['firstname'])) {
      $firstname = basic_validation($_POST['firstname']);
  }
  if (!empty($_POST['lastname'])) {
      $lastname = basic_validation($_POST['lastname']);
  }
  ?>

  <form action="" method="post">
    <input type="text" name="firstname" value="<?php echo $firstname; ?>">
    <input type="text" name="lastname" value="<?php echo $lastname; ?>">
    <input type="submit" value="Enviar">
  </form>

  <?php
  if (!empty($_POST)) {
      echo "Primeiro nome: ". $_POST['firstname']."<br>";
      echo "Último nome: ".$lastname;
  }?>
</body>

</html>