-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06-Set-2024 às 18:19
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
-- Banco de dados: `basico`
--
CREATE DATABASE IF NOT EXISTS `basico` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `basico`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `basico_tabela`
--

DROP TABLE IF EXISTS `basico_tabela`;
CREATE TABLE IF NOT EXISTS `basico_tabela` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  `telefone` varchar(300) NOT NULL,
  `cargo` varchar(300) NOT NULL,
  `endereco` varchar(300) NOT NULL,
  `cpf` varchar(300) NOT NULL,
  `datanasc` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `caminho_foto` varchar(300) NOT NULL,
  `senha` varchar(300) NOT NULL,
  PRIMARY KEY (`id_funcionario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `basico_tabela`
--

INSERT INTO `basico_tabela` (`id_funcionario`, `nome`, `telefone`, `cargo`, `endereco`, `cpf`, `datanasc`, `email`, `caminho_foto`, `senha`) VALUES
(1, 'Dieimes Nunes de Souza', '(43) 98817-9995', 'Instrutor', 'Avenida abc, 123', '123.123.147-14', '2024-09-06', 'dieimes.souza@docente.pr.senac.br', 'recebidos/66db360cd39db.png', '$2y$10$nJ9DsLdR59JWKx4ODTp1Y.QwOnhLkQ17eX9Vko5TM80aLAGWkOCcy'),
(2, 'Maria', '(43) 1111', 'Instrutor', 'Avenida abc, 123', '123.123.147-14', '2024-09-06', 'dieimes.souza@docente.pr.senac.br', 'recebidos/66db37eb65146.jpg', '$2y$10$64ETGPVUeH90QPJDUtzcvuvYSOI1.EQJWBCuZy8/fRxAh9FSTy8X6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
