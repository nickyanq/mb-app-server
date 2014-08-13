-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2014 at 03:23 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_fdl`
--
CREATE DATABASE IF NOT EXISTS `_fdl` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `_fdl`;

-- --------------------------------------------------------

--
-- Table structure for table `fdls`
--

CREATE TABLE IF NOT EXISTS `fdls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `fdls`
--

INSERT INTO `fdls` (`id`, `title`, `content`) VALUES
(1, 'Fuck this life', 'Today I was hit by a train. FDL'),
(2, 'Welcome to FDL', 'This is the message'),
(3, 'What can I say?', 'Today, I was stuck on a campus tour with my subtly racist mother who, in an attempt to seem open-minded, deemed it appropriate to refer to our black tour guide as "Sistah"'),
(4, 'Why God? Why me??', 'Today, I was interviewing a woman for a job. She told me that she may need days off because of her artistic son. I jokingly replied, "Does he color on the walls or something?" She then stared at me with a weird look on her face. Autistic. Her son is autistic'),
(5, 'I almost died...', 'Today, I nearly had an anxiety attack trying to sneak up on my sister to silly-string her. FML');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `create_date`) VALUES
(1, 'Corneliu', 'Iancu', 'nickyanq', 'pass', '2014-07-11 17:47:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
