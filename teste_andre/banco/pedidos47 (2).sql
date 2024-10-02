-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02-Out-2024 às 17:40
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `nome`, `curso`, `periodo`, `telefone`, `email`) VALUES
(1, 'Arthur', 'ProgramaÃ§Ã£o web', 'Tarde', '43 4002-8922', 'arthur@gmail.com');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`id_contato`, `nome`, `email`, `telefone`, `assunto`, `mensagem`) VALUES
(1, 'Arthur', 'arthur@gmail.com', '43 4002-8922', 'Elogio', 'Gostei dos Lanches, mas poderia ser um pouco menos quente o lanche.');

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
  `foto` varchar(300) NOT NULL,
  PRIMARY KEY (`id_lanches`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lanches`
--

INSERT INTO `lanches` (`id_lanches`, `nome`, `ingredientes`, `preco`, `foto`) VALUES
(1, 'X-tudo', 'Tem tudo e mais um pouco', 'R$ 19,99', ''),
(11, 'PÃ£o com ovo', 'pÃ£o e ovo frito', 'R$ 3,99', 'Pao-com-Ovo.jpg'),
(13, 'PÃ£o com ovo', 'pÃ£o e ovo frito', 'R$ 3,99', 'as-logo-design-template-6cb212472d4c9fdbc0784695e6464e6f_screen.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobremesa`
--

DROP TABLE IF EXISTS `sobremesa`;
CREATE TABLE IF NOT EXISTS `sobremesa` (
  `id_sobremesa` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(300) NOT NULL,
  `preco` varchar(300) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `imagem` varchar(300) NOT NULL,
  PRIMARY KEY (`id_sobremesa`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sobremesa`
--

INSERT INTO `sobremesa` (`id_sobremesa`, `nome`, `preco`, `quantidade`, `imagem`) VALUES
(12, 'beta bebida boa ', '100', 1, 'recebidos.img/66fd7624acd9a.jpg'),
(13, 'doce de leite', '5', 12, 'recebidos.img/66fd76c2c3d9f.jpg'),
(14, 'Ganin', '5', 5, 'recebidos.img/66fd76dba729c.png'),
(15, 'torta de maÃ§a', '15', 3, 'recebidos.img/66fd7f5772a4b.jpg'),
(16, 'brawnie', '17', 12, 'recebidos.img/66fd7f6f1c3ab.png'),
(17, 'dois amores', '5', 8, 'recebidos.img/66fd7f82b169e.jpeg'),
(18, 'bolo toalha felpuda', '6', 1, 'recebidos.img/66fd7f9e570f0.jpg'),
(19, 'musse de morango', '4', 4, 'recebidos.img/66fd7fc19c9ec.avif'),
(20, 'pudim', '3', 1, 'recebidos.img/66fd81e2e93c3.avif');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
