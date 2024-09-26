-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 26/09/2024 às 01:03
-- Versão do servidor: 8.0.30
-- Versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `teste2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
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
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_pessoa`, `nome_cliente`, `email_cliente`, `cpf_cliente`, `data_nascimento`, `telefone`, `endereco`, `bairro`, `cep`, `cidade`, `complemento`, `forma_pagamento`, `razao_social`, `email_cliente_pj`, `cnpj`, `telefone_pj`, `endereco_pj`, `cep_pj`, `referencia_pj`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', 'dada', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(2, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '1111-11-11', '11940521224', 'Rua c 152', 'Jardim Santa Emilia', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(5, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '', '2222-02-22', '11940521224', 'Rua c 152', '', '04182-135', 'São Paulo', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2006-02-27', '11940521224', 'Rua c 152', 'Jardim Santa Emilia', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '3213121', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(8, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2007-02-27', '11940521224', 'Rua c 152', 'Jardim Santa Emilia', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(10, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(11, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(12, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec', 'leodinelli2007@gmail.com', '4234423424', '11940521224', 'Rua c 152', '04182-135', 'APPCCCCXCX'),
(13, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2222-02-22', '11940521224', 'Rua c 152', 'JD. STA. CRUZ (SACOMA)', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2222-02-22', '11940521224', 'Rua c 152', 'JD. STA. CRUZ (SACOMA)', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2222-02-22', '11940521224', 'Rua c 152', 'JD. STA. CRUZ (SACOMA)', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2222-02-22', '11940521224', 'Rua c 152', 'JD. STA. CRUZ (SACOMA)', '04182-135', 'São Paulo', 'App 44 c', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'Leonardo Dinelli dos Santos', 'leodinelli2007@gmail.com', '5435354353', '2222-02-22', '11940521224', 'Rua c 152', 'Jardim Santa Emilia', '04182-135', 'São Paulo', 'App 44C', 'Cartao', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `obs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `financas`
--

CREATE TABLE `financas` (
  `id` int NOT NULL,
  `mes` varchar(20) NOT NULL,
  `recebimento` decimal(10,2) NOT NULL,
  `despesa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `financas`
--

INSERT INTO `financas` (`id`, `mes`, `recebimento`, `despesa`) VALUES
(25, 'Janeiro', 21.00, 21.00),
(26, 'Julho', 17.00, 17.00),
(27, 'Março', 46.00, 80.00),
(28, 'Maio', 80.00, 50.00),
(29, 'Dezembro', 100.00, 12.00),
(30, 'Junho', 20.00, 20.00),
(31, 'Setembro', 544.00, 244.00),
(32, 'Fevereiro', 24.00, 24.00),
(33, 'Abril', 51.00, 32.00),
(34, 'Novembro', 10.00, 5.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
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
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha_usuario`, `codigo_autenticacao`, `data_codigo_autenticacao`) VALUES
(1, 'Gabriel', 'gabrielbraga1324@gmail.com', '$2y$10$/8h3zj2her/0yPi77XGj0OWJBOSdTLdzrep/m6tq3iYSisH49ZsQe', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `financas`
--
ALTER TABLE `financas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
