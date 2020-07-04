<?php

function seederusers($input)
  {
    $faker = Faker\Factory::create();

    for ($i = 0; $i < $input; $i++) {
      $name               = $faker->name;
      $email              = $faker->email;
      $password           = $faker->password;
      $status             = $faker->numberBetween($min = 0, $max = 1);
      $token              = $faker->uuid;
      $level              = 1;
      $registration_date  = $faker->date;

      $sql = "INSERT INTO users (name, email, password, status, token, level, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$name, $email, $password, $status, $token, $level, $registration_date]);
      $stmt = null;
    }
    echo $input . " dummy users created";
  }

  ?>