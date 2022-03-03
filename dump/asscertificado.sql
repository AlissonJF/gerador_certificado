-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Mar-2022 às 17:43
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `asscertificado`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `sequencia` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`sequencia`, `nome`, `email`, `cpf`) VALUES
(1, 'ALISSON JUAN FEITOZA DA SILVA', 'alissonruan567@gmail.com', '490.665.548-35'),
(2, 'TESTE PARA TESTAR TESTANDO O TESTE TESTADO', 'teste@gmail.com', '353.747.098-36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `assinaturas`
--

CREATE TABLE `assinaturas` (
  `sequencia` int(11) NOT NULL,
  `nomeassinatura` varchar(100) NOT NULL,
  `caminho` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `assinaturas`
--

INSERT INTO `assinaturas` (`sequencia`, `nomeassinatura`, `caminho`) VALUES
(1, 'assinatura Tercilio', 'public/images/assinaturaTercilio.gif'),
(2, 'assinatura Mauro Audi', 'public/images/assinaturaMauroAudi.gif'),
(3, 'assinatura Minardi', 'public/images/assinaturaMinardi.gif'),
(4, 'assinatura Alisson', 'public/images/assinaturaAlisson.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `sequencia` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ch` int(11) NOT NULL,
  `dataentrada` date NOT NULL,
  `datafinal` date NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `aluno` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`sequencia`, `nome`, `ch`, `dataentrada`, `datafinal`, `descricao`, `aluno`) VALUES
(1, 'SEMINÁRIO DE INICIAÇÃO CIENTÍFICA - SEMIC 2021', 4, '2021-09-08', '2021-09-10', 'Nucleo Intergrado de Pesquisa e Extenção da Universidade de Marília', '490.665.548-35'),
(2, 'I SIMPÓSIO CONAGRA JR.: VISÃO DA ÁREA COMERCIAL DENTRO DE UMA MULTINACIONAL', 6, '2021-11-16', '2021-11-17', 'Medicina Veterinária e Engenharia Agronômica da Universidade', '353.747.098-36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posicaotamanho`
--

CREATE TABLE `posicaotamanho` (
  `sequencia` int(11) NOT NULL,
  `assinatura` int(11) NOT NULL,
  `posicaoX` int(11) DEFAULT NULL,
  `posicaoY` int(11) DEFAULT NULL,
  `tamanho` int(11) DEFAULT NULL,
  `aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `posicaotamanho`
--

INSERT INTO `posicaotamanho` (`sequencia`, `assinatura`, `posicaoX`, `posicaoY`, `tamanho`, `aluno`) VALUES
(1, 1, 20, 140, 60, 1),
(2, 2, 20, 140, 60, 1),
(3, 3, 20, 140, 60, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  ADD PRIMARY KEY (`sequencia`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
