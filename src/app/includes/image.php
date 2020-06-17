<?php
require_once('../../vendor/claviska/simpleimage/src/claviska/SimpleImage.php');
$image = new \claviska\SimpleImage();
if (!empty($_GET['token'])) {
            // Magic! ✨
            ($_GET['s'] == 'news') ? $file = $_GET['token'] : $file = 1;
            $image
              ->fromFile('../uploads/'.$_GET['token'].'/images/'.$file.'.jpg')
              ->autoOrient()
              ->resize(900)
              ->toScreen();  
}
?>