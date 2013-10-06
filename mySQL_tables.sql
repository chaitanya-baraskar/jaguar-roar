SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `jungle` DEFAULT CHARACTER SET utf8 ;
USE `jungle` ;

-- -----------------------------------------------------
-- Table `jungle`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `jungle`.`users` ;

CREATE TABLE IF NOT EXISTS `jungle`.`users` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(256) NOT NULL,
  `email` VARCHAR(256) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 3;


-- -----------------------------------------------------
-- Table `jungle`.`roars`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `jungle`.`roars` ;

CREATE TABLE IF NOT EXISTS `jungle`.`roars` (
  `body` VARCHAR(360) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` INT(10) NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = MyISAM
AUTO_INCREMENT = 32;


-- -----------------------------------------------------
-- Table `jungle`.`sheep`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `jungle`.`sheep` ;

CREATE TABLE IF NOT EXISTS `jungle`.`sheep` (
  `sheep_id` INT(11) NOT NULL,
  `users_id` INT(10) NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  INDEX `fk_sheep_users1_idx` (`users_id` ASC),
  PRIMARY KEY (`id`))
ENGINE = MyISAM;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
