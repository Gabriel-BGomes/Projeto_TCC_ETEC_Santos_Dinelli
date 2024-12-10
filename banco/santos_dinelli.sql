-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2024 at 01:20 PM
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
  `numero` int DEFAULT NULL,
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
  `numero_pj` int DEFAULT NULL,
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

INSERT INTO `clientes` (`id`, `tipo_pessoa`, `nome_cliente`, `email_cliente`, `cpf_cliente`, `data_nascimento`, `telefone`, `endereco`, `numero`, `bairro`, `cep`, `cidade`, `complemento`, `forma_pagamento`, `razao_social`, `email_cliente_pj`, `cnpj`, `telefone_pj`, `endereco_pj`, `numero_pj`, `cep_pj`, `referencia_pj`, `bairro_pj`, `cidade_pj`, `complemento_pj`, `forma_pagamento_pj`) VALUES
(64, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Asap Telecomunicações', 'asaptelecomunicacao@asap.com', '12.039.193/2131-23', '(11) 9321-3123', 'Avenida das Nações Unidas', 0, '04795-000', 'ao lado da ri happy', 'Vila Almeida', 'São Paulo', 'sp office', 'Boleto'),
(69, 1, 'Leonardo Santos', 'leolegal@gmail.com', '653.635.636-54', '2001-02-10', '(11) 98765-7567', 'Rua C ', 152, 'Jardim Santa Cruz (Sacomã)', '04182-135', 'São Paulo', 'App 444', 'Crédito', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 1, 'Ana Beatriz Souza', 'ana.souza@email.com', '987.654.321-00', '1988-04-22', '(11) 99876-5432', 'Avenida Paulista', 1010, 'Bela Vista', '01311-200', 'São Paulo', 'Apartamento 12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 1, 'Mariana Oliveira', 'mariana.oliveira@email.com', '765.432.109-23', '1985-07-19', '(41) 98456-7890', 'Rua XV de Novembro', 650, 'Centro', '80210-220', 'Curitiba', 'Sem complemento', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 1, 'Gabriel Santos Silva', 'gabriel.santos@email.com', '654.321.098-34', '2000-11-05', '(61) 99912-3456', 'Quadra QI 1', 45, 'Guará', '71010-020', 'Brasília', 'Bloco A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 1, 'Juliana Alves Martins', 'juliana.martins@email.com', '543.210.987-45', '1995-02-18', '(81) 98834-5678', 'Rua do Sol', 112, 'Boa Vista', '50020-100', 'Recife', 'Prédio Comercial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 1, 'Rafael Costa', 'rafael.costa@email.com', '432.109.876-56', '1989-08-25', '(31) 97766-5432', 'Avenida Afonso Pena', 1700, 'Centro', '30310-420', 'Belo Horizonte', 'Cobertura', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 1, 'Camila Barbosa', 'camila.barbosa@email.com', '321.098.765-67', '1993-06-30', '(71) 91123-4567', 'Rua Almirante Barroso', 55, 'Barra', '40140-070', 'Salvador', 'Loft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 1, 'Thiago Ribeiro', 'thiago.ribeiro@email.com', '210.987.654-78', '1987-12-11', '(51) 99765-4321', 'Avenida Ipiranga', 222, 'Menino Deus', '90160-070', 'Porto Alegre', 'Casa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 1, 'Larissa Moura', 'larissa.moura@email.com', '109.876.543-89', '1996-01-20', '(85) 99412-5678', 'Rua Dom Luís', 80, 'Meireles', '60150-150', 'Fortaleza', 'Apartamento 301', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 1, 'Pedro Henrique Almeida', 'pedro.almeida@email.com', '098.765.432-10', '1992-05-02', '(62) 99911-2233', 'Rua 9', 320, 'Setor Central', '74020-060', 'Goiânia', 'Prédio Residencial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 1, 'Fernanda Carvalho', 'fernanda.carvalho@email.com', '456.789.123-00', '1998-03-12', '(91) 98822-3344', 'Rua Presidente Vargas', 870, 'Campina', '66050-000', 'Belém', 'Sem complemento', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 1, 'Ricardo Pereira', 'ricardo.pereira@email.com', '567.891.234-11', '1982-12-01', '(47) 99933-4455', 'Rua XV de Novembro', 525, 'Centro', '89010-970', 'Blumenau', 'Sala Comercial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 1, 'Aline Torres', 'aline.torres@email.com', '678.912.345-22', '1990-07-27', '(27) 99744-5566', 'Rua Sete de Setembro', 315, 'Centro', '29010-500', 'Vitória', 'Apartamento 5A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 1, 'Felipe Gonçalves', 'felipe.goncalves@email.com', '789.123.456-33', '1994-10-14', '(13) 99655-6677', 'Avenida Ana Costa', 980, 'Gonzaga', '11065-100', 'Santos', 'Cobertura', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 1, 'Isabela Nunes', 'isabela.nunes@email.com', '890.234.567-44', '1991-08-03', '(45) 99977-7788', 'Avenida Brasil', 435, 'Centro', '85850-000', 'Foz do Iguaçu', 'Loja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 1, 'Daniel Rocha', 'daniel.rocha@email.com', '901.345.678-55', '1997-04-09', '(19) 99388-8899', 'Rua Barão de Itapura', 123, 'Cambuí', '13026-320', 'Campinas', 'Casa 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 1, 'Tatiana Rezende', 'tatiana.rezende@email.com', '012.345.678-66', '1993-05-18', '(82) 99799-9911', 'Rua Deputado José Lages', 590, 'Ponta Verde', '57050-120', 'Maceió', 'Apartamento 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 1, 'Rodrigo Teixeira', 'rodrigo.teixeira@email.com', '123.456.789-77', '1999-09-09', '(16) 98888-8822', 'Avenida Nove de Julho', 340, 'Jardim América', '14020-360', 'Ribeirão Preto', 'Sobrado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 1, 'Paula Macedo', 'paula.macedo@email.com', '234.567.890-88', '1986-06-06', '(83) 99877-7722', 'Avenida Epitácio Pessoa', 650, 'Tambaú', '58040-450', 'João Pessoa', 'Duplex', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 1, 'André Moreira', 'andre.moreira@email.com', '345.678.901-99', '1985-11-24', '(79) 99666-6611', 'Rua João Pessoa', 310, 'São José', '49035-040', 'Aracaju', 'Galpão', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tech Solutions Ltda.', 'contato@techsolutions.com.br', '12.345.678/0001-90', '(11) 99876-5432', 'Rua das Inovações', 101, '01311-200', 'Próximo ao Shopping', 'Centro', 'São Paulo', 'Sala 12', 'Cartão de Crédito'),
(93, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Comércio Brasil Eireli', 'vendas@comerciobrasil.com', '23.456.789/0001-01', '(21) 91234-5678', 'Avenida dos Negócios', 250, '22031-070', 'Ao lado da Praça Central', 'Copacabana', 'Rio de Janeiro', 'Prédio Comercial', 'Boleto'),
(94, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alimentos Saudáveis SA', 'financeiro@alimentos.com.br', '34.567.890/0001-12', '(41) 98456-7890', 'Rua do Mercado', 78, '80210-220', 'Em frente ao Mercado Central', 'Centro', 'Curitiba', 'Armazém', 'Transferência Bancária'),
(95, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Construtora Boa Obra Ltda.', 'contato@boaobra.com.br', '45.678.901/0001-23', '(61) 99912-3456', 'Quadra Empresarial', 150, '71010-020', 'Próximo ao Tribunal', 'Asa Sul', 'Brasília', 'Sem complemento', 'Pix'),
(96, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Educar Mais Instituto', 'info@educarmais.org', '56.789.012/0001-34', '(81) 98834-5678', 'Avenida da Educação', 90, '50020-100', 'Ao lado da Escola Modelo', 'Boa Vista', 'Recife', 'Edifício Educação', 'Boleto'),
(97, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Auto Peças Vitória Ltda.', 'suporte@autovitoria.com.br', '67.890.123/0001-45', '(31) 97766-5432', 'Rua dos Motores', 1345, '30310-420', 'Próximo à Oficina Central', 'Centro', 'Belo Horizonte', 'Galpão', 'Cartão de Débito'),
(98, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Clínica Vida e Saúde', 'atendimento@vidasaude.com.br', '78.901.234/0001-56', '(71) 91123-4567', 'Rua das Clínicas', 50, '40140-070', 'Ao lado do Hospital Geral', 'Barra', 'Salvador', 'Edifício Médico', 'Dinheiro'),
(99, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agro Campo S.A.', 'contato@agrocampo.com.br', '89.012.345/0001-67', '(51) 99765-4321', 'Estrada da Produção', 500, '90160-070', 'Próximo à Fazenda Boa Vista', 'Zona Rural', 'Porto Alegre', 'Sem complemento', 'Transferência Bancária'),
(100, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Móveis Planejados Design', 'comercial@planejadosdesign.com', '90.123.456/0001-78', '(85) 99412-5678', 'Rua dos Arquitetos', 212, '60150-150', 'Ao lado do Shopping Casa', 'Meireles', 'Fortaleza', 'Showroom', 'Cartão de Crédito'),
(101, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Transportes Rápidos Eireli', 'logistica@transportesrapidos.com', '01.234.567/0001-89', '(62) 99911-2233', 'Avenida Logística', 88, '74020-060', 'Próximo ao Terminal Rodoviário', 'Setor Central', 'Goiânia', 'Sem complemento', 'Boleto'),
(102, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Energias Renováveis Ltda.', 'energia@renovaveis.com.br', '12.345.678/0001-01', '(91) 98822-3344', 'Rua da Sustentabilidade', 303, '66050-000', 'Próximo à Praça Verde', 'Campina', 'Belém', 'Escritório Central', 'Pix'),
(103, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Construmax Comércio Ltda.', 'vendas@construmax.com.br', '23.456.789/0001-02', '(47) 99933-4455', 'Avenida das Construções', 999, '89010-970', 'Em frente ao Parque Industrial', 'Centro', 'Blumenau', 'Prédio Industrial', 'Boleto'),
(104, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Instituto de Pesquisa Alfa', 'alfa@institutopesquisa.com', '34.567.890/0001-03', '(27) 99744-5566', 'Rua das Ideias', 456, '29010-500', 'Próximo à Biblioteca Central', 'Centro', 'Vitória', 'Laboratório', 'Cartão de Crédito'),
(105, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Fábrica de Roupas Sempre Bela', 'moda@semprebela.com.br', '45.678.901/0001-04', '(13) 99655-6677', 'Rua dos Tecidos', 789, '11065-100', 'Ao lado do Ateliê Central', 'Gonzaga', 'Santos', 'Galpão de Costura', 'Dinheiro'),
(106, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Etec Heliópolis Arq. Ruy Ohtake', 'etecheliopolis@etec.sp.gov.br', '62.823.257/0001-09', '(11) 8312-3123', 'Estrada das Lágrimas', 2461, '09642-000', '', 'Ipiranga', 'São Paulo', 'dentro do Céu Heliópolis', 'Pix'),
(107, 1, 'Leonardo Dinelli', 'leodinelli@gmail.com', '578.457.378-69', '1990-02-27', '(11) 98744-8574', 'Rua C', 152, 'Jardim Santa Cruz (Sacomã)', '04182-135', 'São Paulo', 'App 33', 'Boleto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(125, 'Gravação do pitch', '#436EEE', '2024-11-18 10:00:00', '2024-11-18 12:00:00', 'levar notebook', 'Visita', 64),
(130, 'Ronaldo WorkShop', '#228B22', '2024-11-02 11:00:00', '2024-11-02 11:40:00', 'dfas', 'PMOC', 64),
(138, 'Desinstalação', '#436EEE', '2024-12-02 13:00:00', '2024-12-02 14:00:00', 'sem obs', 'Desinstalação', 64),
(153, 'Larissa Sacomã', '#FF4500', '2024-12-06 13:10:00', '2024-12-09 15:45:00', 'Iram ser realizadas instalações na áreas extrenas da varanda.\r\n', 'Instalação', 80),
(154, 'Pedro NovaTec', '#8B0000', '2024-12-12 13:45:00', '2024-12-12 20:30:00', '', 'Higienização', 81),
(155, 'Transportes Eireli', '#0071c5', '2024-12-17 14:20:00', '2024-12-17 15:00:00', '', 'Manutenção preventiva', 101),
(156, 'Manutenção', '#1C1C1C', '2024-12-02 11:00:00', '2024-12-02 12:00:00', '', 'Manutenção preventiva', 75),
(157, 'Visita para prevenção', '#FFD700', '2024-12-03 14:00:00', '2024-12-03 15:00:00', 'levar parafuso', 'Visita', 69),
(158, 'Conserto', '#1C1C1C', '2024-12-03 10:00:00', '2024-12-03 11:00:00', 'chegar com antecedência', 'Manutenção Corretiva', 85),
(159, 'Instalação na empresa', '#8B0000', '2024-12-18 10:00:00', '2024-12-20 18:00:00', 'levar todo material necessário para instalação de 10 ar condicionados', 'Instalação', 104),
(160, 'Manutenção na empresa', '#436EEE', '2024-12-10 14:00:00', '2024-12-10 18:00:00', '', 'Manutenção preventiva', 100),
(161, 'Manutenção na empresa', '#FF4500', '2024-12-05 09:00:00', '2024-12-05 11:00:00', 'sem obs', 'Manutenção Corretiva', 78),
(162, 'Fazer laudo para cliente', '#A020F0', '2024-12-05 10:00:00', '2024-12-05 10:30:00', '', 'Laudos', 79),
(163, 'Visita ', '#436EEE', '2024-12-11 09:00:00', '2024-12-11 11:00:00', 'verificar ar condicionados', 'Visita', 101),
(164, 'Venda para Larissa', '#FF4500', '2024-12-11 14:00:00', '2024-12-11 15:30:00', 'levar modelos da LG', 'Venda', 80),
(165, 'Desinstalar ar condicionado', '#8B4513', '2024-12-13 10:00:00', '2024-12-13 13:00:00', 'nenhuma', 'Desinstalação', 69),
(166, 'Instalação na Clínica', '#A020F0', '2024-12-14 13:00:00', '2024-12-16 17:00:00', '', 'Instalação', 98),
(167, 'Visitar para consulta de espaço', '#228B22', '2024-12-18 08:00:00', '2024-12-18 09:00:00', '', 'Visita', 104),
(168, 'Instalação para Camila Barbosa', '#1C1C1C', '2024-12-19 08:00:00', '2024-12-19 09:30:00', 'tentar acabar o quanto antes para chegar a tempo', 'Instalação', 78),
(169, 'Higienizar Auto Peças', '#FF4500', '2024-12-20 07:00:00', '2024-12-20 09:20:00', 'levar kit de limpeza', 'Higienização', 97),
(170, 'Visita para verificação', '#A020F0', '2024-12-23 10:00:00', '2024-12-23 11:00:00', '', 'Visita', 64),
(171, 'Visita Juliana', '#A020F0', '2024-12-23 13:00:00', '2024-12-23 13:30:00', '', 'Contrato de manutenção preventiva e corretiva', 76),
(172, 'Visita Aline', '#A020F0', '2024-12-23 14:00:00', '2024-12-23 15:00:00', '', 'Higienização', 84),
(173, 'Visita Larissa', '#A020F0', '2024-12-23 16:30:00', '2024-12-23 18:00:00', '', 'Visita', 80),
(174, 'Apresentação de todo o sistema funcionando', '#FF4500', '2024-12-04 13:00:00', '2024-12-04 18:00:00', 'levar todo equipamento necessário para fazer a apresentação', 'Visita', 106);

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
(25, 'Janeiro', 0.00, 0.00),
(26, 'Julho', 42203.00, 22359.00),
(27, 'Março', 82615.00, 53417.00),
(28, 'Maio', 42183.00, 32173.00),
(29, 'Dezembro', 93224.00, 53303.00),
(30, 'Junho', 50251.00, 31023.00),
(31, 'Setembro', 74045.00, 61393.00),
(32, 'Fevereiro', 60346.00, 30147.00),
(33, 'Abril', 43174.00, 35353.00),
(34, 'Novembro', 62359.00, 42315.00),
(35, 'Outubro', 42410.00, 46741.00),
(36, 'Agosto', 30423.00, 33714.00);

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
  `data_codigo_autenticacao` datetime DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiracao` datetime DEFAULT NULL,
  `pin_financeiro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha_usuario`, `codigo_autenticacao`, `data_codigo_autenticacao`, `remember_token`, `token_expiracao`, `pin_financeiro`) VALUES
(1, 'Gabriel Braga', 'gabrielbraga1324@gmail.com', '$2y$10$/8h3zj2her/0yPi77XGj0OWJBOSdTLdzrep/m6tq3iYSisH49ZsQe', 969733, '2024-12-02 18:05:49', NULL, NULL, '583765'),
(2, 'Matheus Estevam', 'matheusoliveirale2007@gmail.com', '$2y$10$cOVHEAkpxJfNCxA5Q4n9/OEJQu36rX1x0Q7h.Degbh1tJB.R31XWy', 932659, '2024-12-04 14:36:17', NULL, NULL, '$2y$10$Q5ja5LoRiBOWIZZhSkXXPuAFhjZV16X7vfOZ57YoMsZ1HpnvBycaq'),
(3, 'Marcos Autilio', 'prautilio@gmail.com', '$2y$10$dfwfDUY3eQpxFAB/3SK0.er6hYEtn2aS3v1zD7S/raWIaRG5vRJuK', NULL, NULL, NULL, NULL, '$2y$10$Q5ja5LoRiBOWIZZhSkXXPuAFhjZV16X7vfOZ57YoMsZ1HpnvBycaq'),
(4, 'Leonardo Dinelli', 'leodinelli2007@gmail.com', '$2y$10$EUjP2juukHK7cDTgY4P5IOZiL6vgrPo9v/L45ku33qtR2toOdPVWq', NULL, NULL, NULL, NULL, '$2y$10$EUjP2juukHK7cDTgY4P5IOZiL6vgrPo9v/L45ku33qtR2toOdPVWq'),
(5, 'Henrick Gomes', 'henrickgomes46@gmail.com', '$2y$10$sKSYqTve.IP8KM9YqcCTf.jEaZMdXu1Lvm3z.VGzrg.od./srVwh6', NULL, NULL, NULL, NULL, '0'),
(6, 'Matheus Ribeiro', 'matheusribeiro2409@outlook.com ', '$2y$10$eIaKTCE3Y.P.src/1C2pF.7dml6VAd0bE09SOr4rir0.VFfVt2XAi', 630028, '2024-09-27 10:15:30', NULL, NULL, '0');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
