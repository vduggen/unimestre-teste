-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.18-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para unimestre
DROP DATABASE IF EXISTS `unimestre`;
CREATE DATABASE IF NOT EXISTS `unimestre` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `unimestre`;

-- Copiando estrutura para tabela unimestre.clients_address
DROP TABLE IF EXISTS `clients_address`;
CREATE TABLE IF NOT EXISTS `clients_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `neighborhood` varchar(300) DEFAULT NULL,
  `street` varchar(300) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `complement` varchar(300) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela unimestre.clients_experience
DROP TABLE IF EXISTS `clients_experience`;
CREATE TABLE IF NOT EXISTS `clients_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `name` varchar(100) DEFAULT '0',
  `company` varchar(100) DEFAULT NULL,
  `startMonth` char(2) DEFAULT NULL,
  `startYear` char(4) DEFAULT NULL,
  `expire` bit(1) DEFAULT b'1',
  `endMonth` char(2) DEFAULT NULL,
  `endYear` char(4) DEFAULT NULL,
  `user` int(11) DEFAULT 0,
  `description` varchar(500) DEFAULT NULL,
  `active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela unimestre.clients_gender
DROP TABLE IF EXISTS `clients_gender`;
CREATE TABLE IF NOT EXISTS `clients_gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela unimestre.clients_graduation
DROP TABLE IF EXISTS `clients_graduation`;
CREATE TABLE IF NOT EXISTS `clients_graduation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `name` varchar(100) DEFAULT '0',
  `company` varchar(100) DEFAULT NULL,
  `startMonth` char(2) DEFAULT NULL,
  `startYear` char(4) DEFAULT NULL,
  `expire` bit(1) DEFAULT b'1',
  `endMonth` char(2) DEFAULT NULL,
  `endYear` char(4) DEFAULT NULL,
  `user` int(11) DEFAULT 0,
  `active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela unimestre.clients_person
DROP TABLE IF EXISTS `clients_person`;
CREATE TABLE IF NOT EXISTS `clients_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `document` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(320) CHARACTER SET utf8mb4 DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `gender` int(11) DEFAULT 0,
  `address` int(11) DEFAULT 0,
  `active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=518150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Commnet from this moment';

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela unimestre.users_users
DROP TABLE IF EXISTS `users_users`;
CREATE TABLE IF NOT EXISTS `users_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico',
  `document` char(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `person` int(11) DEFAULT 0,
  `active` bit(1) DEFAULT b'1',
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person` (`person`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
