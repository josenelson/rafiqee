-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2011 at 05:32 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rafiqee`
--

-- --------------------------------------------------------

--
-- Table structure for table `canvas`
--

CREATE TABLE IF NOT EXISTS `canvas` (
  `canvasid` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`canvasid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvas`
--


-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE IF NOT EXISTS `elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(255) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `properties` varchar(255) NOT NULL,
  `canvas` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `styles` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`id`, `user_id`, `updated`, `properties`, `canvas`, `content`, `styles`) VALUES
(1, 1, '2011-11-30 23:34:01', 'content', 1, 'undefined', 'left:360px,top:23px,width:200px,height:150px'),
(2, 1, '2011-11-30 23:33:53', '', 1, 'undefined', 'left:754px,top:-64px,width:100px,height:150px');

-- --------------------------------------------------------

--
-- Table structure for table `empty_table`
--

CREATE TABLE IF NOT EXISTS `empty_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `empty_table`
--


-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type` int(11) NOT NULL,
  `canvas_id` int(11) NOT NULL,
  `unix_timestamp` bigint(20) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `source` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_type`, `canvas_id`, `unix_timestamp`, `user_id`, `source`) VALUES
(2, 1, 1, 1322720782, 2, 2),
(3, 1, 1, 6, 2, 3),
(4, 1, 1, 4, 1, 2),
(5, 1, 1, 1322723156, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userownscanvas`
--

CREATE TABLE IF NOT EXISTS `userownscanvas` (
  `userid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `userownscanvas`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
