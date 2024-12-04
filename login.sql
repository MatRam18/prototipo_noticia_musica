-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/12/2024 às 01:19
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor_id` int(11) NOT NULL,
  `status` enum('pendente','aprovado') DEFAULT 'pendente',
  `imagem` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `data_criacao`, `autor_id`, `status`, `imagem`) VALUES
(8, 'Kanye West Inocentado Com O Tempo???', 'Após as polemicas envolvendo o rapper e produtor P Diddy, surgiu um questionamento entres os internautas, seria o Kanye West o verdadeiro visionário?\r\nDesde muito tempo não é novidade que o Kanye West vem sendo taxado como louco por suas falas extremamente questionáveis, mas uma coisa é certa, o mesmo sempre veio denuncia várias coisas que vem acontecendo em hollywood e entre vários famosos, porém, sempre foi taxado de maluco por suas acusações mas pelo jeito o jogo virou.\r\nVários fans vem falando coisas como \"não é o Kanye West que está mentindo, e sim a verdade que esta errada\" ou \"No dia que o Kanye West estiver errado o mundo estará perdido\".\r\nApesar de certa forma o mesmo está certo sobre várias de suas acusações, será que Kanye West esta realmente Lucido? vai da opinião do leitor decidir isso.', '2024-12-02 22:30:40', 3, 'aprovado', 0x75706c6f61642f79652e706e67),
(9, 'Feliz Aniversário Juicy Wrld', 'Hoje, dia 2 de dezembro de 2024 é aniversário de umas das grandes lendas do soundcloud rap, Jarad Anthony Higgins ou popurlamente conhecido como Juicy Wrld, o mesmo faria 26 anos hoje se ele não tivesse morrido de overdose no dia 8 de dezembro de 2019 no \r\nAdvocate Christ Medical Center.\r\nNão usem drogas rapaziada.', '2024-12-02 23:44:19', 3, 'aprovado', 0x75706c6f61642f6a756963792e6a7067),
(10, 'Tyler The Creator Fala Da Sua Esperiencia Com Limão', 'Tyler the creator fala sobre a sua primeira esperiencia com limão, \"É azedo\" disse tyler.', '2024-12-02 23:50:43', 3, 'aprovado', 0x75706c6f61642f74796c65722e706e67),
(11, 'Travis Scott É Visto Sendo Confundido Com Um Peixe', 'Travis Scott foi visto sendo comparado com um peixe \"eu não sou o Travis, eu sou o peixonauta\" disse o Travis Scott.', '2024-12-02 23:56:33', 3, 'aprovado', 0x75706c6f61642f7472617669732e6a706567),
(12, 'Travis Scott', 'Travis Scott', '2024-12-02 23:57:18', 3, 'pendente', 0x75706c6f61642f7472617669732d73636f74742e706e67),
(13, 'Mc Kung Fu Panda desiste da profissão e vira agressor', 'O famigerado Pô, mais conhecido mundialmente Kung Fu Panda, decidiu desistir da carreira de Dragão Guerreiro, detentor das artes marciais místicas para se tornar agressor doméstico e cantor de funk, com seus trabalho mais conhecidos a voadora na cara de sua namorada \"Gi Roque\" e seu verso na musica com MC IG, onde o ex-dragão guerreiro diz : \"nois come bosta\". Será que ele fez a escolha certa ? ', '2024-12-03 00:14:06', 3, 'aprovado', 0x75706c6f61642f70616e64612e6a7067);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `login` varchar(80) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `role` enum('admin','escritor') NOT NULL DEFAULT 'escritor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nome`, `login`, `senha`, `role`) VALUES
(2, 'Rogerios', 'rog@gmail.com', '123456', 'admin'),
(3, 'Bruno', 'fonsecabruno6062@gmail.com', '123456789', 'escritor'),
(4, 'Roberto gomes bolais', 'cu@cu.com', 'cu', 'admin'),
(5, 'lahdsbv', 'teste@teste.com', 'teste', 'admin'),
(6, 'Bruno', 'u@gmail.com', 'Coxinha2007.', 'escritor'),
(7, 'lenon', 'lenon@gmail.com', '123456', 'escritor'),
(8, 'Bruno', 'bruno@teste.com', 'rubel', 'escritor');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
