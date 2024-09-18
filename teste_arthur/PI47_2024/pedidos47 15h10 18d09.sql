-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 18-Set-2024 às 18:12
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
-- Banco de dados: `pedidos47`
--
CREATE DATABASE IF NOT EXISTS `pedidos47` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pedidos47`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_clientes` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `periodo` varchar(10) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(300) NOT NULL,
  PRIMARY KEY (`id_clientes`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `nome`, `curso`, `periodo`, `telefone`, `email`) VALUES
(1, 'Arthur', 'ProgramaÃ§Ã£o web', 'Tarde', '43 4002-8922', 'arthur@gmail.com'),
(2, 'Mateus', 'ProgramaÃ§Ã£o web', 'Tarde', '43 9999-9999', 'mateus@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

DROP TABLE IF EXISTS `contato`;
CREATE TABLE IF NOT EXISTS `contato` (
  `id_contato` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `assunto` varchar(30) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  PRIMARY KEY (`id_contato`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`id_contato`, `nome`, `email`, `telefone`, `assunto`, `mensagem`) VALUES
(1, 'Arthur', 'arthur@gmail.com', '43 4002-8922', 'Elogio', 'Gostei dos Lanches, mas poderia ser um pouco menos quente o lanche.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id_funcionarios` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(200) NOT NULL,
  PRIMARY KEY (`id_funcionarios`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lanches`
--

DROP TABLE IF EXISTS `lanches`;
CREATE TABLE IF NOT EXISTS `lanches` (
  `id_lanches` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `ingredientes` varchar(300) DEFAULT NULL,
  `preco` varchar(20) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_lanches`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `lanches`
--

INSERT INTO `lanches` (`id_lanches`, `nome`, `ingredientes`, `preco`, `foto`) VALUES
(1, 'X-Bacon', 'Pao, Bacon, Maionese, Alface, Batata Palha ', 'R$ 15,99', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
