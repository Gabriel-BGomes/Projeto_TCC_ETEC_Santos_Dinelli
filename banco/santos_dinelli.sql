-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2024 at 02:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `santos_dinelli`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `tipo_pessoa` int DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `email_cliente` varchar(100) DEFAULT NULL,
  `cpf_cliente` varchar(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `razao_social` varchar(100) DEFAULT NULL,
  `email_cliente_pj` varchar(100) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `telefone_pj` varchar(15) DEFAULT NULL,
  `endereco_pj` varchar(255) DEFAULT NULL,
  `cep_pj` varchar(10) DEFAULT NULL,
  `referencia_pj` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_pessoa`, `nome_cliente`, `email_cliente`, `cpf_cliente`, `data_nascimento`, `telefone`, `endereco`, `bairro`, `cep`, `cidade`, `complemento`, `forma_pagamento`, `razao_social`, `email_cliente_pj`, `cnpj`, `telefone_pj`, `endereco_pj`, `cep_pj`, `referencia_pj`) VALUES
(10, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(18, 1, 'Matheus', 'fdasfas@gmail.com', '12312241', '1245-12-12', 'fdsa', '1fsdaf', 'fdas', 'fdas', 'fdsa', 'fdas', 'fdsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 1, 'Matheus', 'fdasfas@gmail.com', '12312241', '1245-12-12', 'fdsa', '1fsdaf', 'fdas', 'fdas', 'fdsa', 'fdas', 'fdsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 'Matheus', 'fdasfas@gmail.com', '12312241', '1245-12-12', 'fdsa', '1fsdaf', 'fdas', 'fdas', 'fdsa', 'fdas', 'fdsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(22, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(23, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(25, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(26, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(27, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(28, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(29, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(30, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(31, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(32, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(33, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(34, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(35, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(36, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(37, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(38, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(39, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(40, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca'),
(41, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@gmail.com', '1231241512', '11918422906', 'rua abacaxi não listrado 1234', '041525001', 'em frente a padoca');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `obs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `color`, `start`, `end`, `obs`) VALUES
(42, 'Leonardo Dinelli', '#FFD700', '2024-09-13 13:00:00', '2024-09-13 14:00:00', 'conserto de ar condicionado'),
(45, NULL, NULL, NULL, NULL, NULL),
(47, 'Matheus Estevam', '#436EEE', '2024-09-12 14:00:00', '2024-09-12 15:00:00', 'limpeza'),
(48, 'Etec Heliópolis', '#FF4500', '2024-10-03 13:00:00', '2024-10-03 18:00:00', 'Apresentação da Pré Banca');

-- --------------------------------------------------------

--
-- Table structure for table `financas`
--

CREATE TABLE `financas` (
  `id` int NOT NULL,
  `mes` varchar(20) NOT NULL,
  `recebimento` decimal(10,2) NOT NULL,
  `despesa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `financas`
--

INSERT INTO `financas` (`id`, `mes`, `recebimento`, `despesa`) VALUES
(25, 'Janeiro', 1.00, 1.00),
(26, 'Julho', 17.00, 17.00),
(27, 'Março', 46.00, 80.00),
(28, 'Maio', 80.00, 50.00),
(29, 'Dezembro', 100.00, 12.00),
(30, 'Junho', 20.00, 20.00),
(31, 'Setembro', 544.00, 244.00),
(32, 'Fevereiro', 24.00, 24.00),
(33, 'Abril', 51.00, 32.00),
(34, 'Novembro', 10.00, 5.00),
(35, 'Outubro', 300.00, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_usuario` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_autenticacao` int DEFAULT NULL,
  `data_codigo_autenticacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha_usuario`, `codigo_autenticacao`, `data_codigo_autenticacao`) VALUES
(1, 'Gabriel Braga', 'gabrielbraga1324@gmail.com', '$2y$10$/8h3zj2her/0yPi77XGj0OWJBOSdTLdzrep/m6tq3iYSisH49ZsQe', NULL, NULL),
(2, 'Matheus Estevam', 'matheusoliveirale2007@gmail.com', '$2y$10$W6svxbrsCZ4LAOGnkV13iepjTtomS5.2tnEZR/cNl2SsnkTYAUeBm', 286873, '2024-10-01 10:00:33'),
(3, 'Castellinho', 'isabellasilvestrecastellon@gmail.com', '$2y$10$V98pJibds2bCSOT2bHCsg.dmF9Xb/07LAFx1jC9c2nLeSYzzU.GIS', NULL, NULL),
(4, 'Leonardo Dinelli', 'leodinelli2007@gmail.com', '$2y$10$eC32oyaPHFgaLkyDxNcw1u45r4AOOVj6gLy7nONoWToRPeU0YkL7y', NULL, NULL),
(5, 'Henrick Gomes', 'henrickgomes46@gmail.com', '$2y$10$sKSYqTve.IP8KM9YqcCTf.jEaZMdXu1Lvm3z.VGzrg.od./srVwh6', 260643, '2024-09-27 10:10:05'),
(6, 'Matheus Ribeiro', 'matheusribeiro2409@outlook.com ', '$2y$10$eIaKTCE3Y.P.src/1C2pF.7dml6VAd0bE09SOr4rir0.VFfVt2XAi', 630028, '2024-09-27 10:15:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financas`
--
ALTER TABLE `financas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
