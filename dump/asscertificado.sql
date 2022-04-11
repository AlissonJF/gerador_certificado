-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Abr-2022 às 16:56
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
(1, 'ASSINATURA TERCILIO', 'public/images/assinaturaTercilio.gif'),
(2, 'ASSINATURA MAURO AUDI', 'public/images/assinaturaMauroAudi.gif'),
(3, 'ASSINATURA MINARDI', 'public/images/assinaturaMinardi.gif'),
(4, 'ALISSON JUAN FEITOZA DA SILVA', 'public/images/trueAss.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos`
--

CREATE TABLE `documentos` (
  `sequencia` int(11) NOT NULL,
  `participantes` int(11) NOT NULL,
  `eventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `documentos`
--

INSERT INTO `documentos` (`sequencia`, `participantes`, `eventos`) VALUES
(1, 1, 1);

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
  `descricao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`sequencia`, `nome`, `ch`, `dataentrada`, `datafinal`, `descricao`) VALUES
(1, 'SEMINÁRIO DE INICIAÇÃO CIENTÍFICA - SEMIC 2021', 4, '2021-09-08', '2021-09-10', 'Nucleo Intergrado de Pesquisa e Extenção da Universidade de Marília'),
(2, 'I SIMPÓSIO CONAGRA JR.: VISÃO DA ÁREA COMERCIAL DENTRO DE UMA MULTINACIONAL', 6, '2021-11-16', '2021-11-17', 'Medicina Veterinária e Engenharia Agronômica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `participante`
--

CREATE TABLE `participante` (
  `sequencia` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `participante`
--

INSERT INTO `participante` (`sequencia`, `nome`, `email`, `cpf`) VALUES
(1, 'ALISSON JUAN FEITOZA DA SILVA', 'alissonruan567@gmail.com', '490.665.548-35'),
(2, 'TESTE PARA TESTAR TESTANDO O TESTE TESTADO', 'teste@gmail.com', '353.747.098-36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posicaotamanho`
--

CREATE TABLE `posicaotamanho` (
  `sequencia` int(11) NOT NULL,
  `posicaoX` int(11) DEFAULT NULL,
  `posicaoY` int(11) DEFAULT NULL,
  `tamanho` int(11) DEFAULT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`sequencia`),
  ADD KEY `documentos_FK` (`eventos`),
  ADD KEY `documentos_FK_1` (`participantes`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`sequencia`);

--
-- Índices para tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  ADD PRIMARY KEY (`sequencia`),
  ADD KEY `posicaotamanho_FK` (`documento`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `documentos`
--
ALTER TABLE `documentos`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `participante`
--
ALTER TABLE `participante`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_FK` FOREIGN KEY (`eventos`) REFERENCES `evento` (`sequencia`),
  ADD CONSTRAINT `documentos_FK_1` FOREIGN KEY (`participantes`) REFERENCES `participante` (`sequencia`);

--
-- Limitadores para a tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  ADD CONSTRAINT `posicaotamanho_FK` FOREIGN KEY (`documento`) REFERENCES `documentos` (`sequencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
