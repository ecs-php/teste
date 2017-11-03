-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 03/11/2017 às 04:08
-- Versão do servidor: 5.7.20-0ubuntu0.16.04.1
-- Versão do PHP: 7.1.10-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `esc_testing`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `draw_dates`
--

CREATE TABLE `draw_dates` (
  `id` bigint(20) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `draw_dates`
--

INSERT INTO `draw_dates` (`id`, `date`) VALUES
(1, '2015-08-16'),
(2, '2015-08-18'),
(3, '2015-08-19'),
(4, '2015-08-20'),
(5, '2015-08-21'),
(6, '2015-08-22'),
(7, '2015-08-23'),
(8, '2015-08-24'),
(9, '2015-08-25'),
(10, '2015-08-26'),
(11, '2015-08-27'),
(12, '2015-08-28'),
(13, '2015-08-29'),
(14, '2015-08-30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `city`, `code`, `password`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Lucas Rafael Silva', 'lucasrafael7070@gmai23l2.com', '33999351521', 'Sao Paulo', '464891891981-1', '$1$hwOlfVxc$P6uGTdmn7uS66ZEZpa90m0', 'Active', '2017-11-02 11:54:57', '2017-11-03 05:24:06'),
(10, 'Lucas Silva', 'lucasrafael7070@gma32il.com', '33999351521', 'Minas Gerais', '464891891981-2', '$1$KgxDjs1i$QVy/wJcWWmPCt4MWBq9RD/', 'Active', '2017-11-02 21:30:42', '2017-11-03 05:11:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `winners`
--

CREATE TABLE `winners` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `draw_date_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `winners`
--

INSERT INTO `winners` (`id`, `user_id`, `draw_date_id`) VALUES
(1, 9, 3);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `draw_dates`
--
ALTER TABLE `draw_dates`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `name` (`name`),
  ADD KEY `code` (`code`),
  ADD KEY `city` (`city`);

--
-- Índices de tabela `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`draw_date_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `draw_dates`
--
ALTER TABLE `draw_dates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de tabela `winners`
--
ALTER TABLE `winners`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
