-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Jun-2017 às 17:03
-- Versão do servidor: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `contacts`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `list_contacts`
--

CREATE TABLE IF NOT EXISTS `list_contacts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `list_contacts`
--

INSERT INTO `list_contacts` (`id`, `first_name`, `last_name`, `email`, `phone_number`) VALUES
(1, 'Maicon Eduardo', 'Prange', 'maiconprange@hotmail.com.br', '47984289831'),
(2, 'Fernanda da Sila', 'Prange', 'fernanda@hotmail.com.br', '47984289832'),
(3, 'Amanda', 'Prange', 'amanda@hotmail.com.br', '47984289833'),
(4, 'Teste', 'Testando', 'teste@teste.com.br', '8987987897897'),
(5, 'Teste', 'Testando', 'teste@teste.com.br', '8987987897897');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_contacts`
--
ALTER TABLE `list_contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_contacts`
--
ALTER TABLE `list_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
