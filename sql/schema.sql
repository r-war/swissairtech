
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- configuration
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `configuration`;


CREATE TABLE `configuration`
(
	`configuration_id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`domain` VARCHAR(255)  NOT NULL,
	`key_name` VARCHAR(255)  NOT NULL,
	`value` TEXT,
	PRIMARY KEY (`configuration_id`),
	UNIQUE KEY `unique_configuration` (`domain`, `key_name`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- admin_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_type`;


CREATE TABLE `admin_type`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`privileges` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- admin
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;


CREATE TABLE `admin`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`type_id` INTEGER(10),
	`date` DATETIME,
	`username` VARCHAR(255)  NOT NULL,
	`password` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(255),
	`email` VARCHAR(255),
	`phone` VARCHAR(255),
	`address` TEXT,
	`extra` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `username_unique` (`username`),
	INDEX `admin_FI_1` (`type_id`),
	CONSTRAINT `admin_FK_1`
		FOREIGN KEY (`type_id`)
		REFERENCES `admin_type` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- banner
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `banner`;


CREATE TABLE `banner`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2)  NOT NULL,
	`group` VARCHAR(255),
	`index` INTEGER(10),
	`picture` VARCHAR(255)  NOT NULL,
	`url` VARCHAR(255),
	`new_tab` TINYINT(1) default 0,
	`name` VARCHAR(255),
	`description` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB COMMENT='Banner Table';

#-----------------------------------------------------------------------------
#-- menu
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;


CREATE TABLE `menu`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2)  NOT NULL,
	`parent_id` INTEGER(10),
	`group` VARCHAR(255),
	`index` INTEGER(10),
	`name` VARCHAR(255)  NOT NULL,
	`type` INTEGER(1) default 1 NOT NULL,
	`value` VARCHAR(255),
	`new_tab` TINYINT(1) default 0,
	PRIMARY KEY (`id`),
	INDEX `menu_FI_1` (`parent_id`),
	CONSTRAINT `menu_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `menu` (`id`)
		ON DELETE SET NULL
)Type=InnoDB COMMENT='Menu Table';

#-----------------------------------------------------------------------------
#-- page
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `page`;


CREATE TABLE `page`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`sort_order` INTEGER(10) default 0,
	`language` VARCHAR(2) default 'en' NOT NULL,
	`type` VARCHAR(20) default 'page' NOT NULL,
	`date` DATETIME,
	`code` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`picture` VARCHAR(255),
	`short_desc` TEXT,
	`description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_page` (`code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- page_tab
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `page_tab`;


CREATE TABLE `page_tab`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`page_id` INTEGER(10)  NOT NULL,
	`index` INTEGER(10),
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	PRIMARY KEY (`id`),
	INDEX `page_tab_FI_1` (`page_id`),
	CONSTRAINT `page_tab_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `page` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- video_subscriber
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `video_subscriber`;


CREATE TABLE `video_subscriber`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2) default 'en' NOT NULL,
	`date` DATETIME  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`company` VARCHAR(255)  NOT NULL,
	`phone` VARCHAR(255)  NOT NULL,
	`active` TINYINT(1) default 1,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- video
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `video`;


CREATE TABLE `video`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2)  NOT NULL,
	`date` DATETIME,
	`date_closed` DATETIME,
	`code` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`picture` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_page` (`language`, `code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- subscriber
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscriber`;


CREATE TABLE `subscriber`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`date` DATETIME  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`active` TINYINT(1) default 1,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- news
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `news`;


CREATE TABLE `news`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2)  NOT NULL,
	`type` VARCHAR(30) default 'news' NOT NULL,
	`code` VARCHAR(255)  NOT NULL,
	`date` DATE  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`picture` VARCHAR(255),
	`description` TEXT,
	`short_description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_news` (`language`, `code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- gallery
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `gallery`;


CREATE TABLE `gallery`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` CHAR(2)  NOT NULL,
	`parent_id` INTEGER(10),
	`index` INTEGER(10),
	`code` VARCHAR(255)  NOT NULL,
	`mode` VARCHAR(100),
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `code_unique` (`language`, `code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- gallery_picture
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `gallery_picture`;


CREATE TABLE `gallery_picture`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`gallery_id` INTEGER(10)  NOT NULL,
	`index` INTEGER(10),
	`picture` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(255),
	`description` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- testimonial
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `testimonial`;


CREATE TABLE `testimonial`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`language` VARCHAR(2) default 'en' NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`picture` VARCHAR(255),
	`active` TINYINT(1) default 0,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- seo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `seo`;


CREATE TABLE `seo`
(
	`id` INTEGER(10)  NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(255)  NOT NULL,
	`meta_title` TEXT,
	`meta_keywords` TEXT,
	`meta_description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `seo_url` (`url`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
