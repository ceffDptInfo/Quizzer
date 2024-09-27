-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema quizzer
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `quizzer` ;

-- -----------------------------------------------------
-- Schema quizzer
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `quizzer` DEFAULT CHARACTER SET utf8mb3 ;
USE `quizzer` ;

-- -----------------------------------------------------
-- Table `quizzer`.`game`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizzer`.`game` ;

CREATE TABLE IF NOT EXISTS `quizzer`.`game` (
  `idGame` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Code` VARCHAR(4) NOT NULL,
  `Status` VARCHAR(45) NOT NULL DEFAULT 'en attente',
  `QuestionID` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idGame`),
  UNIQUE INDEX `idGame_UNIQUE` (`idGame` ASC) VISIBLE,
  UNIQUE INDEX `Code_UNIQUE` (`Code` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `quizzer`.`player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizzer`.`player` ;

CREATE TABLE IF NOT EXISTS `quizzer`.`player` (
  `idPlayer` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(45) NOT NULL,
  `Points` INT NOT NULL DEFAULT '0',
  `Color` VARCHAR(6) NOT NULL DEFAULT 'red',
  `Game_idGame` INT UNSIGNED NOT NULL,
  `timestamp` INT NOT NULL,
  `rep` INT NULL,
  `time` INT NULL,
  PRIMARY KEY (`idPlayer`),
  UNIQUE INDEX `UniqueID` (`Username` ASC, `Color` ASC, `Game_idGame` ASC) VISIBLE,
  INDEX `fk_Player_Game_idx` (`Game_idGame` ASC) INVISIBLE,
  CONSTRAINT `fk_Player_Game`
    FOREIGN KEY (`Game_idGame`)
    REFERENCES `quizzer`.`game` (`idGame`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `quizzer`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizzer`.`question` ;

CREATE TABLE IF NOT EXISTS `quizzer`.`question` (
  `idquestion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Rep1` VARCHAR(45) NOT NULL,
  `Rep2` VARCHAR(45) NOT NULL,
  `Rep3` VARCHAR(45) NULL DEFAULT NULL,
  `Rep4` VARCHAR(45) NULL DEFAULT NULL,
  `game_idGame` INT UNSIGNED NOT NULL,
  `QuestionNumber` INT NOT NULL,
  PRIMARY KEY (`idquestion`),
  UNIQUE INDEX `idquestion_UNIQUE` (`idquestion` ASC) VISIBLE,
  INDEX `fk_question_game_idx` (`game_idGame` ASC) VISIBLE,
  CONSTRAINT `fk_question_game`
    FOREIGN KEY (`game_idGame`)
    REFERENCES `quizzer`.`game` (`idGame`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
