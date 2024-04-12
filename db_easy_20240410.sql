-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/04/2024 às 00:24
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
-- Banco de dados: `db_easy_20240410`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcoes`
--

CREATE TABLE `funcoes` (
  `id` int(11) NOT NULL,
  `nome_funcao` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `funcoes`
--

INSERT INTO `funcoes` (`id`, `nome_funcao`, `descricao`, `criado_em`, `atualizado_em`) VALUES
(1, 'Desenvolvedor de Software', 'Responsável pelo desenvolvimento de software e manutenção de sistemas.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(2, 'Engenheiro de Dados', 'Responsável por projetar, construir e manter sistemas de gerenciamento de dados.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(3, 'Analista de Marketing Digital', 'Responsável pela análise de dados e estratégias para campanhas de marketing online.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(4, 'Gerente de Projeto', 'Responsável por planejar, executar e monitorar projetos.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(5, 'Designer Gráfico', 'Responsável pela criação de elementos visuais para comunicação.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(6, 'Especialista em Recursos Humanos', 'Responsável por recrutamento, seleção e desenvolvimento de pessoal.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(7, 'Analista Financeiro', 'Responsável pela análise de dados financeiros e elaboração de relatórios.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(8, 'Engenheiro de Software', 'Responsável pela concepção e desenvolvimento de software.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(9, 'Analista de Sistemas', 'Responsável pela análise e implementação de sistemas de informação.', '2024-04-11 01:21:29', '2024-04-11 01:21:29'),
(10, 'Consultor de Negócios', 'Responsável por fornecer orientação estratégica e soluções para empresas.', '2024-04-11 01:21:29', '2024-04-11 01:21:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `id_funcao` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nome_usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `rg` varchar(50) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `cep` varchar(50) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_funcao`, `nome`, `nome_usuario`, `senha`, `rg`, `cpf`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `uf`, `criado_em`, `atualizado_em`) VALUES
(1, 1, 'Matheus', 'matheusv', '202cb962ac59075b964b07152d234b70', '1234567-8', '123.456.789-01', '12345-678', 'Rua A', '123', 'Bairro A', 'Cidade A', '', '2024-04-11 01:25:04', '2024-04-11 23:02:48'),
(2, 2, 'José', 'usuario2', '202cb962ac59075b964b07152d234b70', '2345678-9', '234.567.890-12', '23456-789', 'Rua B', '234', 'Bairro B', 'Cidade B', '', '2024-04-11 01:25:04', '2024-04-11 23:01:21'),
(3, 3, 'Juliano', 'usuario3', '202cb962ac59075b964b07152d234b70', '3456789-0', '345.678.901-23', '34567-890', 'Rua C', '345', 'Bairro C', 'Cidade C', '', '2024-04-11 01:25:04', '2024-04-11 23:02:35'),
(4, 4, 'Maria Samara', 'msvieira', '202cb962ac59075b964b07152d234b70', '1231231231', '123123123', '12060390', 'Rua sebastiana Maria de jesus', '235', 'Granja Daniel', 'Taubaté', 'SP', '2024-04-11 01:25:04', '2024-04-11 23:02:44'),
(5, 5, 'Silvana', 'usuario5', '202cb962ac59075b964b07152d234b70', '5678901-2', '567.890.123-45', '56789-012', 'Rua E', '567', 'Bairro E', 'Cidade E', '', '2024-04-11 01:25:04', '2024-04-11 23:02:53'),
(6, 6, 'Jorge', 'usuario6', '202cb962ac59075b964b07152d234b70', '6789012-3', '678.901.234-56', '67890-123', 'Rua F', '678', 'Bairro F', 'Cidade F', '', '2024-04-11 01:25:04', '2024-04-11 23:01:13'),
(7, 7, 'Henrique', 'usuario7', '202cb962ac59075b964b07152d234b70', '7890123-4', '789.012.345-67', '78901-234', 'Rua G', '789', 'Bairro G', 'Cidade G', '', '2024-04-11 01:25:04', '2024-04-11 23:01:05'),
(8, 8, 'Isabel', 'usuario8', '202cb962ac59075b964b07152d234b70', '8901234-5', '890.123.456-78', '89012-345', 'Rua H', '890', 'Bairro H', 'Cidade H', '', '2024-04-11 01:25:04', '2024-04-11 23:01:09'),
(9, 9, 'Andreia Vieira', 'usuario9', '202cb962ac59075b964b07152d234b70', '9012345-6', '901.234.567-89', '90123-456', 'Rua I', '901', 'Bairro I', 'Taubaté', 'SP', '2024-04-11 01:25:04', '2024-04-11 23:01:01'),
(10, 10, 'Lia', 'usuario10', '202cb962ac59075b964b07152d234b70', '0123456-7', '012.345.678-90', '01234-567', 'Rua J', '012', 'Bairro J', 'Cidade J', '', '2024-04-11 01:25:04', '2024-04-11 23:02:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcoes`
--
ALTER TABLE `funcoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_usuario` (`nome_usuario`),
  ADD KEY `funcaoId` (`id_funcao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcoes`
--
ALTER TABLE `funcoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_funcao`) REFERENCES `funcoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
