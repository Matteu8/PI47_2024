-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16-Set-2024 às 16:53
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `revisao47`
--
CREATE DATABASE IF NOT EXISTS `revisao47` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `revisao47`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_adm`
--

DROP TABLE IF EXISTS `tabela_adm`;
CREATE TABLE IF NOT EXISTS `tabela_adm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(300) NOT NULL,
  `senha` varchar(300) NOT NULL,
  PRIMARY KEY (`id_adm`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tabela_adm`
--

INSERT INTO `tabela_adm` (`id_adm`, `login`, `senha`) VALUES
(1, 'dieimes_adm', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_nome`
--

DROP TABLE IF EXISTS `tabela_nome`;
CREATE TABLE IF NOT EXISTS `tabela_nome` (
  `id_nome` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  PRIMARY KEY (`id_nome`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tabela_nome`
--

INSERT INTO `tabela_nome` (`id_nome`, `nome`) VALUES
(1, 'd'),
(2, 'Dieimes'),
(3, 'Felipe'),
(4, 'FelipÃ£o');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
