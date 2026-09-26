-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/10/2025 às 03:02
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
-- Banco de dados: `obrasdacidade`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_acesso`
--

CREATE TABLE `tab_acesso` (
  `id` tinyint(4) NOT NULL,
  `nivel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tab_acesso`
--

INSERT INTO `tab_acesso` (`id`, `nivel`) VALUES
(1, 'ADM'),
(2, 'USER');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_obras`
--

CREATE TABLE `tab_obras` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `prazo` date NOT NULL,
  `localizacao` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tab_obras`
--

INSERT INTO `tab_obras` (`id`, `nome`, `descricao`, `prazo`, `localizacao`, `imagem`, `id_status`) VALUES
(3, 'Senai', 'Escola que dispõem curso profissionalizantes', '2025-09-16', 'Rua pedro rachid', '68e9a535c8204-senai-cursos-tecnicos.webp', 2),
(6, 'Escola Senac', 'Escola de Curso Tecnicos', '2025-09-04', 'Rua Saigir Nakamura', '68e9a528be9f0-SJCampos-area-comum-ALTA-COM-FILTRO-copia.jpg', 1),
(9, 'Campo Poliesportivo', 'Centro de Diversão e Recriação', '2025-12-30', 'Rua das Garças', '68e9a657c8124-poliesportivo-vila-tesouro-9.jpg', 2),
(10, 'Tiro de Guerra', 'Escola de Civismo e Cidadania', '2025-10-09', 'Rua Saigiro Nakamura', '68e9a520d2235-tiro-de-guerra-2.jpeg', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_pedidos`
--

CREATE TABLE `tab_pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_obra` int(11) DEFAULT NULL,
  `tipo_pedido` enum('editar','apagar','criar') NOT NULL,
  `novo_nome` varchar(255) DEFAULT NULL,
  `nova_descricao` text DEFAULT NULL,
  `novo_prazo` date DEFAULT NULL,
  `nova_localizacao` varchar(255) DEFAULT NULL,
  `nova_imagem` varchar(255) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `dt_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','aprovado','negado') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tab_pedidos`
--

INSERT INTO `tab_pedidos` (`id`, `id_usuario`, `id_obra`, `tipo_pedido`, `novo_nome`, `nova_descricao`, `novo_prazo`, `nova_localizacao`, `nova_imagem`, `id_status`, `dt_pedido`, `status`) VALUES
(1, 2, 10, 'editar', 'Tiro de Guerra', 'Escola de Civismo e Cidadania', '2025-10-09', 'Rua Saigiro Nakamura', '68e9a520d2235-tiro-de-guerra-2.jpeg', NULL, '2025-10-11 00:30:24', 'aprovado'),
(2, 2, 6, 'editar', 'Escola Senac', 'Escola de Curso Tecnicos', '2025-10-02', 'Rua Saigir Nakamura', '68e9a528be9f0-SJCampos-area-comum-ALTA-COM-FILTRO-copia.jpg', NULL, '2025-10-11 00:30:32', 'aprovado'),
(3, 2, 3, 'editar', 'Senai', 'Escola que dispõem curso profissionalizantes', '2025-09-16', 'Rua pedro rachid', '68e9a535c8204-senai-cursos-tecnicos.webp', NULL, '2025-10-11 00:30:45', 'aprovado'),
(4, 2, 9, 'editar', 'Campo Poliesportivo', 'Centro de Diversão e Recriação', '2025-12-30', 'Rua das Garças', '68e9a657c8124-poliesportivo-vila-tesouro-9.jpg', NULL, '2025-10-11 00:35:35', 'aprovado'),
(5, 2, 6, 'editar', 'Escola Senac', 'Escola de Curso Tecnicos', '2025-09-04', 'Rua Saigir Nakamura', NULL, NULL, '2025-10-11 00:38:57', 'aprovado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_status`
--

CREATE TABLE `tab_status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tab_status`
--

INSERT INTO `tab_status` (`id_status`, `status`) VALUES
(1, 'em andamento'),
(2, 'planejada'),
(3, 'concluida');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_usuarios`
--

CREATE TABLE `tab_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(80) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` tinyint(4) NOT NULL,
  `dt_criacao` date DEFAULT current_timestamp(),
  `email` varchar(80) NOT NULL,
  `telefone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tab_usuarios`
--

INSERT INTO `tab_usuarios` (`id`, `usuario`, `senha`, `nivel_acesso`, `dt_criacao`, `email`, `telefone`) VALUES
(1, 'adm', '123', 1, '2025-09-16', 'adm@adm.com', '123123123'),
(2, 'pedro', '123', 2, '2025-09-16', 'pedro@gmail.com', '123123123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tab_acesso`
--
ALTER TABLE `tab_acesso`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tab_obras`
--
ALTER TABLE `tab_obras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status` (`id_status`);

--
-- Índices de tabela `tab_pedidos`
--
ALTER TABLE `tab_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tab_status`
--
ALTER TABLE `tab_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Índices de tabela `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nivel` (`nivel_acesso`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tab_acesso`
--
ALTER TABLE `tab_acesso`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tab_obras`
--
ALTER TABLE `tab_obras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tab_pedidos`
--
ALTER TABLE `tab_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tab_status`
--
ALTER TABLE `tab_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tab_obras`
--
ALTER TABLE `tab_obras`
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`id_status`) REFERENCES `tab_status` (`id_status`);

--
-- Restrições para tabelas `tab_usuarios`
--
ALTER TABLE `tab_usuarios`
  ADD CONSTRAINT `fk_nivel` FOREIGN KEY (`nivel_acesso`) REFERENCES `tab_acesso` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
