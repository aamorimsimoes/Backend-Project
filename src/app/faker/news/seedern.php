<?php

function seedernews($inputn)
  {
    $faker = Faker\Factory::create();
    
    for ($i = 0; $i < $inputn; $i++) {
      $name               = $faker->name;
      $email              = $faker->email;
      $password           = $faker->password;
      $status             = 1;
      $token              = $faker->uuid;
      $level              = 1;
      $registration_date  = $faker->date;

      $sql = "INSERT INTO news (name, email, password, status, token, level, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$name, $email, $password, $status, $token, $level, $registration_date]);
      $stmt = null;
    }
    echo $inputn . " dummy news created";
  }

  ?>