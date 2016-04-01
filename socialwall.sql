-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 29 Mars 2016 à 17:51
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `socialwall`
--

-- --------------------------------------------------------

--
-- Structure de la table `socialrefresh`
--

CREATE TABLE IF NOT EXISTS `socialrefresh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) NOT NULL,
  `last_refresh` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `socialrefresh`
--

INSERT INTO `socialrefresh` (`id`, `source`, `last_refresh`) VALUES
(1, 'instagram', '2016-03-29 14:53:41'),
(2, 'twitter', '2016-03-29 14:53:42'),
(3, 'facebook', '2016-03-29 14:53:42');

-- --------------------------------------------------------

--
-- Structure de la table `socialwall`
--

CREATE TABLE IF NOT EXISTS `socialwall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_social` bigint(20) NOT NULL,
  `date_created` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `rt` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=122 ;

-
