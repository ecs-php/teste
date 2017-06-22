CREATE DATABASE video_repository_db;

CREATE  TABLE video (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `category_id` BIGINT(20) NOT NULL,
  `description` text NULL,
  `filename` VARCHAR(255) NOT NULL,
  `duration` time,
  `active` VARCHAR(255) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` datetime NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


CREATE  TABLE category (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` BIGINT(20) NOT NULL,
 `active` VARCHAR(255) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` datetime NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE user (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
 `active` VARCHAR(255) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` datetime NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


CREATE  TABLE user_access_token (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `user_id`  BIGINT(20) NOT NULL,
  `access_token` VARCHAR(255) NOT NULL,
 `active` VARCHAR(255) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modification_date` datetime NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

insert into user( name , email , active , creation_date ) values ( 'thiago', 'thiagoevangelista.contato@gmail.com' , 'yes', NOW());

INSERT INTO user_access_token ( user_id , access_token , active, creation_date )
VALUES (1, 'abcdefg' , 'yes' , NOW());
