<?php

//require_once('../../functions.php');

function seederproducts($input)
  {
    $faker = Faker\Factory::create();
    
    for ($i = 0; $i < $input; $i++) {
      $title         = $faker->sentence($nbWords = 3, $variableNbWords = true);
      $summary       = $faker->sentence($nbWords = 6, $variableNbWords = true);
      $body          = $faker->text($maxNbChars = 400);
      $date          = $faker->date;
      $token         = $faker->uuid;
      $status        = $faker->numberBetween($min = 0, $max = 2);
      $categories_id = $faker->numberBetween($min = 1, $max = 3);
      $users_id      = 1;

      $sql = "INSERT INTO products (title, summary, body, date, token, status, categories_id, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$title, $summary, $body, $date, $token, $status, $categories_id, $users_id]);
      $stmt = null;
    }
    echo $input . " dummy products created";
  }
  
  ?>