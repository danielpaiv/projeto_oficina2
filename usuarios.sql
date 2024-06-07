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
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `sobrenome` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `user_id`, `email`, `nome`, `sobrenome`, `senha`, `role`) VALUES
(30, '02', 'dpaiva267@gmail.com', 'Alex', 'Clara', '0101', 'user'),
(31, '03', 'dpaiva444@hotmail.com', 'Dailton', 'Paiva', '000', 'user'),
(40, '01', 'dpaiva266@hotmail.com', 'daniel', 'paiva', '36', 'user'),
(41, '04', 'ClaraPaiva@gmail.com', 'Annie', 'Clara', '02', 'user'),
(42, '05', 'dpaiva266@hotmail.com', 'dpaiva266@hotmail.com', 'Paiva', '000', 'admin'),
(43, NULL, 'Isaias@gmail.com', 'Isaias', 'Araujo', '03', NULL),
(44, '1', 'mayane@gmail.com', 'MAyane', 'Araujo', '01', NULL),
(45, '2', 'Alexsandra@gmail.com', 'Alexsandra', 'Florêncio', '02', 'user'),
(47, '22', 'Diana@gmail.com', 'Diana', 'Paiva', '04', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
