SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `s2itp2` ;
CREATE SCHEMA IF NOT EXISTS `s2itp2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `s2itp2` ;

-- -----------------------------------------------------
-- Table `s2itp2`.`Line`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`Line` (
  `idLine` INT NOT NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`idLine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `s2itp2`.`City`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`City` (
  `idCity` INT NOT NULL,
  `city_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idCity`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `s2itp2`.`Bus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`Bus` (
  `idBus` INT NOT NULL,
  `Line_idLine` INT NOT NULL,
  `model` VARCHAR(45) NULL,
  `latitude` VARCHAR(45) NULL,
  `longitude` VARCHAR(45) NULL,
  PRIMARY KEY (`idBus`, `Line_idLine`),
  INDEX `fk_Bus_Line1_idx` (`Line_idLine` ASC),
  CONSTRAINT `fk_Bus_Line1`
    FOREIGN KEY (`Line_idLine`)
    REFERENCES `s2itp2`.`Line` (`idLine`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `s2itp2`.`Pointer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`Pointer` (
  `idPointer` INT NOT NULL,
  `description` VARCHAR(45) NULL,
  `City_idCity` INT NOT NULL,
  `latitude` VARCHAR(45) NULL,
  `longitude` VARCHAR(45) NULL,
  PRIMARY KEY (`idPointer`, `City_idCity`),
  INDEX `fk_Pointer_City1_idx` (`City_idCity` ASC),
  CONSTRAINT `fk_Pointer_City1`
    FOREIGN KEY (`City_idCity`)
    REFERENCES `s2itp2`.`City` (`idCity`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `s2itp2`.`Route_has_Pointer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`Route_has_Pointer` (
  `Route_Line_idLine` INT NOT NULL,
  `Route_City_idCity` INT NOT NULL,
  PRIMARY KEY (`Route_Line_idLine`, `Route_City_idCity`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `s2itp2`.`Route`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `s2itp2`.`Route` (
  `Line_idLine` INT NOT NULL,
  `Pointer_idPointer` INT NOT NULL,
  `Pointer_City_idCity` INT NOT NULL,
  PRIMARY KEY (`Line_idLine`, `Pointer_idPointer`, `Pointer_City_idCity`),
  INDEX `fk_Line_has_Pointer_Pointer1_idx` (`Pointer_idPointer` ASC, `Pointer_City_idCity` ASC),
  INDEX `fk_Line_has_Pointer_Line1_idx` (`Line_idLine` ASC),
  CONSTRAINT `fk_Line_has_Pointer_Line1`
    FOREIGN KEY (`Line_idLine`)
    REFERENCES `s2itp2`.`Line` (`idLine`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Line_has_Pointer_Pointer1`
    FOREIGN KEY (`Pointer_idPointer` , `Pointer_City_idCity`)
    REFERENCES `s2itp2`.`Pointer` (`idPointer` , `City_idCity`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
