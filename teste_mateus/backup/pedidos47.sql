-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 04-Out-2024 às 16:42
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
CREATE DATABASE IF NOT EXISTS `pedidos47` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pedidos47`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bebidas`
--

DROP TABLE IF EXISTS `bebidas`;
CREATE TABLE IF NOT EXISTS `bebidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `foto` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `bebidas`
--

INSERT INTO `bebidas` (`id`, `nome`, `tipo`, `preco`, `quantidade`, `foto`) VALUES
(1, 'roberto', 'asd', '12.00', 1010101010, 'receber/66fd7fcf2f79b.jpg'),
(3, 'b', 'b', '2.00', 101010101, 'Lanches/bebidas/66fd8054b27dd.jpg'),
(4, 'c', 'c', '3.00', 1010101010, 'Lanches/bebidas/66fd80609b902.jpg');

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
  `telefone` varchar(20) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(300) NOT NULL,
  PRIMARY KEY (`id_clientes`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `nome`, `curso`, `periodo`, `telefone`, `email`, `senha`) VALUES
(1, 'Arthur', 'ProgramaÃ§Ã£o web', 'Tarde', '43 4002-8922', 'arthur@gmail.com', ''),
(7, 'Mateus Vinicius', 'Programação WEB', 'Tarde', '45416594844', 'mateus.68998@aluno.pr.senac.br', '$2y$10$eS4YwjqLPxXNbdxtArxWD.4uIGgg.azuE2/ZxI/H6KLkdyDoJeWvG'),
(13, 'onze', '1', '1', '1', '11@11', '$2y$10$hsri1ZM44htofnhPGpZrleDgmYIshuIQ55wY2eUxazkNRiVnE9LkS');

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
-- Estrutura da tabela `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `assunto` varchar(100) NOT NULL,
  `msg` varchar(300) NOT NULL,
  PRIMARY KEY (`id_feedback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(300) NOT NULL,
  PRIMARY KEY (`id_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `nome`, `email`, `senha`) VALUES
(3, 'Mateus', '1@1', '$2y$10$V2LqQBj3gAaKxJPZkSQKhuQqeGtdyRdqGHPUtsZHDcZk4WdY8kz/y'),
(5, '1', '2@2', '$2y$10$K.lpKHU3yElnOdWgRAOd5.HSkkymXS9XifFQ5xyV48ECTibv25k0i');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id_item_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_lanches` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `id_sobremesa` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item_pedido`),
  KEY `fk_pedido` (`id_pedido`),
  KEY `fk_lanches` (`id_lanches`),
  KEY `fk_bebidas` (`id`),
  KEY `fk_sobremesa` (`id_sobremesa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lanches`
--

DROP TABLE IF EXISTS `lanches`;
CREATE TABLE IF NOT EXISTS `lanches` (
  `id_lanches` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `ingredientes` varchar(300) NOT NULL,
  `preco` varchar(20) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `foto` varchar(300) NOT NULL,
  PRIMARY KEY (`id_lanches`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lanches`
--

INSERT INTO `lanches` (`id_lanches`, `nome`, `ingredientes`, `preco`, `quantidade`, `foto`) VALUES
(1, 'SanduÃ­che', 'PÃ£o, Alface, Presunto, Tomate', '123', 1010101009, 'Lanches/img/66f8426e0dd7b.jpg'),
(2, 'Claudio', 'Ã“leo', '2', 1010100, 'Lanches/img/66f84302cbdf3.jpg'),
(3, 'Hamburguer', '6', '20', 101009, 'Lanches/img/66f8435124fce.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_clientes` int(11) DEFAULT NULL,
  `nome_funcionario` varchar(300) NOT NULL,
  `data_pedido` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_clientes` (`id_clientes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobremesa`
--

DROP TABLE IF EXISTS `sobremesa`;
CREATE TABLE IF NOT EXISTS `sobremesa` (
  `id_sobremesa` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  `ingrediente` varchar(300) NOT NULL,
  `preco` varchar(300) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `foto` varchar(300) NOT NULL,
  PRIMARY KEY (`id_sobremesa`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sobremesa`
--

INSERT INTO `sobremesa` (`id_sobremesa`, `nome`, `ingrediente`, `preco`, `quantidade`, `foto`) VALUES
(1, 'sobremesa', '12', '1', 10101, 'Lanches/bebidas/66fda41cda5fa.jpg'),
(2, 'asd', '12', '123', 1201010, 'Lanches/bebidas/66fda42342a3c.jpg'),
(3, 'asd', '12', '123', 12010120, 'Lanches/bebidas/66fda4295ea04.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
