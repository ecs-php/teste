-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jul-2017 às 05:46
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_serasa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumer`
--

CREATE TABLE `consumer` (
  `cnsmr_id` int(5) NOT NULL,
  `cnsmr_cpf` bigint(11) NOT NULL,
  `cnsmr_name` varchar(150) NOT NULL,
  `cnsmr_birth` date NOT NULL,
  `cnsmr_cphone` varchar(15) NOT NULL,
  `cnsmr_date_register` datetime NOT NULL,
  `cnsmr_date_change` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `consumer`
--

INSERT INTO `consumer` (`cnsmr_id`, `cnsmr_cpf`, `cnsmr_name`, `cnsmr_birth`, `cnsmr_cphone`, `cnsmr_date_register`, `cnsmr_date_change`) VALUES
(23, 24511320357, 'João da Silva', '1991-07-09', '4799658554', '2017-07-03 00:32:23', '2017-07-03 00:44:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consumer`
--
ALTER TABLE `consumer`
  ADD PRIMARY KEY (`cnsmr_id`),
  ADD UNIQUE KEY `uk_cnsmr_cpf` (`cnsmr_cpf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consumer`
--
ALTER TABLE `consumer`
  MODIFY `cnsmr_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
