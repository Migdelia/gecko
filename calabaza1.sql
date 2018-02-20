/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : calabaza

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-02-20 17:00:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for acesso
-- ----------------------------
DROP TABLE IF EXISTS `acesso`;
CREATE TABLE `acesso` (
  `id_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `acesso` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`id_acesso`),
  UNIQUE KEY `id` (`id_acesso`),
  UNIQUE KEY `id_nivel_2` (`id_nivel`,`id_menu`) USING BTREE,
  KEY `id_nivel` (`id_nivel`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `acesso_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`) ON UPDATE NO ACTION,
  CONSTRAINT `acesso_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='InnoDB free: 168960 kB; (`id_nivel`) REFER `sogespnew/nivel`';

-- ----------------------------
-- Table structure for acesso_local
-- ----------------------------
DROP TABLE IF EXISTS `acesso_local`;
CREATE TABLE `acesso_local` (
  `id_acesso_local` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) DEFAULT NULL,
  `id_local` int(11) DEFAULT NULL,
  `acesso` varchar(1) DEFAULT 'S',
  PRIMARY KEY (`id_acesso_local`),
  UNIQUE KEY `id_acesso_local` (`id_acesso_local`),
  UNIQUE KEY `id_nivel` (`id_nivel`,`id_local`) USING BTREE,
  KEY `id_local` (`id_local`),
  KEY `acesso_local_ibfk_1` (`id_nivel`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for acesso_novo
-- ----------------------------
DROP TABLE IF EXISTS `acesso_novo`;
CREATE TABLE `acesso_novo` (
  `id_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `acesso` varchar(1) NOT NULL DEFAULT 'S',
  `id_login` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_acesso`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for acesso_sub
-- ----------------------------
DROP TABLE IF EXISTS `acesso_sub`;
CREATE TABLE `acesso_sub` (
  `id_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `acesso` varchar(1) NOT NULL DEFAULT 'S',
  `id_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_acesso`)
) ENGINE=InnoDB AUTO_INCREMENT=504 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for base64_data
-- ----------------------------
DROP TABLE IF EXISTS `base64_data`;
CREATE TABLE `base64_data` (
  `c` char(1) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `val` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for bilheteiros
-- ----------------------------
DROP TABLE IF EXISTS `bilheteiros`;
CREATE TABLE `bilheteiros` (
  `id_bilheteiro` int(5) NOT NULL AUTO_INCREMENT,
  `serie` int(5) NOT NULL,
  `modelo_id` int(5) NOT NULL,
  `id_maquina` int(5) NOT NULL,
  PRIMARY KEY (`id_bilheteiro`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for chapas
-- ----------------------------
DROP TABLE IF EXISTS `chapas`;
CREATE TABLE `chapas` (
  `id_chapa` int(5) NOT NULL AUTO_INCREMENT,
  `id_modelo` int(5) NOT NULL,
  `id_maquina` int(5) NOT NULL,
  PRIMARY KEY (`id_chapa`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for desconto_leit_fecha
-- ----------------------------
DROP TABLE IF EXISTS `desconto_leit_fecha`;
CREATE TABLE `desconto_leit_fecha` (
  `id_desconto` int(5) NOT NULL AUTO_INCREMENT,
  `id_descricao` int(5) DEFAULT NULL,
  `id_leitura_fechamento` int(5) DEFAULT NULL,
  `valor_desconto` double(30,0) DEFAULT NULL,
  `leitura` int(2) DEFAULT '0',
  `fechamento` int(2) DEFAULT '0',
  `data_desconto` date NOT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `tipo_doc` varchar(10) DEFAULT NULL,
  `num_doc` int(30) DEFAULT NULL,
  `id_maquina` int(5) NOT NULL DEFAULT '0',
  `id_login` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_desconto`)
) ENGINE=InnoDB AUTO_INCREMENT=45206 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for detalhe_pago
-- ----------------------------
DROP TABLE IF EXISTS `detalhe_pago`;
CREATE TABLE `detalhe_pago` (
  `id_det_pago_fechamento` int(10) NOT NULL AUTO_INCREMENT,
  `id_fechamento` int(10) NOT NULL,
  `valor_pago` double NOT NULL,
  `detalhe` varchar(30) COLLATE utf8_bin NOT NULL,
  `tipo_pago` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_det_pago_fechamento`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for deve
-- ----------------------------
DROP TABLE IF EXISTS `deve`;
CREATE TABLE `deve` (
  `id_deve` int(5) NOT NULL AUTO_INCREMENT,
  `id_local` int(5) NOT NULL,
  `valor` double NOT NULL,
  `saldo` double NOT NULL,
  `id_leitura` int(5) NOT NULL,
  `valor_recebido` double NOT NULL,
  PRIMARY KEY (`id_deve`)
) ENGINE=InnoDB AUTO_INCREMENT=21530 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for exitrequest
-- ----------------------------
DROP TABLE IF EXISTS `exitrequest`;
CREATE TABLE `exitrequest` (
  `machineId` int(10) NOT NULL,
  `idRequest` int(10) NOT NULL,
  `pass1` varchar(50) COLLATE utf8_bin NOT NULL,
  `pass2` varchar(50) COLLATE utf8_bin NOT NULL,
  `in` int(15) NOT NULL,
  `out` int(15) NOT NULL,
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `user` varchar(40) COLLATE utf8_bin NOT NULL,
  `dateOfValidation` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRequest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for favoritos
-- ----------------------------
DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE `favoritos` (
  `id_favorito` int(11) NOT NULL AUTO_INCREMENT,
  `id_relatorio` int(11) DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_favorito`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for fechamento
-- ----------------------------
DROP TABLE IF EXISTS `fechamento`;
CREATE TABLE `fechamento` (
  `id_fechamento` int(11) NOT NULL AUTO_INCREMENT,
  `data_fechamento` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `id_login` int(11) NOT NULL,
  `qtd_maq_operador` int(5) NOT NULL,
  PRIMARY KEY (`id_fechamento`),
  KEY `id_login` (`id_login`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3805 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for historico_edicion_lectura
-- ----------------------------
DROP TABLE IF EXISTS `historico_edicion_lectura`;
CREATE TABLE `historico_edicion_lectura` (
  `id_historico` int(5) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_login` int(3) NOT NULL,
  `subtotal_ant` varchar(500) NOT NULL,
  `subtotal_nuevo` varchar(500) NOT NULL,
  `tipo_operacion` varchar(150) NOT NULL,
  `id_leitura_ant` int(3) NOT NULL,
  `id_leitura_nuevo` int(3) NOT NULL,
  PRIMARY KEY (`id_historico`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for historico_troca_inter
-- ----------------------------
DROP TABLE IF EXISTS `historico_troca_inter`;
CREATE TABLE `historico_troca_inter` (
  `id_troca` int(10) NOT NULL AUTO_INCREMENT,
  `id_interface_ant` int(10) DEFAULT NULL,
  `id_interface_nova` int(10) DEFAULT NULL,
  `entrada_ant` double DEFAULT NULL,
  `saida_ant` double DEFAULT NULL,
  `entrada_nov` double DEFAULT NULL,
  `saida_nov` double DEFAULT NULL,
  `id_maq` int(10) DEFAULT NULL,
  `id_login` int(10) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `id_ultima_leitura` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_troca`)
) ENGINE=InnoDB AUTO_INCREMENT=9806 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for historico_troca_leitura
-- ----------------------------
DROP TABLE IF EXISTS `historico_troca_leitura`;
CREATE TABLE `historico_troca_leitura` (
  `id_troca` int(5) NOT NULL AUTO_INCREMENT,
  `id_maquina` int(5) DEFAULT NULL,
  `id_login` int(5) DEFAULT NULL,
  `id_motivo` int(5) DEFAULT NULL,
  `entrada_ant` int(30) DEFAULT NULL,
  `saida_ant` int(30) DEFAULT NULL,
  `entrada_nov` int(30) DEFAULT NULL,
  `saida_nov` int(30) DEFAULT NULL,
  PRIMARY KEY (`id_troca`)
) ENGINE=InnoDB AUTO_INCREMENT=4284 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for integracao
-- ----------------------------
DROP TABLE IF EXISTS `integracao`;
CREATE TABLE `integracao` (
  `id_integracao` int(5) NOT NULL,
  `id_local` int(5) NOT NULL,
  `hostname` varchar(70) NOT NULL,
  PRIMARY KEY (`id_integracao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for interface
-- ----------------------------
DROP TABLE IF EXISTS `interface`;
CREATE TABLE `interface` (
  `id_interface` int(11) NOT NULL AUTO_INCREMENT,
  `data_inclusao` date NOT NULL,
  `numero` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `excluido` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `serie` int(10) NOT NULL,
  PRIMARY KEY (`id_interface`),
  UNIQUE KEY `numero` (`numero`) USING BTREE,
  KEY `id_maquina` (`id_maquina`,`id_jogo`)
) ENGINE=InnoDB AUTO_INCREMENT=5477 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for interface_erico
-- ----------------------------
DROP TABLE IF EXISTS `interface_erico`;
CREATE TABLE `interface_erico` (
  `id_interface` int(11) NOT NULL AUTO_INCREMENT,
  `data_inclusao` date NOT NULL,
  `numero` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `excluido` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `serie` int(10) NOT NULL,
  PRIMARY KEY (`id_interface`),
  UNIQUE KEY `numero` (`numero`) USING BTREE,
  KEY `id_maquina` (`id_maquina`,`id_jogo`)
) ENGINE=InnoDB AUTO_INCREMENT=3410 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for jogo
-- ----------------------------
DROP TABLE IF EXISTS `jogo`;
CREATE TABLE `jogo` (
  `id_jogo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `porcentagem` double NOT NULL,
  PRIMARY KEY (`id_jogo`),
  UNIQUE KEY `codigo` (`codigo`) USING BTREE,
  UNIQUE KEY `nome` (`nome`,`codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for leitura
-- ----------------------------
DROP TABLE IF EXISTS `leitura`;
CREATE TABLE `leitura` (
  `id_leitura` int(11) NOT NULL AUTO_INCREMENT,
  `id_local` int(11) NOT NULL,
  `id_fechamento` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `semana` int(5) NOT NULL,
  `data` date NOT NULL,
  `desconto` double(20,0) NOT NULL,
  `total_desconto` double(20,0) NOT NULL,
  `total_diferenca` double(20,0) NOT NULL,
  `fechada` varchar(1) NOT NULL COMMENT 'Flag para saber se a leitura ja foi fechada',
  `deve` double(20,0) NOT NULL,
  `observacao` varchar(100) NOT NULL,
  `data_fechamento` date NOT NULL,
  `fat_bruto` int(30) NOT NULL,
  `id_operador` int(5) NOT NULL,
  `id_gerente` int(5) NOT NULL,
  `pct_local` int(3) NOT NULL,
  `id_tipo_local` int(2) NOT NULL,
  `pct_operador` int(3) NOT NULL,
  `pct_gerente` int(3) NOT NULL,
  `id_admin` int(5) NOT NULL,
  PRIMARY KEY (`id_leitura`),
  KEY `id_local` (`id_local`) USING BTREE,
  KEY `id_local_2` (`id_local`,`id_login`) USING BTREE,
  KEY `id_login` (`id_login`),
  KEY `id_fechamento` (`id_fechamento`)
) ENGINE=InnoDB AUTO_INCREMENT=21573 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for leitura_por_maquina
-- ----------------------------
DROP TABLE IF EXISTS `leitura_por_maquina`;
CREATE TABLE `leitura_por_maquina` (
  `id_leit_maq` int(5) NOT NULL AUTO_INCREMENT,
  `id_leitura` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `valor_entrada` double(10,0) NOT NULL,
  `entrada_oficial_atual` double(10,0) NOT NULL,
  `valor_saida` double(10,0) NOT NULL,
  `saida_oficial_atual` double(10,0) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `id_local` int(5) NOT NULL,
  `id_gabinete` int(5) NOT NULL,
  `num_disp` int(10) NOT NULL,
  `pct_esp_maq` int(3) NOT NULL,
  `ordem_leitura` int(3) NOT NULL,
  `pct_maq_socio` int(3) NOT NULL,
  `maq_socio` float(1,0) NOT NULL,
  `maq_parceiro` float(1,0) NOT NULL,
  `id_jogo` int(3) NOT NULL,
  PRIMARY KEY (`id_leit_maq`),
  KEY `id_maquina` (`id_maquina`) USING BTREE,
  KEY `id_leitura` (`id_leitura`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=490453 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for locais_integrados
-- ----------------------------
DROP TABLE IF EXISTS `locais_integrados`;
CREATE TABLE `locais_integrados` (
  `id_local_integrado` int(5) NOT NULL AUTO_INCREMENT,
  `id_local` int(5) NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  `caixas abertos` int(3) NOT NULL,
  `uptime` bigint(10) NOT NULL,
  `dns` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_local_integrado`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for local
-- ----------------------------
DROP TABLE IF EXISTS `local`;
CREATE TABLE `local` (
  `id_local` int(11) NOT NULL AUTO_INCREMENT,
  `rut` varchar(12) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `razao_social` varchar(80) NOT NULL,
  `inclusao` date NOT NULL,
  `ordem` int(3) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  `endereco` varchar(50) NOT NULL,
  `responsavel` varchar(50) NOT NULL,
  `contato` varchar(50) NOT NULL,
  `id_login` int(11) NOT NULL,
  `percentual` int(2) NOT NULL DEFAULT '6',
  `id_regiao` int(10) NOT NULL,
  `id_tp_local` int(11) NOT NULL DEFAULT '1',
  `id_gerente` int(5) NOT NULL,
  `pct_operador` float NOT NULL,
  `pct_gerente` float NOT NULL,
  `id_admin` int(5) NOT NULL,
  PRIMARY KEY (`id_local`),
  KEY `id_login` (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for logins
-- ----------------------------
DROP TABLE IF EXISTS `logins`;
CREATE TABLE `logins` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `senha_velha` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `inclusao` date NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  `percentual` int(2) NOT NULL DEFAULT '6',
  `senha` varchar(50) NOT NULL,
  PRIMARY KEY (`id_login`),
  UNIQUE KEY `id` (`id_login`),
  UNIQUE KEY `email` (`email`,`excluido`,`id_login`),
  KEY `id_nivel` (`id_nivel`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for log_acesso
-- ----------------------------
DROP TABLE IF EXISTS `log_acesso`;
CREATE TABLE `log_acesso` (
  `id_log_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log_acesso`)
) ENGINE=InnoDB AUTO_INCREMENT=105972 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for maquinas
-- ----------------------------
DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE `maquinas` (
  `id_maquina` int(11) NOT NULL AUTO_INCREMENT,
  `data_inclusao` date NOT NULL,
  `data_alteracao` date DEFAULT NULL,
  `numero` int(5) NOT NULL,
  `id_local` int(11) NOT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  `id_tipo_maquina` int(11) NOT NULL,
  `id_interface` int(11) NOT NULL,
  `porc_maquina` int(5) NOT NULL,
  `ordem_leitura` int(3) NOT NULL DEFAULT '1',
  `porc_socio` varchar(5) NOT NULL,
  `maq_socio` varchar(5) NOT NULL,
  `parceiro` int(5) NOT NULL,
  `entrada_oficial` int(30) NOT NULL,
  `saida_oficial` int(30) NOT NULL,
  `id_ultima_leitura` int(10) NOT NULL,
  PRIMARY KEY (`id_maquina`),
  UNIQUE KEY `id_maquina` (`id_maquina`),
  KEY `id_local` (`id_local`),
  KEY `id_tipo_maquina` (`id_tipo_maquina`)
) ENGINE=InnoDB AUTO_INCREMENT=2404 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icone` varchar(50) NOT NULL,
  `ordem` int(3) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menu_itens
-- ----------------------------
DROP TABLE IF EXISTS `menu_itens`;
CREATE TABLE `menu_itens` (
  `id_item_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `link` varchar(50) NOT NULL,
  `ordem` int(3) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_item_menu`),
  UNIQUE KEY `id_item_menu` (`id_item_menu`),
  KEY `id_menu` (`id_menu`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menu_itens_novo
-- ----------------------------
DROP TABLE IF EXISTS `menu_itens_novo`;
CREATE TABLE `menu_itens_novo` (
  `id_item_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `link` varchar(30) NOT NULL,
  `ordem` int(3) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  `icone` varchar(30) NOT NULL,
  `principal` float(1,0) NOT NULL,
  PRIMARY KEY (`id_item_menu`),
  UNIQUE KEY `id_item_menu` (`id_item_menu`),
  KEY `id_menu` (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menu_novo
-- ----------------------------
DROP TABLE IF EXISTS `menu_novo`;
CREATE TABLE `menu_novo` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `link` varchar(50) NOT NULL,
  `ordem` int(3) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  `nome_sistema` varchar(20) NOT NULL,
  `class` varchar(20) NOT NULL,
  `icone` varchar(20) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelos_bilheteiro
-- ----------------------------
DROP TABLE IF EXISTS `modelos_bilheteiro`;
CREATE TABLE `modelos_bilheteiro` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelos_chapa
-- ----------------------------
DROP TABLE IF EXISTS `modelos_chapa`;
CREATE TABLE `modelos_chapa` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `descricao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelos_monitor
-- ----------------------------
DROP TABLE IF EXISTS `modelos_monitor`;
CREATE TABLE `modelos_monitor` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelos_pendrive
-- ----------------------------
DROP TABLE IF EXISTS `modelos_pendrive`;
CREATE TABLE `modelos_pendrive` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `marca` varchar(20) NOT NULL,
  `descricao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelos_placa_mae
-- ----------------------------
DROP TABLE IF EXISTS `modelos_placa_mae`;
CREATE TABLE `modelos_placa_mae` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for monitores
-- ----------------------------
DROP TABLE IF EXISTS `monitores`;
CREATE TABLE `monitores` (
  `id_monitor` int(5) NOT NULL AUTO_INCREMENT,
  `id_maquina` int(5) NOT NULL,
  `id_modelo` int(5) NOT NULL,
  `serie` int(10) NOT NULL,
  PRIMARY KEY (`id_monitor`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for motivo_troca
-- ----------------------------
DROP TABLE IF EXISTS `motivo_troca`;
CREATE TABLE `motivo_troca` (
  `id_motivo` int(5) NOT NULL AUTO_INCREMENT,
  `motivo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_motivo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for nivel
-- ----------------------------
DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel` (
  `id_nivel` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(80) NOT NULL,
  `inclusao` date NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_nivel`),
  UNIQUE KEY `id` (`id_nivel`),
  UNIQUE KEY `id_2` (`id_nivel`,`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pago_fechamento
-- ----------------------------
DROP TABLE IF EXISTS `pago_fechamento`;
CREATE TABLE `pago_fechamento` (
  `id_pago` int(10) NOT NULL AUTO_INCREMENT,
  `id_fechamento` int(10) DEFAULT NULL,
  `valor_din` double DEFAULT NULL,
  `valor_dep` double DEFAULT NULL,
  `valor_cheq` double DEFAULT NULL,
  `din_1` double DEFAULT NULL,
  `din_2` double DEFAULT NULL,
  `din_3` double DEFAULT NULL,
  `din_4` double DEFAULT NULL,
  `din_5` double DEFAULT NULL,
  `dep_1` double DEFAULT NULL,
  `dep_2` double DEFAULT NULL,
  `dep_3` double DEFAULT NULL,
  `dep_4` double DEFAULT NULL,
  `dep_5` double DEFAULT NULL,
  `cheq_1` double DEFAULT NULL,
  `cheq_2` double DEFAULT NULL,
  `cheq_3` double DEFAULT NULL,
  `cheq_4` double DEFAULT NULL,
  `cheq_5` double DEFAULT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=869 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for pendrives
-- ----------------------------
DROP TABLE IF EXISTS `pendrives`;
CREATE TABLE `pendrives` (
  `id_pendrive` int(5) NOT NULL AUTO_INCREMENT,
  `serie` int(5) NOT NULL,
  `modelo_id` int(5) NOT NULL,
  `id_maquina` int(5) NOT NULL,
  PRIMARY KEY (`id_pendrive`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for placa_mae
-- ----------------------------
DROP TABLE IF EXISTS `placa_mae`;
CREATE TABLE `placa_mae` (
  `id_placa` int(5) NOT NULL AUTO_INCREMENT,
  `serie` int(5) NOT NULL,
  `modelo_id` int(5) NOT NULL,
  `id_maquina` int(5) NOT NULL,
  PRIMARY KEY (`id_placa`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for regiao
-- ----------------------------
DROP TABLE IF EXISTS `regiao`;
CREATE TABLE `regiao` (
  `id_cidade` int(5) NOT NULL AUTO_INCREMENT,
  `nome_cidade` varchar(30) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_cidade`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for relatorios
-- ----------------------------
DROP TABLE IF EXISTS `relatorios`;
CREATE TABLE `relatorios` (
  `id_relatorio` int(11) NOT NULL AUTO_INCREMENT,
  `id_login` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `area` varchar(100) NOT NULL,
  `tabela` varchar(100) DEFAULT NULL,
  `campos` longtext,
  `criterios` longtext,
  `ordenacao` longtext,
  `query` longtext,
  `ordem` int(3) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `excluido` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_relatorio`),
  KEY `id_login` (`id_login`),
  KEY `area` (`area`) USING BTREE,
  KEY `tipo` (`tipo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for request
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key1` varchar(50) COLLATE utf8_bin NOT NULL,
  `key2` varchar(50) COLLATE utf8_bin NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `error` tinyint(1) NOT NULL,
  `codeVer` int(6) NOT NULL,
  `userName` varchar(30) COLLATE utf8_bin NOT NULL,
  `userId` int(10) NOT NULL,
  `flagNivel` float(2,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13395 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for storico_e_lectura
-- ----------------------------
DROP TABLE IF EXISTS `storico_e_lectura`;
CREATE TABLE `storico_e_lectura` (
  `id_historico` int(5) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_login` int(3) NOT NULL,
  `subtotal_ant` varchar(500) NOT NULL,
  `subtotal_nuevo` varchar(500) NOT NULL,
  `tipo_operacion` varchar(150) NOT NULL,
  `id_leitura_ant` int(3) NOT NULL,
  `id_leitura_nuevo` int(3) NOT NULL,
  PRIMARY KEY (`id_historico`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tipo_desconto
-- ----------------------------
DROP TABLE IF EXISTS `tipo_desconto`;
CREATE TABLE `tipo_desconto` (
  `id_desconto` int(5) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_desconto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_local
-- ----------------------------
DROP TABLE IF EXISTS `tipo_local`;
CREATE TABLE `tipo_local` (
  `id_tp_local` int(5) NOT NULL AUTO_INCREMENT,
  `tp_local` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_tp_local`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for tipo_maquina
-- ----------------------------
DROP TABLE IF EXISTS `tipo_maquina`;
CREATE TABLE `tipo_maquina` (
  `id_tipo_maquina` int(5) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_maquina`),
  UNIQUE KEY `codigo` (`codigo`) USING BTREE,
  UNIQUE KEY `descricao` (`descricao`,`codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for vervalidacion
-- ----------------------------
DROP TABLE IF EXISTS `vervalidacion`;
CREATE TABLE `vervalidacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- View structure for vw_acessos_usuarios
-- ----------------------------
DROP VIEW IF EXISTS `vw_acessos_usuarios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_acessos_usuarios` AS select `logins`.`nome` AS `Nome`,`logins`.`usuario` AS `Usuario`,`menu`.`id_menu` AS `id_menu`,`menu`.`nome` AS `Menu`,`menu`.`link` AS `Pagina`,`nivel`.`descricao` AS `descricao`,`logins`.`id_nivel` AS `id_nivel`,`acesso`.`acesso` AS `acesso` from (((`acesso` join `logins` on(((`logins`.`id_nivel` = `acesso`.`id_nivel`) and (`logins`.`excluido` = 'N')))) join `menu` on(((`acesso`.`id_menu` = `menu`.`id_menu`) and (`menu`.`excluido` = 'N')))) join `nivel` on(((`nivel`.`id_nivel` = `acesso`.`id_nivel`) and (`nivel`.`excluido` = 'N')))) where (`acesso`.`acesso` = 'S') order by `logins`.`id_login` ;

-- ----------------------------
-- View structure for vw_favoritos
-- ----------------------------
DROP VIEW IF EXISTS `vw_favoritos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_favoritos` AS select `relatorios`.`id_relatorio` AS `id_relatorio`,`relatorios`.`id_login` AS `id_login`,`relatorios`.`nome` AS `nome`,`relatorios`.`area` AS `area`,`relatorios`.`tabela` AS `tabela`,`relatorios`.`campos` AS `campos`,`relatorios`.`criterios` AS `criterios`,`relatorios`.`ordenacao` AS `ordenacao`,`relatorios`.`query` AS `query`,`relatorios`.`ordem` AS `ordem`,`relatorios`.`tipo` AS `tipo`,`logins`.`usuario` AS `favorito` from ((`relatorios` join `favoritos` on((`favoritos`.`id_relatorio` = `relatorios`.`id_relatorio`))) join `logins` on(((`logins`.`id_login` = `favoritos`.`id_login`) and (`logins`.`excluido` = _latin1'N')))) where (`relatorios`.`excluido` = _latin1'N') union select `relatorios`.`id_relatorio` AS `id_relatorio`,`relatorios`.`id_login` AS `id_login`,`relatorios`.`nome` AS `nome`,`relatorios`.`area` AS `area1`,`relatorios`.`tabela` AS `tabela`,`relatorios`.`campos` AS `campos`,`relatorios`.`criterios` AS `criterios`,`relatorios`.`ordenacao` AS `ordenacao`,`relatorios`.`query` AS `query`,`relatorios`.`ordem` AS `ordem`,`relatorios`.`tipo` AS `tipo`,NULL AS `favorito` from `relatorios` where (`relatorios`.`excluido` = _latin1'N') ;

-- ----------------------------
-- View structure for vw_fechamento
-- ----------------------------
DROP VIEW IF EXISTS `vw_fechamento`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_fechamento` AS select `fechamento`.`id_fechamento` AS `id_fechamento`,`fechamento`.`data_fechamento` AS `data_fechamento`,`logins`.`usuario` AS `usuario`,sum(`leitura`.`desconto`) AS `desconto`,sum(`vw_leitura_maquina`.`valor_entrada_total`) AS `valor_entrada_total`,sum(`vw_leitura_maquina`.`valor_saida_total`) AS `valor_saida_total`,(sum(`vw_leitura_maquina`.`valor_entrada_total`) - sum(`vw_leitura_maquina`.`valor_saida_total`)) AS `valor_faturamento_total` from (((`fechamento` left join `leitura` on((`leitura`.`id_fechamento` = `fechamento`.`id_fechamento`))) left join `logins` on((`fechamento`.`id_login` = `logins`.`id_login`))) left join `vw_leitura_maquina` on((`vw_leitura_maquina`.`id_leitura` = `leitura`.`id_leitura`))) group by `fechamento`.`id_fechamento` ;

-- ----------------------------
-- View structure for vw_fechamento_maquina
-- ----------------------------
DROP VIEW IF EXISTS `vw_fechamento_maquina`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_fechamento_maquina` AS select `fechamento`.`data_fechamento` AS `data_fechamento`,`fechamento`.`id_login` AS `id_login`,`logins`.`usuario` AS `usuario`,`local`.`nome` AS `local`,`vw_maquinas`.`codigo` AS `codigo`,`vw_maquinas`.`nome` AS `nome`,`vw_maquinas`.`numero` AS `numero`,`leitura_por_maquina`.`data_cadastro` AS `data_cadastro`,`leitura`.`id_leitura` AS `id_leitura`,`leitura`.`fechada` AS `fechada`,`leitura`.`desconto` AS `desconto`,`leitura_por_maquina`.`valor_entrada` AS `valor_entrada`,`leitura_por_maquina`.`valor_saida` AS `valor_saida`,`leitura_por_maquina`.`id_leit_maq` AS `id_leit_maq`,`vw_leitura_maquina`.`valor_entrada_total` AS `valor_entrada_total`,`vw_leitura_maquina`.`valor_saida_total` AS `valor_saida_total`,`fechamento`.`id_fechamento` AS `id_fechamento`,`vw_fechamento`.`valor_entrada_total` AS `valor_entrada_total_fechado`,`vw_fechamento`.`valor_saida_total` AS `valor_saida_total_fechado`,`vw_fechamento`.`valor_faturamento_total` AS `valor_faturamento_total_fechado`,`leitura_por_maquina`.`id_maquina` AS `id_maquina` from (((((((`fechamento` left join `leitura` on((`leitura`.`id_fechamento` = `fechamento`.`id_fechamento`))) left join `leitura_por_maquina` on((`leitura_por_maquina`.`id_leitura` = `leitura`.`id_leitura`))) left join `logins` on((`fechamento`.`id_login` = `logins`.`id_login`))) join `local` on((`local`.`id_local` = `leitura`.`id_local`))) left join `vw_maquinas` on((`vw_maquinas`.`id_maquina` = `leitura_por_maquina`.`id_maquina`))) left join `vw_leitura_maquina` on((`vw_leitura_maquina`.`id_leitura` = `leitura`.`id_leitura`))) join `vw_fechamento` on((`vw_fechamento`.`id_fechamento` = `fechamento`.`id_fechamento`))) group by `leitura_por_maquina`.`id_leit_maq` ;

-- ----------------------------
-- View structure for vw_interface
-- ----------------------------
DROP VIEW IF EXISTS `vw_interface`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_interface` AS select `interface`.`numero` AS `numero`,`tipo_maquina`.`descricao` AS `descricao`,`tipo_maquina`.`codigo` AS `cod_tipo`,`jogo`.`nome` AS `nome`,`jogo`.`codigo` AS `cod_jogo`,`vw_maquinas`.`codigo` AS `cod_maquina`,`vw_maquinas`.`nome` AS `maquina`,`local`.`nome` AS `local`,`interface`.`id_maquina` AS `id_maquina`,`interface`.`id_jogo` AS `id_jogo`,`interface`.`id_interface` AS `id_interface`,`interface`.`excluido` AS `excluido` from ((((`interface` left join `jogo` on((`interface`.`id_jogo` = `jogo`.`id_jogo`))) left join `vw_maquinas` on((`interface`.`id_maquina` = `vw_maquinas`.`id_maquina`))) left join `tipo_maquina` on((`tipo_maquina`.`id_tipo_maquina` = `vw_maquinas`.`id_tipo_maquina`))) left join `local` on((`local`.`id_local` = `vw_maquinas`.`id_local`))) ;

-- ----------------------------
-- View structure for vw_leitura
-- ----------------------------
DROP VIEW IF EXISTS `vw_leitura`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_leitura` AS select `leitura`.`data` AS `data`,`leitura`.`id_local` AS `id_local`,`leitura`.`fechada` AS `fechada`,`leitura`.`id_leitura` AS `id_leitura`,`leitura_por_maquina`.`id_leit_maq` AS `id_leit_maq`,`leitura_por_maquina`.`valor_entrada` AS `valor_entrada`,`leitura_por_maquina`.`valor_saida` AS `valor_saida`,(select sum(`lpm`.`valor_entrada`) from `leitura_por_maquina` `lpm` where (`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`) group by `lpm`.`id_leitura`) AS `valor_entrada_total`,(select sum(`lpm`.`valor_saida`) from `leitura_por_maquina` `lpm` where (`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`) group by `lpm`.`id_leitura`) AS `valor_saida_total`,(select (sum(`lpm`.`valor_entrada`) - sum(`lpm`.`valor_saida`)) from `leitura_por_maquina` `lpm` where (`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`) group by `lpm`.`id_leitura`) AS `faturamento_bruto`,(select (sum(`lpm`.`valor_entrada`) - sum(`lpm`.`valor_saida`)) from (`leitura_por_maquina` `lpm` join `maquinas` on((`lpm`.`id_maquina` = `maquinas`.`id_maquina`))) where ((`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`) and (`maquinas`.`porc_maquina` <> 0)) group by `lpm`.`id_leitura`) AS `faturamento_especial`,(select (sum(`lpm`.`valor_entrada`) - sum(`lpm`.`valor_saida`)) from (`leitura_por_maquina` `lpm` join `maquinas` on((`lpm`.`id_maquina` = `maquinas`.`id_maquina`))) where ((`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`) and (`maquinas`.`porc_socio` <> 0)) group by `lpm`.`id_leitura`) AS `faturamento_socio`,`vw_maquinas`.`codigo` AS `codigo`,`vw_maquinas`.`numero` AS `numero`,`local`.`nome` AS `nome`,`logins`.`usuario` AS `usuario`,`jogo`.`nome` AS `jogo`,`tipo_maquina`.`descricao` AS `descricao`,`vw_maquinas`.`porc_maquina` AS `porc_maquina`,`local`.`percentual` AS `percentual`,`leitura`.`id_fechamento` AS `id_fechamento`,`deve`.`valor` AS `deve`,`deve`.`valor_recebido` AS `valor_recebido`,`local`.`id_regiao` AS `id_regiao`,`logins`.`id_login` AS `operador`,`local`.`id_tp_local` AS `id_tp_local`,`leitura`.`total_desconto` AS `desconto`,`leitura`.`total_diferenca` AS `diferenca`,`local`.`id_login` AS `id_login`,`leitura`.`semana` AS `semana`,`leitura`.`data_fechamento` AS `data_fechamento` from (((((((`leitura` join `leitura_por_maquina` on((`leitura_por_maquina`.`id_leitura` = `leitura`.`id_leitura`))) join `vw_maquinas` on((`vw_maquinas`.`id_maquina` = `leitura_por_maquina`.`id_maquina`))) join `local` on((`vw_maquinas`.`id_local` = `local`.`id_local`))) join `logins` on((`leitura`.`id_login` = `logins`.`id_login`))) join `jogo` on((`vw_maquinas`.`id_jogo` = `jogo`.`id_jogo`))) join `tipo_maquina` on((`vw_maquinas`.`id_tipo_maquina` = `tipo_maquina`.`id_tipo_maquina`))) join `deve` on((`leitura`.`id_leitura` = `deve`.`id_leitura`))) where (1 = 1) group by `leitura`.`id_leitura` ;

-- ----------------------------
-- View structure for vw_leitura_info
-- ----------------------------
DROP VIEW IF EXISTS `vw_leitura_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_leitura_info` AS select `leitura`.`data` AS `data`,`leitura`.`id_local` AS `id_local`,`leitura`.`fechada` AS `fechada`,`leitura`.`id_leitura` AS `id_leitura`,`local`.`nome` AS `nome`,`logins`.`usuario` AS `usuario`,`leitura`.`id_fechamento` AS `id_fechamento`,`logins`.`id_login` AS `id_login`,`leitura`.`data_fechamento` AS `data_fechamento`,`leitura`.`semana` AS `semana`,`leitura`.`fat_bruto` AS `fat_bruto`,`local`.`id_admin` AS `id_admin`,`leitura`.`id_operador` AS `id_operador`,`leitura`.`id_gerente` AS `id_gerente` from ((`leitura` join `local` on((`leitura`.`id_local` = `local`.`id_local`))) join `logins` on((`leitura`.`id_login` = `logins`.`id_login`))) where (1 = 1) group by `leitura`.`id_leitura` ;

-- ----------------------------
-- View structure for vw_leitura_maquina
-- ----------------------------
DROP VIEW IF EXISTS `vw_leitura_maquina`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_leitura_maquina` AS select `leitura`.`data` AS `data`,`leitura`.`id_local` AS `id_local`,`leitura`.`desconto` AS `desconto`,`leitura`.`fechada` AS `fechada`,`leitura`.`id_leitura` AS `id_leitura`,`leitura_por_maquina`.`id_leit_maq` AS `id_leit_maq`,`leitura_por_maquina`.`valor_entrada` AS `valor_entrada`,`leitura_por_maquina`.`valor_saida` AS `valor_saida`,(select sum(`lpm`.`valor_entrada`) from (`leitura_por_maquina` `lpm` left join `leitura` `l` on((`lpm`.`id_leitura` = `l`.`id_leitura`))) where (`lpm`.`id_maquina` = `leitura_por_maquina`.`id_maquina`) group by `lpm`.`id_maquina`) AS `valor_entrada_total`,(select sum(`lpm`.`valor_saida`) from (`leitura_por_maquina` `lpm` left join `leitura` `l` on((`lpm`.`id_leitura` = `l`.`id_leitura`))) where (`lpm`.`id_maquina` = `leitura_por_maquina`.`id_maquina`) group by `lpm`.`id_maquina`) AS `valor_saida_total`,`vw_maquinas`.`codigo` AS `codigo`,`vw_maquinas`.`numero` AS `numero`,`local`.`nome` AS `nome`,`logins`.`usuario` AS `usuario`,`jogo`.`nome` AS `jogo`,`tipo_maquina`.`descricao` AS `descricao`,`leitura_por_maquina`.`id_maquina` AS `id_maquina`,`leitura_por_maquina`.`entrada_oficial_atual` AS `entrada_oficial_atual`,`leitura_por_maquina`.`saida_oficial_atual` AS `saida_oficial_atual`,`leitura`.`semana` AS `semana` from ((((((`leitura` join `leitura_por_maquina` on((`leitura_por_maquina`.`id_leitura` = `leitura`.`id_leitura`))) join `vw_maquinas` on((`vw_maquinas`.`id_maquina` = `leitura_por_maquina`.`id_maquina`))) join `local` on((`vw_maquinas`.`id_local` = `local`.`id_local`))) join `logins` on((`leitura`.`id_login` = `logins`.`id_login`))) join `jogo` on((`vw_maquinas`.`id_jogo` = `jogo`.`id_jogo`))) join `tipo_maquina` on((`vw_maquinas`.`id_tipo_maquina` = `tipo_maquina`.`id_tipo_maquina`))) where (1 = 1) order by `leitura`.`data`,`leitura`.`id_leitura` ;

-- ----------------------------
-- View structure for vw_local
-- ----------------------------
DROP VIEW IF EXISTS `vw_local`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_local` AS select `local`.`id_local` AS `id_local`,`local`.`rut` AS `rut`,`local`.`nome` AS `nome`,`local`.`ordem` AS `ordem`,`local`.`excluido` AS `excluido`,`logins`.`nome` AS `operador`,`local`.`id_login` AS `id_login`,`tipo_local`.`tp_local` AS `id_tp_local`,`local`.`id_gerente` AS `id_gerente`,`local`.`pct_operador` AS `pct_operador`,`local`.`pct_gerente` AS `pct_gerente`,`regiao`.`nome_cidade` AS `nome_cidade`,`local`.`razao_social` AS `razao_social`,`local`.`endereco` AS `endereco`,`local`.`responsavel` AS `responsavel`,`local`.`contato` AS `contato`,`local`.`percentual` AS `percentual` from (((`local` join `logins` on((`logins`.`id_login` = `local`.`id_login`))) join `tipo_local` on((`local`.`id_tp_local` = `tipo_local`.`id_tp_local`))) join `regiao` on((`local`.`id_regiao` = `regiao`.`id_cidade`))) where (`local`.`excluido` = 'N') ;

-- ----------------------------
-- View structure for vw_maquinas
-- ----------------------------
DROP VIEW IF EXISTS `vw_maquinas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_maquinas` AS select `maquinas`.`id_maquina` AS `id_maquina`,concat(`tipo_maquina`.`codigo`,ifnull(`jogo`.`codigo`,'-')) AS `codigo`,`maquinas`.`numero` AS `numero`,`maquinas`.`id_local` AS `id_local`,`local`.`nome` AS `nome`,`maquinas`.`excluido` AS `excluido`,`interface`.`id_jogo` AS `id_jogo`,concat(`interface`.`numero`) AS `interface`,`maquinas`.`id_tipo_maquina` AS `id_tipo_maquina`,`maquinas`.`porc_maquina` AS `porc_maquina`,`interface`.`id_interface` AS `id_interface`,`maquinas`.`ordem_leitura` AS `ordem_leitura`,`local`.`id_login` AS `id_login`,`logins`.`nome` AS `operador`,`maquinas`.`porc_socio` AS `porc_socio`,`maquinas`.`maq_socio` AS `maq_socio`,`maquinas`.`parceiro` AS `parceiro`,`maquinas`.`entrada_oficial` AS `entrada_oficial`,`maquinas`.`saida_oficial` AS `saida_oficial`,`jogo`.`nome` AS `jogo`,`maquinas`.`id_ultima_leitura` AS `id_ultima_leitura`,`local`.`id_gerente` AS `id_gerente`,`local`.`id_admin` AS `id_admin`,`tipo_maquina`.`descricao` AS `descricao`,`maquinas`.`obs` AS `obs` from (((((`maquinas` join `local` on((`maquinas`.`id_local` = `local`.`id_local`))) join `tipo_maquina` on((`tipo_maquina`.`id_tipo_maquina` = `maquinas`.`id_tipo_maquina`))) left join `interface` on((`interface`.`id_maquina` = `maquinas`.`id_maquina`))) left join `jogo` on((`jogo`.`id_jogo` = `interface`.`id_jogo`))) join `logins` on((`local`.`id_login` = `logins`.`id_login`))) ;

-- ----------------------------
-- View structure for vw_operador
-- ----------------------------
DROP VIEW IF EXISTS `vw_operador`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_operador` AS select `logins`.`nome` AS `nome`,`logins`.`usuario` AS `usuario`,`logins`.`email` AS `email`,`nivel`.`descricao` AS `descricao`,`logins`.`id_login` AS `id_login`,`logins`.`id_nivel` AS `id_nivel` from (`logins` join `nivel` on((`nivel`.`id_nivel` = `logins`.`id_nivel`))) where ((`logins`.`excluido` = 'N') and (`nivel`.`excluido` = 'N') and (`nivel`.`descricao` like 'Operador%')) ;

-- ----------------------------
-- View structure for vw_regiao
-- ----------------------------
DROP VIEW IF EXISTS `vw_regiao`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_regiao` AS select `regiao`.`excluido` AS `excluido`,`regiao`.`nome_cidade` AS `nome_cidade`,`regiao`.`id_cidade` AS `id_cidade` from `regiao` where (`regiao`.`excluido` = 'N') ;

-- ----------------------------
-- View structure for vw_usuarios
-- ----------------------------
DROP VIEW IF EXISTS `vw_usuarios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuarios` AS select `logins`.`nome` AS `Nome`,`logins`.`usuario` AS `Usuario`,`logins`.`email` AS `Email`,`nivel`.`descricao` AS `Nivel`,`logins`.`inclusao` AS `Inclusao`,`logins`.`id_login` AS `id_login`,`logins`.`excluido` AS `excluido` from (`logins` join `nivel` on((`nivel`.`id_nivel` = `logins`.`id_nivel`))) where ((`logins`.`excluido` = _latin1'N') and (`nivel`.`excluido` = _latin1'N')) ;
