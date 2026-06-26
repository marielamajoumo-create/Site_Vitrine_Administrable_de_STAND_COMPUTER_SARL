-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2026 at 02:53 PM
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
  `nom` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwor` varchar(255) NOT NULL,
  `role` enum('super_admin','admin') DEFAULT 'admin',
  `actif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `username`, `passwor`, `role`, `actif`, `created_at`, `updated_at`, `last_login`) VALUES
(1, '', 'admin', '0192023a7bbd73250516f069df18b500', 'admin', 1, '2026-06-26 12:15:53', NULL, NULL),
(2, '', 'stand', 'stand', 'super_admin', 1, '2026-06-26 12:15:53', NULL, NULL),
(3, '', 'computer', 'computer', 'admin', 1, '2026-06-26 12:15:53', NULL, NULL),
(4, 'MarieMajo', 'mj', 'mj', 'super_admin', 1, '2026-06-26 12:31:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text,
  `image` varchar(255) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `date_pub` datetime DEFAULT CURRENT_TIMESTAMP,
  `featured` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `image`, `categorie_id`, `auteur`, `date_pub`, `featured`) VALUES
(1, 'Le Numérique au coeur du Monde', 'PENSEZ VOUS QUE LE NUMERIQUE SOIT INDISPENSABLE A NOS JOURS ?', '2276.jpg', 1, 'Monsieur Madame', '2026-05-17 18:01:13', 0),
(2, 'Le Numérique au coeur du Monde', 'idem', '2276.jpg', 2, 'Monsieur Madame', '2026-05-17 18:08:09', 1),
(3, 'dfghjkl', 'xcvbnm,.', '2279.jpg', 1, 'cvbnm ,', '2026-05-25 14:35:04', 0),
(4, 'asfdghjkl', 'sdbvnm,.', '2337.jpg', 2, 'rghjk,.l', '2026-05-25 14:42:37', 0),
(5, 'sdfghjkl;lkjmh', 'asdfgbhnjmk,l./', '2295.jpg', 1, 'cvbnm,./', '2026-05-25 14:42:58', 0),
(6, 'sdfghbjnk,', 'sdcvbfnm,k.', '2590.jpg', 2, 'sdbfgnmjhnm ', '2026-05-25 14:43:24', 0),
(7, 'sdfgvnhjkl', 'dfghjk', '2613.jpg', 1, 'dfgjhk.,', '2026-05-25 14:52:22', 0),
(8, 'l\'ile de la connaissance', 'bref le titre est explicite', '2624.jpg', 1, 'me---', '2026-05-29 11:06:05', 0),
(9, 'je n;ai plus l\'inspiration', 'sorry ', '2321.jpg', 2, 'me--', '2026-05-29 13:43:41', 0),
(10, 'Le numerique au coeur de la nation', 'que voulez vous savoir de plus? c;est ca qui est ca . je vous reviendrai certainement un jour . hahahaha. wokoo petit pain avocat pour l\'illustration.', '2277.jpg', 1, 'me ', '2026-06-03 12:53:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `article_tags`
--

DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE IF NOT EXISTS `article_tags` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`tag_id`),
  KEY `fk_tag` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_tags`
--

INSERT INTO `article_tags` (`article_id`, `tag_id`) VALUES
(10, 1),
(10, 2),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Mondial'),
(2, 'reseaux');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `phone`, `email`, `whatsapp`, `localisation`, `villeQuartier`, `pays`, `created_at`, `updated_at`) VALUES
(1, '+237695830138', 'marielamajoumo@gmail.com', '237659439114', 'Carrefour Manga philippe', 'Yaounde,Ekoumdoum', 'Cameroun', '2026-05-06 08:58:05', '2026-05-25 11:23:48');

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
(2, 'avance', 'maintenance 1', 'maintenir app 1', 'oui et bien d\'autres 1', '6a1ab3606da93_2282.jpg', '', '18max', 'certificat1', '2026-04-29 19:36:54'),
(3, '', 'resaux', '', 'ouioui', '6a1ab412632ee_2292.jpg', '6 mois', '0', '', '2026-04-29 19:55:28'),
(4, 'debutant', 'maintenance', 'maintenancier', 'blabla', '6a1ab43d1e9ce_2293.jpg', '6 mois', '20', 'certificat', '2026-05-04 11:29:50');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horaires`
--

