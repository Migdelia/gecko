-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 12-Jul-2013 às 17:40
-- Versão do servidor: 5.5.31-0ubuntu0.13.04.1
-- versão do PHP: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `leitura`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Config`
--

CREATE TABLE IF NOT EXISTS `Config` (
  `id` int(10) unsigned NOT NULL,
  `currencyName` varchar(5) NOT NULL,
  `denomination` bigint(10) NOT NULL,
  `percentage` bigint(10) NOT NULL,
  `machineType` tinyint(1) NOT NULL,
  `acumuladoMin` bigint(10) NOT NULL,
  `acumuladoMax` bigint(10) NOT NULL,
  `currentAcu` bigint(10) NOT NULL,
  `jackpotValue` bigint(10) NOT NULL,
  `limDouble` bigint(10) NOT NULL,
  `db` tinyint(1) NOT NULL,
  `fam` tinyint(1) NOT NULL,
  `fav` bigint(10) NOT NULL,
  `payoutLim` bigint(10) NOT NULL,
  `billValid` varchar(18) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Config`
--

INSERT INTO `Config` (`id`, `currencyName`, `denomination`, `percentage`, `machineType`, `acumuladoMin`, `acumuladoMax`, `currentAcu`, `jackpotValue`, `limDouble`, `db`, `fam`, `fav`, `payoutLim`, `billValid`) VALUES
(4637, '$', 10, 94, 1, 370, 400, 390004000, 200, 20000, 1, 1, 10000, 2000, '1;2;5;10;20;50;100'),
(4641, '$', 10, 94, 1, 370, 400, 370000000, 200, 20000, 1, 1, 10000, 2000, '1;2;5;10;20;50;100'),
(4645, '$', 10, 94, 1, 370, 400, 370328000, 200, 20000, 1, 1, 10000, 2000, '1;2;5;10;20;50;100'),
(4843, '$', 10, 94, 1, 370, 400, 374790000, 200, 30000, 1, 1, 20000, 2000, '1;2;5;10;20;50;100'),
(4845, '$', 10, 94, 1, 370, 400, 378310000, 200, 30000, 1, 1, 20000, 2000, '1;2;5;10;20;50;100'),
(4846, '$', 10, 94, 1, 370, 400, 370004000, 250, 20000, 1, 1, 10000, 2000, '1;2;5;10;20;50;100'),
(4868, '$', 20, 94, 1, 380, 400, 400262000, 400, 30000, 1, 1, 20000, 3000, '1;2;5;10;20;50;100');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Payout`
--

CREATE TABLE IF NOT EXISTS `Payout` (
  `id` int(10) unsigned NOT NULL,
  `dateNow` datetime NOT NULL,
  `vPayout` bigint(10) NOT NULL,
  `cPayout` bigint(20) NOT NULL,
  `mPayout` bigint(20) NOT NULL,
  `keyPayout` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Reading`
--

