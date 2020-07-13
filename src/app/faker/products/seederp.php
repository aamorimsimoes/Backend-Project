<?php

function seederproducts($input)
  {
    $faker = Faker\Factory::create();
    $faker = Faker\Factory::create();
    $sql = "SET FOREIGN_KEY_CHECKS = 0";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "TRUNCATE TABLE products";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "SET FOREIGN_KEY_CHECKS = 1";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    deleteDirectory ($_SERVER['DOCUMENT_ROOT']."/app/uploads/products");
    
    for ($i = 0; $i < $input; $i++) {
      $title         = $faker->sentence($nbWords = 3, $variableNbWords = true);
      $summary       = $faker->sentence($nbWords = 6, $variableNbWords = true);
      $body          = $faker->text($maxNbChars = 400);
      $date          = $faker->date;
      $token         = $faker->uuid;
      $status        = $faker->numberBetween($min = 0, $max = 2);
      $categories_id = $faker->numberBetween($min = 1, $max = 3);
      $users_id      = 1;
      mkdir($_SERVER['DOCUMENT_ROOT']."/app/uploads/products/$token/",0777,true);
      $image      = $faker->image($_SERVER['DOCUMENT_ROOT']."/app/uploads/products/$token", 800, 600, null, false);
      rename ($_SERVER['DOCUMENT_ROOT']."/app/uploads/products/$token/".$image, $_SERVER['DOCUMENT_ROOT']."/app/uploads/products/$token/1.jpg");

      $sql = "INSERT INTO products (title, summary, body, date, token, status, categories_id, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$title, $summary, $body, $date, $token, $status, $categories_id, $users_id]);
      $stmt = null;
    }
    echo $input . " dummy products created";
  }
  
  ?>