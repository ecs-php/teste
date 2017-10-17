-- -----------------------------------------------------
-- Schema serasa_test
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `serasa_test` DEFAULT CHARACTER SET utf8 ;
USE `serasa_test` ;

-- -----------------------------------------------------
-- Table `serasa_teste`.`books`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `serasa_test`.`books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `author` VARCHAR(100) NOT NULL,
  `publishing` VARCHAR(100) NOT NULL,
  `isbn` VARCHAR(15) NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- Access Permissions
GRANT ALL ON serasa_test.* TO serasa@localhost IDENTIFIED BY 'serasa';
 
-- Inserts
USE serasa_test;
INSERT INTO `serasa_test`.`books` (`title`, `author`, `publishing`, `isbn`, `created`, `modified`) 
	VALUES ('Modern PHP', 'Josh Lockhart', 'O\'Reilly Media', '9788575224281', '2017-10-14 12:37:03', '2017-10-16 12:37:03');
INSERT INTO `serasa_test`.`books` (`title`, `author`, `publishing`, `isbn`, `created`, `modified`) 
	VALUES ('PHP Web Services', 'Lorna Jane Mitchell', 'O\'Reilly Media', '9788575223697', '2017-10-14 12:37:03', '2017-10-16 12:37:03');
INSERT INTO `serasa_test`.`books` (`title`, `author`, `publishing`, `isbn`, `created`, `modified`) 
	VALUES ('Magento PHP Developer\'s Guide', 'Allan MacGregor', 'Packt Publishing', '9781782163060', '2017-10-14 12:37:03', '2017-10-16 12:37:03');