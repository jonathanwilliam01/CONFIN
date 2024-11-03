-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03/11/2024 às 16:54
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `confin`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Fixo'),
(2, 'Compras'),
(3, 'Alimentação'),
(4, 'Moto'),
(5, 'Mercado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `meses`
--

DROP TABLE IF EXISTS `meses`;
CREATE TABLE IF NOT EXISTS `meses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mes` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `meses`
--

INSERT INTO `meses` (`id`, `mes`) VALUES
(1, 'Janeiro'),
(2, 'Fevereiro'),
(3, 'Março'),
(4, 'Abril'),
(5, 'Maio'),
(6, 'Junho'),
(7, 'Julho'),
(8, 'Agosto'),
(9, 'Setembro'),
(10, 'Outubro'),
(11, 'Novembro'),
(12, 'Dezembro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `origens`
--

DROP TABLE IF EXISTS `origens`;
CREATE TABLE IF NOT EXISTS `origens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `origem` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `origens`
--

INSERT INTO `origens` (`id`, `origem`) VALUES
(1, 'Crédito'),
(2, 'Débito');

-- --------------------------------------------------------

--
-- Estrutura para tabela `saidas`
--

DROP TABLE IF EXISTS `saidas`;
CREATE TABLE IF NOT EXISTS `saidas` (
  `referencial` int NOT NULL AUTO_INCREMENT,
  `gasto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `valor` double NOT NULL,
  `categoria` int NOT NULL,
  `mes` int NOT NULL,
  `origem` int DEFAULT NULL,
  `data` date DEFAULT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`referencial`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `saidas`
--

INSERT INTO `saidas` (`referencial`, `gasto`, `valor`, `categoria`, `mes`, `origem`, `data`, `id_usuario`) VALUES
(123, 'Correia', 123, 2, 11, 2, NULL, 0),
(119, 'Marmita', 5, 1, 2, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha` varchar(20) NOT NULL,
  `documento` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nome_completo` varchar(250) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `senha`, `documento`, `email`, `nome_completo`) VALUES
(1, 'jonathan_wps01', 'teste123', '50334716861', 'jonatham.willian@hotmail.com', 'Jonathan William Pereira da Silva');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
