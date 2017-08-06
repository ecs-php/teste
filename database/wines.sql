-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 06, 2017 at 09:23 AM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wines`
--
CREATE DATABASE IF NOT EXISTS `wines` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wines`;

-- --------------------------------------------------------

--
-- Table structure for table `wines`
--

CREATE TABLE IF NOT EXISTS `wines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(15) NOT NULL,
  `varietal` varchar(30) NOT NULL,
  `harvest` int(11) NOT NULL,
  `region` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wines`
--

INSERT INTO `wines` (`id`, `name`, `color`, `varietal`, `harvest`, `region`, `created_at`, `updated_at`) VALUES
(1, 'Casillero Del Diablo', 'Tinto', 'Cabernet Sauvignon', 2011, 'Vale Central/Chile', '2017-08-05 01:03:36', '2017-08-05 01:03:36'),
(4, 'Marcus James', 'Tinto', 'Pinot Noir', 2013, 'Vale dos Vinhedos/Brasil', '2017-08-05 01:03:36', '2017-08-05 01:03:36'),
(6, 'Salton', 'Branco', 'Sauvignon Blanc', 2016, 'Vale dos Vinhedos/Brasil', '2017-08-06 00:54:33', '2017-08-06 00:54:33'),
(7, 'Carta Vieja', 'Tinto', 'Carmenere', 2016, 'Vale Central/Chile', '2017-08-06 12:14:42', '2017-08-06 12:14:42');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

GRANT USAGE ON *.* TO 'wines'@'%' IDENTIFIED BY PASSWORD '*A0EED055618AB8D8CF4399FC5E1AE1648F2C1F29';

GRANT ALL PRIVILEGES ON `wines`.* TO 'wines'@'%';

GRANT ALL PRIVILEGES ON `wines\_%`.* TO 'wines'@'%';
