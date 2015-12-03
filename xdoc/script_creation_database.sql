-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema intothewhile
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema intothewhile
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `intothewhile` DEFAULT CHARACTER SET utf8 ;
USE `intothewhile` ;

-- -----------------------------------------------------
-- Table `intothewhile`.`COORDONNEES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`COORDONNEES` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LONGITUDE` FLOAT NOT NULL,
  `LATITUDE` FLOAT NOT NULL,
  `REGION` VARCHAR(45) NULL,
  `PAYS` VARCHAR(45) NULL,
  `VILLE` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`USER` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `IDENTIFIANT` VARCHAR(45) NOT NULL,
  `PASSWORD` VARCHAR(45) NOT NULL,
  `PROFIL` VARCHAR(20) NOT NULL,
  `NUMERO` VARCHAR(15) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `HOME`
    FOREIGN KEY ()
    REFERENCES `intothewhile`.`COORDONNEES` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `LAST_POS`
    FOREIGN KEY ()
    REFERENCES `intothewhile`.`COORDONNEES` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `intothewhile`.`EVENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`EVENT` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIBELLE` VARCHAR(100) NOT NULL,
  `RAYON` FLOAT NULL,
  `CURRENTLY` TINYINT(1) NOT NULL,
  `CHECKED` TINYINT(1) NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `LIEU`
    FOREIGN KEY ()
    REFERENCES `intothewhile`.`COORDONNEES` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`ABONNEMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`ABONNEMENT` (
  `EVENT_ID` INT NOT NULL,
  `USER_ID` INT NOT NULL,
  PRIMARY KEY (`EVENT_ID`, `USER_ID`),
  INDEX `fk_EVENT_has_USER_USER1_idx` (`USER_ID` ASC),
  INDEX `fk_EVENT_has_USER_EVENT1_idx` (`EVENT_ID` ASC),
  CONSTRAINT `fk_EVENT_has_USER_EVENT1`
    FOREIGN KEY (`EVENT_ID`)
    REFERENCES `intothewhile`.`EVENT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EVENT_has_USER_USER1`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `intothewhile`.`USER` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`LIEN_UTILE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`LIEN_UTILE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIEN` TEXT NOT NULL,
  `POIDS` INT NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`MESSAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`MESSAGE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `CONTENU` TEXT NOT NULL,
  `HEURE` DATETIME NOT NULL,
  `ID_EVENT` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_MESSAGE_EVENT1_idx` (`ID_EVENT` ASC),
  CONSTRAINT `fk_MESSAGE_EVENT1`
    FOREIGN KEY (`ID_EVENT`)
    REFERENCES `intothewhile`.`EVENT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`TWEET`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`TWEET` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIEN` TEXT NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`HASHTAG`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`HASHTAG` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIBELLE` VARCHAR(140) NULL,
  `HASHTAGcol` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`MOT_CLE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`MOT_CLE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIBELLE` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`TYPE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`TYPE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `LIBELLE` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`INFORMER1`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`INFORMER1` (
  `MESSAGE_ID` INT NOT NULL,
  `LIEN_UTILE_ID` INT NOT NULL,
  PRIMARY KEY (`MESSAGE_ID`, `LIEN_UTILE_ID`),
  INDEX `fk_MESSAGE_has_LIEN_UTILE_LIEN_UTILE1_idx` (`LIEN_UTILE_ID` ASC),
  INDEX `fk_MESSAGE_has_LIEN_UTILE_MESSAGE1_idx` (`MESSAGE_ID` ASC),
  CONSTRAINT `fk_MESSAGE_has_LIEN_UTILE_MESSAGE1`
    FOREIGN KEY (`MESSAGE_ID`)
    REFERENCES `intothewhile`.`MESSAGE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MESSAGE_has_LIEN_UTILE_LIEN_UTILE1`
    FOREIGN KEY (`LIEN_UTILE_ID`)
    REFERENCES `intothewhile`.`LIEN_UTILE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`INFORMER2`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`INFORMER2` (
  `EVENT_ID` INT NOT NULL,
  `LIEN_UTILE_ID` INT NOT NULL,
  PRIMARY KEY (`EVENT_ID`, `LIEN_UTILE_ID`),
  INDEX `fk_EVENT_has_LIEN_UTILE_LIEN_UTILE1_idx` (`LIEN_UTILE_ID` ASC),
  INDEX `fk_EVENT_has_LIEN_UTILE_EVENT1_idx` (`EVENT_ID` ASC),
  CONSTRAINT `fk_EVENT_has_LIEN_UTILE_EVENT1`
    FOREIGN KEY (`EVENT_ID`)
    REFERENCES `intothewhile`.`EVENT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EVENT_has_LIEN_UTILE_LIEN_UTILE1`
    FOREIGN KEY (`LIEN_UTILE_ID`)
    REFERENCES `intothewhile`.`LIEN_UTILE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`DESIGNER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`DESIGNER` (
  `EVENT_ID` INT NOT NULL,
  `TWEET_ID` INT NOT NULL,
  PRIMARY KEY (`EVENT_ID`, `TWEET_ID`),
  INDEX `fk_EVENT_has_TWEET_TWEET1_idx` (`TWEET_ID` ASC),
  INDEX `fk_EVENT_has_TWEET_EVENT1_idx` (`EVENT_ID` ASC),
  CONSTRAINT `fk_EVENT_has_TWEET_EVENT1`
    FOREIGN KEY (`EVENT_ID`)
    REFERENCES `intothewhile`.`EVENT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EVENT_has_TWEET_TWEET1`
    FOREIGN KEY (`TWEET_ID`)
    REFERENCES `intothewhile`.`TWEET` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`CONTENIR`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`CONTENIR` (
  `TWEET_ID` INT NOT NULL,
  `HASHTAG_ID` INT NOT NULL,
  PRIMARY KEY (`TWEET_ID`, `HASHTAG_ID`),
  INDEX `fk_TWEET_has_HASHTAG_HASHTAG1_idx` (`HASHTAG_ID` ASC),
  INDEX `fk_TWEET_has_HASHTAG_TWEET1_idx` (`TWEET_ID` ASC),
  CONSTRAINT `fk_TWEET_has_HASHTAG_TWEET1`
    FOREIGN KEY (`TWEET_ID`)
    REFERENCES `intothewhile`.`TWEET` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TWEET_has_HASHTAG_HASHTAG1`
    FOREIGN KEY (`HASHTAG_ID`)
    REFERENCES `intothewhile`.`HASHTAG` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`DONNER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`DONNER` (
  `HASHTAG_ID` INT NOT NULL,
  `MOT_CLE_ID` INT NOT NULL,
  PRIMARY KEY (`HASHTAG_ID`, `MOT_CLE_ID`),
  INDEX `fk_HASHTAG_has_MOT_CLE_MOT_CLE1_idx` (`MOT_CLE_ID` ASC),
  INDEX `fk_HASHTAG_has_MOT_CLE_HASHTAG1_idx` (`HASHTAG_ID` ASC),
  CONSTRAINT `fk_HASHTAG_has_MOT_CLE_HASHTAG1`
    FOREIGN KEY (`HASHTAG_ID`)
    REFERENCES `intothewhile`.`HASHTAG` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_HASHTAG_has_MOT_CLE_MOT_CLE1`
    FOREIGN KEY (`MOT_CLE_ID`)
    REFERENCES `intothewhile`.`MOT_CLE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`REFERER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`REFERER` (
  `MOT_CLE_ID` INT NOT NULL,
  `TYPE_ID` INT NOT NULL,
  PRIMARY KEY (`MOT_CLE_ID`, `TYPE_ID`),
  INDEX `fk_MOT_CLE_has_TYPE_TYPE1_idx` (`TYPE_ID` ASC),
  INDEX `fk_MOT_CLE_has_TYPE_MOT_CLE1_idx` (`MOT_CLE_ID` ASC),
  CONSTRAINT `fk_MOT_CLE_has_TYPE_MOT_CLE1`
    FOREIGN KEY (`MOT_CLE_ID`)
    REFERENCES `intothewhile`.`MOT_CLE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MOT_CLE_has_TYPE_TYPE1`
    FOREIGN KEY (`TYPE_ID`)
    REFERENCES `intothewhile`.`TYPE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intothewhile`.`SE_RAPPORTER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intothewhile`.`SE_RAPPORTER` (
  `TYPE_ID` INT NOT NULL,
  `EVENT_ID` INT NOT NULL,
  PRIMARY KEY (`TYPE_ID`, `EVENT_ID`),
  INDEX `fk_TYPE_has_EVENT_EVENT1_idx` (`EVENT_ID` ASC),
  INDEX `fk_TYPE_has_EVENT_TYPE1_idx` (`TYPE_ID` ASC),
  CONSTRAINT `fk_TYPE_has_EVENT_TYPE1`
    FOREIGN KEY (`TYPE_ID`)
    REFERENCES `intothewhile`.`TYPE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TYPE_has_EVENT_EVENT1`
    FOREIGN KEY (`EVENT_ID`)
    REFERENCES `intothewhile`.`EVENT` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
