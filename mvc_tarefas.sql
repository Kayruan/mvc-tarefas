-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/06/2026 às 22:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mvc_tarefas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `prioridade` enum('Alta','Média','Baixa') NOT NULL DEFAULT 'Média',
  `status_tarefa` varchar(50) DEFAULT 'Agendada',
  `data_limite` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `data_tarefa` date DEFAULT NULL,
  `hora_tarefa` time DEFAULT NULL,
  `duracao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `titulo`, `descricao`, `prioridade`, `status_tarefa`, `data_limite`, `criado_em`, `imagem`, `data_tarefa`, `hora_tarefa`, `duracao`) VALUES
(8, 'Terminar o Trabalho sem Bugar as IMAGENS', 'TURURU ', 'Alta', 'Em Andamento', '2026-06-23', '2026-06-23 00:23:34', '1782174214.png', '2026-06-22', '18:30:00', 1),
(9, 'Dormir', 'Dormir de Domingo até segunda feira', 'Alta', 'Agendada', NULL, '2026-06-28 20:20:51', '1782678051.webp', '2026-06-28', '23:00:00', 12);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
