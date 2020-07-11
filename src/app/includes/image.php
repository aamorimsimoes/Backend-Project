<?php
require_once('../../vendor/claviska/simpleimage/src/claviska/SimpleImage.php');
$image = new \claviska\SimpleImage();
if (!empty($_GET['token'])) {
            // Magic! ✨
            $fileName = 1;
            $dir = "";
            if ($_GET['s'] === "news") {
              $dir .= "news";
            } else if ($_GET['s'] === "products") {
              $dir .= "products";
            }
           // echo $_SERVER['DOCUMENT_ROOT']."/app/uploads/".$dir."/".$_GET['token'].'/'.$fileName.'.jpg';
            //die();
            $image
              ->fromFile($_SERVER['DOCUMENT_ROOT']."/app/uploads/".$dir."/".$_GET['token'].'/'.$fileName.'.jpg')
              ->autoOrient()
              ->resize(900)
              ->toScreen();  
}
?>