<?php

function seederusers($input)
  {
    $faker = Faker\Factory::create();
    $sql = "SET GLOBAL FOREIGN_KEY_CHECKS = 0";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "TRUNCATE TABLE users";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $sql = "SET GLOBAL FOREIGN_KEY_CHECKS = 1";
    $stmt = conn()->prepare($sql);
    $stmt->execute();
    $name = 'Amorim+Admin';
    $email = 'andreamorimsimoes@gmail.com';
    $password = password_hash("123",PASSWORD_BCRYPT);
    $status = 1;
    $token = $faker->uuid;
    $level = 2;
    deleteDirectory('../uploads/avatar');
    
    $sql = "INSERT INTO users (name, email, password, status, token, level) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = conn()->prepare($sql);
    $stmt->execute([$name, $email, $password, $status, $token, $level]);
    
    for ($i = 0; $i < $input; $i++) {
      $name               = $faker->name;
      $email              = $faker->email;
      $password           = $faker->password;
      //$password           = password_hash($password,PASSWORD_BCRYPT);
      $status             = $faker->numberBetween($min = 0, $max = 1);
      $token              = $faker->uuid;
      $level              = 1;
      $registration_date  = $faker->date() . ' ' . $faker->time();

      $sql = "INSERT INTO users (name, email, password, status, token, level, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = conn()->prepare($sql);
      $stmt->execute([$name, $email, $password, $status, $token, $level, $registration_date]);
      $stmt = null;
    }
    echo $input . " dummy users created";
  }

  ?>