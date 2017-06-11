# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.26)
# Base de Dados: gft
# Tempo de Geração: 2017-02-12 23:36:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cellphone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `complement` varchar(20) DEFAULT NULL,
  `neighborhood` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `phone`, `cellphone`, `address`, `number`, `complement`, `neighborhood`, `city`, `province`, `created`, `modified`)
VALUES
	(1,'Fabiola','Potame','fabiopotame@gmail.com','(11) 95878-8914','(11) 95878-8914','Rua Tibúrcio de Sousa','2608','BL 7 AP 33','Itaim Paulista','São Paulo','SP','2017-01-01 00:00:00','2017-02-12 18:54:52'),
	(2,'Priscila','Grava','prigrv@uol.com.br','(11) 95878-8990','(11) 95878-8990','Rua Nova Friburgo','685',NULL,'Jardim Penha','São Paulo','SP','2017-01-01 00:00:00','2017-02-12 17:40:32'),
	(3,'Ana Paula','Lopes','paula.lopes@uol.com.br','(11) 95878-8800','(11) 95878-8800','Rua Frei Frederidco Vier','102','Casa 1','Cangaíba','São Paulo','SP','2017-01-01 00:00:00','2017-02-12 18:16:36'),
	(27,'Adalberto','Amaral','dalbe@uol.com.br','(11) 1234-1234','(11) 12345-1234','Rua das Flores','140','','Penha','São Paulo','SP','2017-02-12 19:41:15','2017-02-12 19:41:15'),
	(35,'Brunna','Grava','brunnag@uo.com.br','(11) 1234-1234','(11) 12345-1234','Rua Peixoto','45','','Jardim Cabreúva','São Paulo','SP','2017-02-12 20:08:23','2017-02-12 20:09:42');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