INSERT INTO `horaires` (`id`, `jour`, `ouvertureFermeture`, `created_at`, `updated_at`) VALUES
(1, 'Lundi - Vendredi', '8h30-16h00', '2026-05-06 09:11:49', '2026-05-06 09:26:48'),
(2, 'Samedi', '9h00-12h30', '2026-05-06 09:12:25', '2026-05-06 09:26:48'),
(3, 'Dimanche', 'ferme', '2026-05-15 12:07:38', '2026-05-15 12:07:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `telephone`, `serviceC`, `sujet`, `messageR`, `date_creation`, `statut`) VALUES
(1, '', '', '', '', '', '', '2026-05-08 15:50:07', 'repondu'),
(2, 'ghj', 'moi@gmail.com', '+237659439114', '', 'dfgh', 'moi', '2026-05-08 15:57:08', 'repondu'),
(3, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:33:47', 'non-lu'),
(4, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:33:47', 'non-lu'),
(5, 'marie', 'marie@gmail.com', '', '', 'marie', 'marie', '2026-05-09 10:58:40', 'repondu'),
(6, 'marie', 'marie@gmail.com', '', '', 'marie', '', '2026-05-09 11:08:36', 'repondu'),
(7, 'mariela', 'marie@gmail.com', '+237659439111', 'infographie', 'infographieeeeeee', 'bla bla', '2026-05-25 12:25:39', 'non-lu');

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
(7, 'cablage reseaux', 'reseaux', 'bref 12354', '1777610690_thumb_hero (1).png', '2026-05-01 04:44:50'),
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisation_images`
--

INSERT INTO `realisation_images` (`id`, `realisation_id`, `image_path`) VALUES
(1, 1, 'C:\\wamp64\\www\\SiteVitrine STAND COMPUTER\\assets\\images'),
(2, 4, '1777558821_hero (2).png'),
(9, 7, '1777610690_hero (2).png'),
(5, 5, '1777560778_hero (2).png'),
(8, 6, '1777564282_hero (2).png'),
(11, 7, '1777611424_hero.png'),
(12, 7, '1777611433_logo.png'),
(13, 7, '1777611444_hero11.png'),
(14, 8, '1780135435_2276.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `realisation_videos`
--

DROP TABLE IF EXISTS `realisation_videos`;
CREATE TABLE IF NOT EXISTS `realisation_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realisation_id` int(11) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_realisation_id` (`realisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisation_videos`
--

INSERT INTO `realisation_videos` (`id`, `realisation_id`, `video_path`, `created_at`) VALUES
(1, 8, '1778845131_video_0_VID-20220103-WA0009.mp4', '2026-05-15 11:38:51'),
(2, 8, '1780135593_video_0_IMG-20220228-WA0024.mp4', '2026-05-30 10:06:33'),
(4, 8, '1780315625_video_0_VID_20240918_164839.mp4', '2026-06-01 12:07:05');

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
(2, 'réseaux ', 'Installation, configuration et sécurisation de vos réseaux.', 'router', '6a1ab4fa2f76a_2336.jpg', '2026-04-30 05:12:48', 'reseaux'),
(4, 'infographie', 'design, identite visuelle', 'palette', '6a1ab50caf05c_2284.jpg', '2026-04-30 05:39:41', 'design'),
(5, 'developpement logiciel', 'solutions logicielles sur mesures pour optimiser vos processus', 'code', '6a1ab51f6c7e4_2294.jpg', '2026-04-30 08:46:51', 'logiciel'),
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

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `nom`, `slug`) VALUES
(1, 'numerique', 'numerique'),
(2, 'monde', 'monde'),
(3, 'cybersecurite', 'cybersecurite'),
(4, 'bref', 'bref');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
