-- MySQL Script generated by MySQL Workbench
-- Thu Jun 18 18:42:47 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema company_sta
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema company_sta
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `company_sta` DEFAULT CHARACTER SET utf8 ;
USE `company_sta` ;

-- -----------------------------------------------------
-- Table `company_sta`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(254) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `status` INT(11) NOT NULL,
  `token` VARCHAR(128) NOT NULL,
  `level` INT(11) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_sta`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_sta`.`machines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`machines` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `content` TEXT NOT NULL,
  `published_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `categories_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `categories_id`),
  INDEX `fk_machines_categories1_idx` (`categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_machines_categories1`
    FOREIGN KEY (`categories_id`)
    REFERENCES `company_sta`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_sta`.`news`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`news` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `summary` VARCHAR(1000) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `date` DATE NOT NULL,
  `author` VARCHAR(50) NOT NULL,
  `token` VARCHAR(40) NOT NULL,
  `status` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_sta`.`images_machines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`images_machines` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` INT UNSIGNED NOT NULL,
  `machines_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `users_id`, `machines_id`),
  INDEX `fk_users_has_machines_machines1_idx` (`machines_id` ASC) VISIBLE,
  INDEX `fk_users_has_machines_users_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_machines_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `company_sta`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_machines_machines1`
    FOREIGN KEY (`machines_id`)
    REFERENCES `company_sta`.`machines` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_sta`.`images_news`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_sta`.`images_news` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` INT UNSIGNED NOT NULL,
  `news_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `users_id`, `news_id`),
  INDEX `fk_users_has_news_news1_idx` (`news_id` ASC) VISIBLE,
  INDEX `fk_users_has_news_users1_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_news_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `company_sta`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_news_news1`
    FOREIGN KEY (`news_id`)
    REFERENCES `company_sta`.`news` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
