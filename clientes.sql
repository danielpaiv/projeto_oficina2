-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/06/2024 às 13:23
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_dados`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `serviço` varchar(45) DEFAULT NULL,
  `data_serv` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `user_id`, `nome`, `cnpj`, `telefone`, `serviço`, `data_serv`, `cidade`, `estado`, `endereco`, `valor`) VALUES
(92, '30', 'Alex', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(93, '31', 'Dailton', '40912304000140', '81993619196', 'limpeza de fachada', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(94, '40', 'Daniel', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '500'),
(95, '41', 'Annie', '40912304000140', '81993619196', 'outro', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '500'),
(96, '42', 'dpaiva266@hotmail.com', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(97, '43', 'Isaias', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(98, '44', 'Mayane', '40912304000140', '81993619196', 'outro', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(99, '44', 'MAyane', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '500'),
(100, '45', 'Alex sandra', '40912304000140', '81993619196', 'outro', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(101, '47', 'Diana', '40912304000140', '81993619196', 'limpeza de fachada', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(103, '40', 'Daniel', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(104, '40', 'Daniel', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-31', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(105, '40', 'Daniel', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(106, '30', 'Alex', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(107, '41', 'Annie', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-31', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(108, '41', 'Annie', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-30', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300'),
(111, '40', 'Daniel', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-31', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(112, '41', 'Annie', '40912304000140', '81993619196', 'limpeza de vidros', '2024-05-31', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '5000'),
(113, '44', 'Mayane', '40912304000140', '81993619196', 'limpeza de vidros', '2024-06-01', 'caruaru', 'PE', 'rua jose martins sobrinho, 575', '300');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
