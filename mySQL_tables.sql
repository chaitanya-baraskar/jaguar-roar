-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2013 at 01:15 AM
-- Server version: 5.1.69
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jungle`
--

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE IF NOT EXISTS `hashtags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag` varchar(64) NOT NULL,
  `roars_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `hashtag` (`hashtag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `roars`
--

CREATE TABLE IF NOT EXISTS `roars` (
  `body` varchar(720) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lat` double NOT NULL DEFAULT '0' COMMENT 'Latitude',
  `lng` double NOT NULL DEFAULT '0' COMMENT 'Longitude',
  `users_id` int(10) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `sheep`
--

CREATE TABLE IF NOT EXISTS `sheep` (
  `sheep_id` int(11) NOT NULL,
  `users_id` int(10) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_sheep_users1_idx` (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
