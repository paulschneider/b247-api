SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `b247-com` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `b247-com` ;

-- -----------------------------------------------------
-- Table `b247-com`.`content_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`content_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`asset`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`asset` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `filepath` VARCHAR(150) NOT NULL,
  `alt` VARCHAR(100) NULL,
  `title` VARCHAR(150) NULL,
  `width` INT NULL,
  `height` INT NULL,
  `filesize` INT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`sponsor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`sponsor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `image_id` INT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `url` VARCHAR(150) NULL,
  `display_start` DATETIME NULL,
  `display_end` DATETIME NULL,
  `impressions` INT NULL,
  `clicks` INT NULL,
  `is_mobile` TINYINT NULL,
  `is_tablet` TINYINT NULL,
  `is_desktop` TINYINT NULL,
  `is_deleted` TINYINT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `sponsor -> image_idx` (`image_id` ASC),
  CONSTRAINT `sponsor -> image`
    FOREIGN KEY (`image_id`)
    REFERENCES `b247-com`.`asset` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`venue`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`venue` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `sef_name` VARCHAR(100) NULL,
  `address_line_1` VARCHAR(50) NOT NULL,
  `address_line_2` VARCHAR(50) NOT NULL,
  `address_line_3` VARCHAR(50) NULL,
  `postcode` VARCHAR(15) NOT NULL,
  `email` VARCHAR(150) NULL,
  `lat` VARCHAR(20) NULL,
  `lon` VARCHAR(20) NULL,
  `area` VARCHAR(75) NULL,
  `facebook` VARCHAR(75) NULL,
  `twitter` VARCHAR(75) NULL,
  `phone` VARCHAR(30) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`event` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `venue_id` INT NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `sef_name` VARCHAR(150) NULL,
  `show_date` DATE NULL,
  `show_time` TIME NULL,
  `price` FLOAT(8,2) NULL,
  `url` VARCHAR(150) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `event -> venue_idx` (`venue_id` ASC),
  CONSTRAINT `event -> venue`
    FOREIGN KEY (`venue_id`)
    REFERENCES `b247-com`.`venue` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content_type` INT NOT NULL,
  `sponsor_id` INT NULL,
  `event_id` INT NULL,
  `author_id` INT NULL,
  `title` VARCHAR(255) NULL,
  `sef_name` VARCHAR(255) NULL,
  `sub_heading` VARCHAR(150) NULL,
  `body` TEXT NULL,
  `postcode` VARCHAR(15) NULL,
  `lat` VARCHAR(20) NULL,
  `lon` VARCHAR(20) NULL,
  `area` VARCHAR(75) NULL,
  `impressions` INT NULL,
  `is_active` TINYINT NULL,
  `is_featured` TINYINT NULL,
  `is_picked` TINYINT NULL,
  `is_deleted` TINYINT NULL,
  `is_comments` TINYINT NULL,
  `is_approved` TINYINT NULL,
  `published` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `channel -> content_type_idx` (`content_type` ASC),
  INDEX `article -> sponsor_idx` (`sponsor_id` ASC),
  INDEX `article -> event_idx` (`event_id` ASC),
  CONSTRAINT `channel -> content_type`
    FOREIGN KEY (`content_type`)
    REFERENCES `b247-com`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `article -> sponsor`
    FOREIGN KEY (`sponsor_id`)
    REFERENCES `b247-com`.`sponsor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `article -> event`
    FOREIGN KEY (`event_id`)
    REFERENCES `b247-com`.`event` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`keyword`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`keyword` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `keyword` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content_type` INT NOT NULL,
  `icon_img_id` INT NULL,
  `name` VARCHAR(100) NOT NULL,
  `sef_name` VARCHAR(100) NOT NULL,
  `colour` VARCHAR(45) NULL,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `is_deleted` TINYINT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `cat -> content_type_idx` (`content_type` ASC),
  INDEX `icon -> asset_idx` (`icon_img_id` ASC),
  CONSTRAINT `cat -> content_type`
    FOREIGN KEY (`content_type`)
    REFERENCES `b247-com`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `icon -> asset`
    FOREIGN KEY (`icon_img_id`)
    REFERENCES `b247-com`.`asset` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`article_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`article_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `article_id` INT NOT NULL,
  `cat_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `article -> cat_idx` (`article_id` ASC),
  INDEX `article_cat -> cat_idx` (`cat_id` ASC),
  CONSTRAINT `article -> cat`
    FOREIGN KEY (`article_id`)
    REFERENCES `b247-com`.`article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `article_cat -> cat`
    FOREIGN KEY (`cat_id`)
    REFERENCES `b247-com`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`channel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`channel` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content_type` INT NOT NULL,
  `parent_channel` INT NULL,
  `icon_img_id` INT NULL,
  `name` VARCHAR(100) NOT NULL,
  `sef_name` VARCHAR(100) NOT NULL,
  `colour` VARCHAR(45) NULL,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `is_deleted` TINYINT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `channel -> cont_type_idx` (`content_type` ASC),
  INDEX `parent_channel -> channel_idx` (`parent_channel` ASC),
  INDEX `icon_img -> asset_idx` (`icon_img_id` ASC),
  CONSTRAINT `channel -> cont_type`
    FOREIGN KEY (`content_type`)
    REFERENCES `b247-com`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `parent_channel -> channel`
    FOREIGN KEY (`parent_channel`)
    REFERENCES `b247-com`.`channel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `icon_img -> asset`
    FOREIGN KEY (`icon_img_id`)
    REFERENCES `b247-com`.`asset` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`channel_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`channel_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `channel_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `cat -> channel_idx` (`category_id` ASC),
  CONSTRAINT `category_channel`
    FOREIGN KEY (`category_id`)
    REFERENCES `b247-com`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `channel_category`
    FOREIGN KEY (`channel_id`)
    REFERENCES `b247-com`.`channel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`article_image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`article_image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `article_id` INT NOT NULL,
  `image_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `img -> article_idx` (`article_id` ASC),
  INDEX `article -> img_idx` (`image_id` ASC),
  CONSTRAINT `img -> article`
    FOREIGN KEY (`article_id`)
    REFERENCES `b247-com`.`article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `article -> img`
    FOREIGN KEY (`image_id`)
    REFERENCES `b247-com`.`asset` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`age_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`age_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `range` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `age_group_id` INT NOT NULL,
  `access_key` VARCHAR(45) NOT NULL COMMENT '\'This is the unique identifier for making API requests. It is also used as the salt for verifying the user\\\'s password\'',
  `first_name` VARCHAR(75) NOT NULL,
  `last_name` VARCHAR(75) NOT NULL,
  `nickname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(65) NOT NULL,
  `originating_ip` VARCHAR(30) NULL,
  `last_login` DATETIME NULL,
  `last_login_ip` VARCHAR(30) NULL,
  `is_active` TINYINT NULL,
  `is_deleted` TINYINT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `user -> age_group_idx` (`age_group_id` ASC),
  CONSTRAINT `user -> age_group`
    FOREIGN KEY (`age_group_id`)
    REFERENCES `b247-com`.`age_group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`user_channel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`user_channel` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `channel_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `notify` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `channel -> user_idx` (`user_id` ASC),
  INDEX `user -> channel _idx` (`channel_id` ASC),
  CONSTRAINT `channel -> user`
    FOREIGN KEY (`user_id`)
    REFERENCES `b247-com`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user -> channel `
    FOREIGN KEY (`channel_id`)
    REFERENCES `b247-com`.`channel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`user_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`user_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_cat -> cat_idx` (`category_id` ASC),
  INDEX `cat -> user_idx` (`user_id` ASC),
  CONSTRAINT `user_cat -> cat`
    FOREIGN KEY (`category_id`)
    REFERENCES `b247-com`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cat -> user`
    FOREIGN KEY (`user_id`)
    REFERENCES `b247-com`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`search`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`search` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `term` VARCHAR(30) NOT NULL,
  `device` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`user_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`user_article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `pw_hash -> article_idx` (`article_id` ASC),
  INDEX `article -> user_idx` (`user_id` ASC),
  CONSTRAINT `user -> article`
    FOREIGN KEY (`article_id`)
    REFERENCES `b247-com`.`article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `article -> user`
    FOREIGN KEY (`user_id`)
    REFERENCES `b247-com`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`keyword_applied`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`keyword_applied` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `keyword_id` INT NOT NULL,
  `content_type` INT NOT NULL,
  `resource_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `keyword_content_type -> content_type_idx` (`content_type` ASC),
  INDEX `applied_keyword -> keyword_idx` (`keyword_id` ASC),
  CONSTRAINT `keyword_content_type -> content_type`
    FOREIGN KEY (`content_type`)
    REFERENCES `b247-com`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `applied_keyword -> keyword`
    FOREIGN KEY (`keyword_id`)
    REFERENCES `b247-com`.`keyword` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b247-com`.`user_profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b247-com`.`user_profile` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `facebook` VARCHAR(75) NULL,
  `twitter` VARCHAR(75) NULL,
  `postcode` VARCHAR(15) NULL,
  `lat` VARCHAR(20) NULL,
  `lon` VARCHAR(20) NULL,
  `area` VARCHAR(75) NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `profile -> user_idx` (`user_id` ASC),
  CONSTRAINT `profile -> user`
    FOREIGN KEY (`user_id`)
    REFERENCES `b247-com`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