CREATE TABLE IF NOT EXISTS `Reading` (
  `id` int(10) unsigned NOT NULL,
  `issueDate` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `ip6` varchar(40) NOT NULL,
  `mac` varchar(20) NOT NULL,
  `uptime` bigint(10) NOT NULL,
  `hwid` varchar(5) NOT NULL,
  `single` tinyint(1) NOT NULL,
  `getCredits` bigint(20) NOT NULL,
  `addCredits` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Reading`
--

INSERT INTO `Reading` (`id`, `issueDate`, `ip`, `ip6`, `mac`, `uptime`, `hwid`, `single`, `getCredits`, `addCredits`) VALUES
(4846, '2013-07-13 04:33:18', '192.168.0.101', 'fe80::be5f:f4ff:fe62:b20d/64', 'bc:5f:f4:62:b2:0d  ', 28257, '6', 0, 56550, 0),
(4641, '2013-07-13 04:30:06', '192.168.0.100', 'fe80::be5f:f4ff:fe62:b21f/64', 'bc:5f:f4:62:b2:1f  ', 28256, '7', 0, 115, 0),
(4868, '2013-07-12 17:40:03', '', 'fe80::222:4dff:fe7f:2dc3/64', '§o de HW 00:22:4d:7f', 118086, '', 0, 1113, 0),
(4843, '2013-07-12 06:16:19', '192.168.0.105', 'fe80::be5f:f4ff:fe61:b9e7/64', 'bc:5f:f4:61:b9:e7  ', 29696, '2', 0, 3707, 0),
(4637, '2013-07-13 04:39:14', '192.168.0.104', 'fe80::be5f:f4ff:fe62:b203/64', 'bc:5f:f4:62:b2:03  ', 28248, '3', 0, 5171, 0),
(4645, '2013-07-13 04:35:55', '192.168.0.103', 'fe80::be5f:f4ff:fe62:b20b/64', 'bc:5f:f4:62:b2:0b  ', 28248, '9', 0, 3947, 0),
(4845, '2013-07-13 04:36:47', '192.168.0.102', 'fe80::be5f:f4ff:fe62:b1f5/64', 'bc:5f:f4:62:b1:f5  ', 28263, '5', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reConfig`
--

CREATE TABLE IF NOT EXISTS `reConfig` (
  `id` int(10) unsigned NOT NULL,
  `currencyName` varchar(5) NOT NULL,
  `denomination` int(4) NOT NULL,
  `percentage` bigint(10) NOT NULL,
  `machineType` tinyint(1) NOT NULL,
  `acumuladoMin` bigint(10) NOT NULL,
  `acumuladoMax` bigint(10) NOT NULL,
  `currentAcu` bigint(10) NOT NULL,
  `jackpotValue` bigint(10) NOT NULL,
  `limDouble` bigint(10) NOT NULL,
  `db` tinyint(1) NOT NULL,
  `fam` tinyint(1) NOT NULL,
  `fav` bigint(10) NOT NULL,
  `payoutLim` bigint(10) NOT NULL,
  `billValid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Statistic`
--

CREATE TABLE IF NOT EXISTS `Statistic` (
  `id` int(10) unsigned NOT NULL,
  `moneyIn` bigint(20) unsigned NOT NULL,
  `moneyOut` bigint(20) unsigned NOT NULL,
  `vPlayed` bigint(20) unsigned NOT NULL,
  `vWon` bigint(20) unsigned NOT NULL,
  `vdPlayed` bigint(20) unsigned NOT NULL,
  `vdWon` bigint(20) unsigned NOT NULL,
  `gPlayed` bigint(20) unsigned NOT NULL,
  `gWon` bigint(20) unsigned NOT NULL,
  `dPlayed` bigint(20) unsigned NOT NULL,
  `dWon` bigint(20) unsigned NOT NULL,
  `jPaid` bigint(20) unsigned NOT NULL,
  `aPaid` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `Statistic`
--

INSERT INTO `Statistic` (`id`, `moneyIn`, `moneyOut`, `vPlayed`, `vWon`, `vdPlayed`, `vdWon`, `gPlayed`, `gWon`, `dPlayed`, `dWon`, `jPaid`, `aPaid`) VALUES
(4868, 781301, 761550, 35409, 17241, 100, 72, 908, 366, 4, 2, 0, 0),
(4641, 85400, 81669, 174505, 170929, 18462, 32716, 3708, 1574, 13, 7, 0, 0),
(4846, 92300, 34416, 117550, 116256, 730, 444, 2433, 1053, 4, 3, 0, 0),
(4845, 19500, 14159, 83100, 77759, 1150, 900, 1566, 654, 3, 1, 0, 0),
(4645, 23800, 12801, 77700, 70688, 1408, 0, 1871, 803, 3, 0, 0, 0),
(4637, 16700, 3230, 58520, 50261, 1572, 3144, 1429, 628, 3, 3, 0, 0),
(4843, 24900, 3246, 47860, 29953, 0, 0, 1043, 444, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
