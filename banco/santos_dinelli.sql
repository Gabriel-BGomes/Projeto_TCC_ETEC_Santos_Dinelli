-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2024 at 01:03 PM
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
  `cpf_cliente` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `razao_social` varchar(100) DEFAULT NULL,
  `email_cliente_pj` varchar(100) DEFAULT NULL,
  `cnpj` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `telefone_pj` varchar(15) DEFAULT NULL,
  `endereco_pj` varchar(255) DEFAULT NULL,
  `cep_pj` varchar(10) DEFAULT NULL,
  `referencia_pj` varchar(100) DEFAULT NULL,
  `bairro_pj` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cidade_pj` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `complemento_pj` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `forma_pagamento_pj` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_pessoa`, `nome_cliente`, `email_cliente`, `cpf_cliente`, `data_nascimento`, `telefone`, `endereco`, `bairro`, `cep`, `cidade`, `complemento`, `forma_pagamento`, `razao_social`, `email_cliente_pj`, `cnpj`, `telefone_pj`, `endereco_pj`, `cep_pj`, `referencia_pj`, `bairro_pj`, `cidade_pj`, `complemento_pj`, `forma_pagamento_pj`) VALUES
(50, 1, 'Leonardo Dinelli', 'leodinelli2007@gmail.com', '123.214.124-14', '2007-02-27', '(12) 34124-2134', 'Rua C 152', 'Jardim Santa Cruz (Sacomã)', '04182-135', 'São Paulo', 'ap 44 c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '0', ''),
(54, 1, 'Matheus', 'matheusoliveirale2007@gmail.com', '213.142.141-41', '2005-02-10', '(11) 93210-3213', 'Rua São Bento', 'Centro', '01010-001', 'São Paulo', 'apto 33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '0', ''),
(56, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@oficial.com', '04.214.042/0001-16', '(11) 9342-1439', 'Rua Marquês de Lages', '04162-001', 'padoca', 'Vila Moraes', 'São Paulo', 'nenhum', 'Pix'),
(57, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Americanas', 'americanas@oficial.com', '04.214.042/0001-16', '(11) 9342-1439', 'Rua Marquês de Lages', '04162-001', 'padoca', 'Vila Moraes', 'São Paulo', 'nenhum', 'Pix'),
(58, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kabum', 'kabum@naooficiai.ocom', '32.131.200/0154-21', '(31) 2312-9031', 'rua abacaxi nao listrado 12', '00412-412', 'iasdfa', 'vila moraes', 'sp', 'nennum', 'Boleto'),
(59, 1, 'Gabriel Braga Gomes', 'gabrielbraga001123@gmail.com', '123.131.414-14', '2006-08-10', '(11) 03021-3912', 'rua abacaxi nao listrado', 'sao paulo', '04142-131', 'sao paulo', 'nenhum', 'Dinheiro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `obs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `servico` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `color`, `start`, `end`, `obs`, `servico`, `id_cliente`) VALUES
(101, 'Etec Heliópolis – Arquiteto Ruy Ohtake', '#FF4500', '2024-10-03 13:00:00', '2024-10-03 18:20:00', 'Apresentação pré banca', 'Visita', 0),
(105, 'Izael', '#1C1C1C', '2024-10-16 13:00:00', '2024-10-16 14:30:00', 'Verificar gás', 'Desinstalação', 0),
(111, 'Aline', '#A020F0', '2024-10-09 15:15:00', '2024-10-09 16:00:00', 'levar material de limpeza', 'Higienização', 0),
(113, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(116, 'Sá de Oliveira', '#40E0D0', '2024-10-02 13:00:00', '2024-10-02 14:00:00', 'nenhuma', 'Desinstalação', 54),
(118, 'limpeza preventiva', '#436EEE', '2024-10-17 14:00:00', '2024-10-17 15:00:00', 'nenhuma', 'Manutenção preventiva', 56),
(119, 'desintetização', '#8B0000', '2024-10-17 17:00:00', '2024-10-17 18:00:00', 'levar papel higiênico', 'Higienização', 59),
(120, 'limpeza', '#228B22', '2024-10-18 11:00:00', '2024-10-18 12:00:00', 'levar parafuso grande', 'Higienização', 50),
(121, 'verificar todos os ar condicionados do cliente', '#FF4500', '2024-10-18 15:00:00', '2024-10-18 17:00:00', 'levar fita ', 'Visita', 56),
(122, 'limpeza de móveis', '#A020F0', '2024-10-19 15:00:00', '2024-10-19 16:00:00', 'nenhuma', 'Higienização', 54);

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
(25, 'Janeiro', 500.00, 200.00),
(26, 'Julho', 17.00, 17.00),
(27, 'Março', 146.00, 100.00),
(28, 'Maio', 80.00, 50.00),
(29, 'Dezembro', 100.00, 12.00),
(30, 'Junho', 20.00, 20.00),
(31, 'Setembro', 544.00, 244.00),
(32, 'Fevereiro', 34.00, 24.00),
(33, 'Abril', 51.00, 32.00),
(34, 'Novembro', 10.00, 5.00),
(35, 'Outubro', 100.00, 20.00),
(36, 'Agosto', 300.00, 500.00);

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
(2, 'Matheus Estevam', 'matheusoliveirale2007@gmail.com', '$2y$10$RRbfn6Y.cq/VqjYvKYiMuOLBe2Bs/FevNLvajiSy5.sGoqE.BtSFq', NULL, NULL),
(3, 'Castellinho', 'isabellasilvestrecastellon@gmail.com', '$2y$10$V98pJibds2bCSOT2bHCsg.dmF9Xb/07LAFx1jC9c2nLeSYzzU.GIS', NULL, NULL),
(4, 'Leonardo Dinelli', 'leodinelli2007@gmail.com', '$2y$10$QjiKQ3IKJ95BL1pGwBQYSeMzvn9SH8gVpfmVHMQIEfMvXr/zacohe', NULL, NULL),
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- ALTER TABLE for table `usuarios`
--
ALTER TABLE `usuarios`
ADD COLUMN remember_token VARCHAR(64) NULL,
ADD COLUMN token_expiracao DATETIME NULL;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `usuarios` 
ADD COLUMN `pin_financeiro` VARCHAR(255) DEFAULT NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
