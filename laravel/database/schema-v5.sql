# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.27)
# Database: b247-com
# Generation Time: 2014-05-21 13:56:00 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table age_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `age_group`;

CREATE TABLE `age_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `range` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type` int(11) NOT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sef_name` varchar(255) DEFAULT NULL,
  `sub_heading` varchar(150) DEFAULT NULL,
  `body` text,
  `postcode` varchar(15) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_featured` tinyint(4) DEFAULT NULL,
  `is_picked` tinyint(4) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `is_comments` tinyint(4) DEFAULT NULL,
  `is_approved` tinyint(4) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `channel -> content_type_idx` (`content_type`),
  KEY `article -> sponsor_idx` (`sponsor_id`),
  KEY `article -> event_idx` (`event_id`),
  CONSTRAINT `channel -> content_type` FOREIGN KEY (`content_type`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table article_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_category`;

CREATE TABLE `article_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article -> cat_idx` (`article_id`),
  KEY `article_cat -> cat_idx` (`cat_id`),
  CONSTRAINT `article -> cat` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_cat -> cat` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table article_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_image`;

CREATE TABLE `article_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `img -> article_idx` (`article_id`),
  KEY `article -> img_idx` (`image_id`),
  CONSTRAINT `img -> article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> img` FOREIGN KEY (`image_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table asset
# ------------------------------------------------------------

DROP TABLE IF EXISTS `asset`;

CREATE TABLE `asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(150) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type` int(11) NOT NULL,
  `icon_img_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) NOT NULL,
  `colour` varchar(45) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat -> content_type_idx` (`content_type`),
  KEY `icon -> asset_idx` (`icon_img_id`),
  CONSTRAINT `cat -> content_type` FOREIGN KEY (`content_type`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `icon -> asset` FOREIGN KEY (`icon_img_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channel`;

CREATE TABLE `channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type` int(11) NOT NULL,
  `parent_channel` int(11) DEFAULT NULL,
  `icon_img_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) NOT NULL,
  `colour` varchar(45) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table channel_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channel_category`;

CREATE TABLE `channel_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel category_idx` (`category_id`),
  KEY `category channel_idx` (`channel_id`),
  CONSTRAINT `channel category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `category channel` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table content_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content_type`;

CREATE TABLE `content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sef_name` varchar(150) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL,
  `price` float(8,2) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event -> venue_idx` (`venue_id`),
  CONSTRAINT `event -> venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keyword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword`;

CREATE TABLE `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keyword_applied
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword_applied`;

CREATE TABLE `keyword_applied` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_id` int(11) NOT NULL,
  `content_type` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keyword_content_type -> content_type_idx` (`content_type`),
  KEY `applied_keyword -> keyword_idx` (`keyword_id`),
  CONSTRAINT `keyword_content_type -> content_type` FOREIGN KEY (`content_type`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `applied_keyword -> keyword` FOREIGN KEY (`keyword_id`) REFERENCES `keyword` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `search`;

CREATE TABLE `search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(30) NOT NULL,
  `device` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sponsor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sponsor`;

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `display_start` datetime DEFAULT NULL,
  `display_end` datetime DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `is_mobile` tinyint(4) DEFAULT NULL,
  `is_tablet` tinyint(4) DEFAULT NULL,
  `is_desktop` tinyint(4) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sponsor -> image_idx` (`image_id`),
  CONSTRAINT `sponsor -> image` FOREIGN KEY (`image_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_key` varchar(45) NOT NULL COMMENT '''This is the unique identifier for making API requests. It is also used as the salt for verifying the user\\''s password''',
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(65) NOT NULL,
  `originating_ip` varchar(30) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(30) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_article`;

CREATE TABLE `user_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pw_hash -> article_idx` (`article_id`),
  KEY `article -> user_idx` (`user_id`),
  CONSTRAINT `user -> article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_category`;

CREATE TABLE `user_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_cat -> cat_idx` (`category_id`),
  KEY `cat -> user_idx` (`user_id`),
  CONSTRAINT `user_cat -> cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cat -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_channel`;

CREATE TABLE `user_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notify` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `channel -> user_idx` (`user_id`),
  KEY `user -> channel _idx` (`channel_id`),
  CONSTRAINT `channel -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user -> channel ` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `age_group_id` int(11) DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `facebook` varchar(75) DEFAULT NULL,
  `twitter` varchar(75) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile -> user_idx` (`user_id`),
  KEY `user->age_idx` (`age_group_id`),
  CONSTRAINT `profile -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user->age` FOREIGN KEY (`age_group_id`) REFERENCES `age_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table venue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `venue`;

CREATE TABLE `venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) DEFAULT NULL,
  `address_line_1` varchar(50) NOT NULL,
  `address_line_2` varchar(50) NOT NULL,
  `address_line_3` varchar(50) DEFAULT NULL,
  `postcode` varchar(15) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `facebook` varchar(75) DEFAULT NULL,
  `twitter` varchar(75) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
