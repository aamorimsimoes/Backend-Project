<?php

function seedernews($input)
  {
    $faker = Faker\Factory::create();
    $faker = Faker\Factory::create();
    $sql = "SET GLOBAL FOREIGN_KEY_CHECKS = 0";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "TRUNCATE TABLE news";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "SET GLOBAL FOREIGN_KEY_CHECKS = 1";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    
    for ($i = 0; $i < $input; $i++) {
      $title      = $faker->sentence($nbWords = 3, $variableNbWords = true);
      $summary    = $faker->sentence($nbWords = 6, $variableNbWords = true);
      $body       = $faker->text($maxNbChars = 400);
      $date       = $faker->date;
      $author     = $faker->name;
      $token      = $faker->uuid;
      $status     = $faker->numberBetween($min = 0, $max = 2);
      $users_id   = 1; // RANDOM USER INSERT PRODUCTS OR NEWS

      $sql = "INSERT INTO news (title, summary, body, date, author, token, status, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$title, $summary, $body, $date, $author, $token, $status, $users_id]);
      $stmt = null;
    }
    echo $input . " dummy news created";
  }

  ?>