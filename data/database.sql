CREATE DATABASE IF NOT EXISTS `serasa_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `serasa_test`;
 
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `email` varchar(255) NOT NULL,
   `age` int(11) NOT NULL,
   `address` varchar(255) NOT NULL,
   `created` datetime NOT NULL,
   `updated` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; 