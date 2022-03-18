-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Mar-2022 às 18:04
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
(0, 'SELECIONE A ASSINATURA', NULL),
(1, 'ASSINATURA TERCILIO', 'public/images/assinaturaTercilio.gif'),
(2, 'ASSINATURA MAURO AUDI', 'public/images/assinaturaMauroAudi.gif'),
(3, 'ASSINATURA MINARDI', 'public/images/assinaturaMinardi.gif'),
(4, 'ASSINATURA ALISSON', 'public/images/trueAss.png');

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
(2, 'I SIMPÓSIO CONAGRA JR.: VISÃO DA ÁREA COMERCIAL DENTRO DE UMA MULTINACIONAL', 6, '2021-11-16', '2021-11-17', 'Medicina Veterinária e Engenharia Agronômica da Universidade');

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
-- Estrutura da tabela `participante_evento`
--

CREATE TABLE `participante_evento` (
  `sequencia_participante` int(11) NOT NULL,
  `evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Extraindo dados da tabela `participante_evento`
--

INSERT INTO `participante_evento` (`sequencia_participante`, `evento`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `posicaotamanho`
--

CREATE TABLE `posicaotamanho` (
  `sequencia` int(11) NOT NULL,
  `posicaoX` int(11) DEFAULT NULL,
  `posicaoY` int(11) DEFAULT NULL,
  `tamanho` int(11) DEFAULT NULL,
  `evento` int(11) NOT NULL
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
-- Índices para tabela `participante_evento`
--
ALTER TABLE `participante_evento`
  ADD KEY `participante_evento_FK` (`sequencia_participante`),
  ADD KEY `participante_evento_FK_1` (`evento`);

--
-- Índices para tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  ADD PRIMARY KEY (`sequencia`),
  ADD KEY `posicaotamanho_FK` (`evento`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinaturas`
--
ALTER TABLE `assinaturas`
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `sequencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `participante_evento`
--
ALTER TABLE `participante_evento`
  ADD CONSTRAINT `participante_evento_FK` FOREIGN KEY (`sequencia_participante`) REFERENCES `participante` (`sequencia`),
  ADD CONSTRAINT `participante_evento_FK_1` FOREIGN KEY (`evento`) REFERENCES `evento` (`sequencia`);

--
-- Limitadores para a tabela `posicaotamanho`
--
ALTER TABLE `posicaotamanho`
  ADD CONSTRAINT `posicaotamanho_FK` FOREIGN KEY (`evento`) REFERENCES `evento` (`sequencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
