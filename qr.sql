-- --------------------------------------------------------
-- Host:                         localhost
-- Server versie:                5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Databasestructuur van qr wordt geschreven
CREATE DATABASE IF NOT EXISTS `qr` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `qr`;

-- Structuur van  tabel qr.instructions wordt geschreven
CREATE TABLE IF NOT EXISTS `instructions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` blob,
  `title` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel qr.instructions_data wordt geschreven
CREATE TABLE IF NOT EXISTS `instructions_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instruction_id` int(11) NOT NULL,
  `instruction_order` int(11) NOT NULL,
  `type` enum('text','image','video','') NOT NULL,
  `content` mediumblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instruction_id` (`instruction_id`),
  CONSTRAINT `instructions_data_ibfk_1` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel qr.instructions_users wordt geschreven
CREATE TABLE IF NOT EXISTS `instructions_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `instruction_id` int(11) NOT NULL,
  `rank` enum('user','admin','superadmin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `instruction_id` (`instruction_id`),
  CONSTRAINT `instructions_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `instructions_users_ibfk_2` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd

-- Structuur van  tabel qr.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `image` blob,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` enum('user','admin','superadmin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
