SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `cmsrs` ;
CREATE SCHEMA IF NOT EXISTS `cmsrs` DEFAULT CHARACTER SET utf8 ;
USE `cmsrs` ;

-- -----------------------------------------------------
-- Table `cmsrs`.`menus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cmsrs`.`menus` ;

CREATE TABLE IF NOT EXISTS `cmsrs`.`menus` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `published` TINYINT(4) NOT NULL DEFAULT 1,
  `position` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cmsrs`.`pages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cmsrs`.`pages` ;

CREATE TABLE IF NOT EXISTS `cmsrs`.`pages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `published` TINYINT(4) NOT NULL DEFAULT 1,
  `is_left_menu` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '1 is left menu',
  `is_intro_text` INT(11) NOT NULL DEFAULT 0 COMMENT 'position intro text on the main page',
  `is_deleted` TINYINT(4) NOT NULL DEFAULT 1 COMMENT 'main site is not deleted',
  `menus_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pages_menus1`
    FOREIGN KEY (`menus_id`)
    REFERENCES `cmsrs`.`menus` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 62
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_pages_menus1_idx` ON `cmsrs`.`pages` (`menus_id` ASC);


-- -----------------------------------------------------
-- Table `cmsrs`.`contents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cmsrs`.`contents` ;

CREATE TABLE IF NOT EXISTS `cmsrs`.`contents` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL COMMENT 'main contten on the page',
  `lang` VARCHAR(11) NOT NULL,
  `pages_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_contents_pages1`
    FOREIGN KEY (`pages_id`)
    REFERENCES `cmsrs`.`pages` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 138
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_contents_pages1_idx` ON `cmsrs`.`contents` (`pages_id` ASC);

CREATE UNIQUE INDEX `uniq_lang_page` USING BTREE ON `cmsrs`.`contents` (`lang` ASC, `pages_id` ASC);


-- -----------------------------------------------------
-- Table `cmsrs`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cmsrs`.`images` ;

CREATE TABLE IF NOT EXISTS `cmsrs`.`images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'sanitaze file name (without special sign)',
  `no` INT(11) NOT NULL,
  `pages_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_images_pages`
    FOREIGN KEY (`pages_id`)
    REFERENCES `cmsrs`.`pages` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 876
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_images_pages_idx` ON `cmsrs`.`images` (`pages_id` ASC);


-- -----------------------------------------------------
-- Table `cmsrs`.`translates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cmsrs`.`translates` ;

CREATE TABLE IF NOT EXISTS `cmsrs`.`translates` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `lang` VARCHAR(11) NOT NULL,
  `type` ENUM('menu_short_title','page_short_title','page_title','page_intro_text','image_desc') NOT NULL COMMENT 'show description aministraition panel',
  `pages_id` INT(11) NULL COMMENT 'null is allowed',
  `menus_id` INT(11) NULL COMMENT 'null is allowed',
  `images_id` INT(11) NULL COMMENT 'null is allowed',
  `value` VARCHAR(512) NOT NULL COMMENT 'value of translate',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_translates_images1`
    FOREIGN KEY (`images_id`)
    REFERENCES `cmsrs`.`images` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_translates_menus1`
    FOREIGN KEY (`menus_id`)
    REFERENCES `cmsrs`.`menus` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_translates_pages1`
    FOREIGN KEY (`pages_id`)
    REFERENCES `cmsrs`.`pages` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1777
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_translates_images1_idx` ON `cmsrs`.`translates` (`images_id` ASC);

CREATE INDEX `fk_translates_menus1_idx` ON `cmsrs`.`translates` (`menus_id` ASC);

CREATE INDEX `fk_translates_pages1_idx` ON `cmsrs`.`translates` (`pages_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
