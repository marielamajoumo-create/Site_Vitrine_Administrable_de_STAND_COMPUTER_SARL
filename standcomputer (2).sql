-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2026 at 11:09 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `standcomputer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `passwor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `passwor`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500'),
(2, 'stand', 'stand'),
(3, 'computer', 'computer');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `villeQuartier` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `phone`, `email`, `whatsapp`, `localisation`, `villeQuartier`, `pays`, `created_at`, `updated_at`) VALUES
(1, '+237695830138', 'marielamajoumo@gmail.com', '237695830138', 'Carrefour Manga philippe', 'Yaounde,Ekoumdoum', 'Cameroun', '2026-05-06 08:58:05', '2026-05-09 10:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

DROP TABLE IF EXISTS `formations`;
CREATE TABLE IF NOT EXISTS `formations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `nombrePersonne` varchar(255) NOT NULL,
  `natureDiplome` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formations`
--

INSERT INTO `formations` (`id`, `niveau`, `title`, `intitule`, `description`, `image`, `duration`, `nombrePersonne`, `natureDiplome`, `created_at`) VALUES
(1, '', 'infographie', '', 'ouioui', '69f9475ed36a4_hero1.png', '', '0', '', '2026-04-29 19:35:18'),
(2, 'avance', 'maintenance 1', 'maintenir app 1', 'oui et bien d\'autres 1', '', NULL, '18max', 'certificat1', '2026-04-29 19:36:54'),
(3, '', 'resaux', '', 'ouioui', '', '6 mois', '0', '', '2026-04-29 19:55:28'),
(4, 'debutant', 'maintenance', 'maintenancier', 'blabla', '', '6 mois', '20', 'certificat', '2026-05-04 11:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `horaires`
--

DROP TABLE IF EXISTS `horaires`;
CREATE TABLE IF NOT EXISTS `horaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jour` varchar(255) NOT NULL,
  `ouvertureFermeture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horaires`
--

INSERT INTO `horaires` (`id`, `jour`, `ouvertureFermeture`, `created_at`, `updated_at`) VALUES
(1, 'Lundi - Vendredi', '8h30-16h00', '2026-05-06 09:11:49', '2026-05-06 09:26:48'),
(2, 'Samedi', '9h00-12h30', '2026-05-06 09:12:25', '2026-05-06 09:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serviceC` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageR` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('non-lu','lu','repondu') COLLATE utf8mb4_unicode_ci DEFAULT 'non-lu',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_date` (`date_creation`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `telephone`, `serviceC`, `sujet`, `messageR`, `date_creation`, `statut`) VALUES
(1, '', '', '', '', '', '', '2026-05-08 15:50:07', 'repondu'),
(2, 'ghj', 'moi@gmail.com', '+237659439114', '', 'dfgh', 'moi', '2026-05-08 15:57:08', 'repondu'),
(3, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:33:47', 'non-lu'),
(4, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:33:47', 'non-lu'),
(5, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:58:40', 'non-lu'),
(6, 'marie', 'marie@gmail.com', '', '', 'marie', '', '2026-05-09 11:08:36', 'non-lu'),
(7, 'marie', 'marie@gmail.com', '', '', 'marie', 'mnbvcxdrtyui', '2026-05-09 12:14:51', 'non-lu'),
(8, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:38', 'non-lu'),
(9, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:36', 'non-lu'),
(10, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:42', 'non-lu'),
(11, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:49', 'non-lu'),
(12, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:49', 'non-lu'),
(13, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:24:48', 'non-lu'),
(14, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:25:08', 'non-lu'),
(15, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:25:09', 'non-lu'),
(16, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:25:07', 'non-lu'),
(17, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:25:07', 'non-lu'),
(18, 'marie', 'marie@gmail.com', '+237655555555', 'architechture reseaux', 'mariela', 'mariela sgdhjfkdx', '2026-05-09 13:25:10', 'non-lu'),
(19, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:53', 'non-lu'),
(20, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:53', 'non-lu'),
(21, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:57', 'non-lu'),
(22, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:57', 'non-lu'),
(23, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:57', 'non-lu'),
(24, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:59', 'non-lu'),
(25, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:51:59', 'non-lu'),
(26, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:52:01', 'non-lu'),
(27, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:52:02', 'non-lu'),
(28, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:52:03', 'non-lu'),
(29, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 13:52:03', 'non-lu'),
(30, 'mariela', 'marie@gmail.com', '+237659439114', 'infographie', 'marie', 'fgfhjklkjhmgnfb', '2026-05-09 14:00:33', 'non-lu');

-- --------------------------------------------------------

--
-- Table structure for table `realisations`
--

DROP TABLE IF EXISTS `realisations`;
CREATE TABLE IF NOT EXISTS `realisations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisations`
--

INSERT INTO `realisations` (`id`, `title`, `category`, `description`, `thumbnail`, `created_at`) VALUES
(7, 'cablage', 'reseaux', 'bref 12354', '1777610690_thumb_hero (1).png', '2026-05-01 04:44:50'),
(8, 'developpememt', 'logiciel', 'cvbnbn', '1777611379_thumb_hero1.png', '2026-05-01 04:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `realisation_images`
--

DROP TABLE IF EXISTS `realisation_images`;
CREATE TABLE IF NOT EXISTS `realisation_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realisation_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `realisation_id` (`realisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisation_images`
--

INSERT INTO `realisation_images` (`id`, `realisation_id`, `image_path`) VALUES
(1, 1, 'C:\\wamp64\\www\\SiteVitrine STAND COMPUTER\\assets\\images'),
(2, 4, '1777558821_hero (2).png'),
(9, 7, '1777610690_hero (2).png'),
(5, 5, '1777560778_hero (2).png'),
(8, 6, '1777564282_hero (2).png'),
(10, 8, '1777611379_logo.png'),
(11, 7, '1777611424_hero.png'),
(12, 7, '1777611433_logo.png'),
(13, 7, '1777611444_hero11.png');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`, `image`, `created_at`, `category`) VALUES
(1, 'architechture reseaux', 'bref des ordinateurs', 'computer', 'hero.png', '2026-04-29 19:18:10', 'reseaux'),
(2, 'réseaux ', 'Installation, configuration et sécurisation de vos réseaux.', 'router', 'ghj', '2026-04-30 05:12:48', 'reseaux'),
(4, 'infographie', 'design, identite visuelle', 'palette', NULL, '2026-04-30 05:39:41', 'design'),
(5, 'developpement logiciel', 'solutions logicielles sur mesures pour optimiser vos processus', 'code', NULL, '2026-04-30 08:46:51', 'logiciel'),
(6, 'Marketing digit', 'dfgjskdlkjsgergtyjukilkjhghjkl', 'computer', '69facd9f01a10_hero (2).png', '2026-05-06 04:52:13', 'reseaux');

-- --------------------------------------------------------

--
-- Table structure for table `statistiques`
--

DROP TABLE IF EXISTS `statistiques`;
CREATE TABLE IF NOT EXISTS `statistiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projects_completed` int(11) DEFAULT '0',
  `clients_satisfied` int(11) DEFAULT '0',
  `years_experience` int(11) DEFAULT '0',
  `experts_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statistiques`
--

INSERT INTO `statistiques` (`id`, `projects_completed`, `clients_satisfied`, `years_experience`, `experts_count`) VALUES
(1, 255, 156, 2, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
