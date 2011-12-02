-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2011 at 02:50 AM
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `canvas`
--

INSERT INTO `canvas` (`id`, `description`, `user_id`) VALUES
(1, 'Asim test canvas 1', 1182800656),
(2, 'abcdef', 1),
(7, 'Asim''s second canvas', 1182800656);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`id`, `user_id`, `updated`, `properties`, `canvas`, `content`, `styles`) VALUES
(1, 1, '2011-12-01 23:56:14', '', 1, 'undefined', 'left:16px,top:57px,width:200px,height:150px'),
(2, 1, '2011-11-30 23:33:53', '', 1, 'undefined', 'left:754px,top:-64px,width:100px,height:150px'),
(5, 69, '2011-12-01 23:47:16', 'b', 2, 'c', 'a'),
(6, 1, '2011-12-02 01:31:18', '', 2, 'helloworld', 'left: 50px, top: 50px');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_type`, `canvas_id`, `unix_timestamp`, `user_id`, `source`) VALUES
(2, 1, 1, 1322720782, 2, 2),
(3, 1, 1, 6, 2, 3),
(4, 1, 1, 4, 1, 2),
(5, 1, 1, 1322723156, 2, 1),
(6, 2, 2, 1322802438, 1182800656, 3),
(7, 4, 2, 1322802817, 1182800656, 3),
(8, 5, 2, 1322804860, 69, 0),
(9, 2, 1, 1322805398, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userhascanvas`
--

CREATE TABLE IF NOT EXISTS `userhascanvas` (
  `user_id` bigint(11) NOT NULL,
  `canvas_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `userhascanvas`
--

INSERT INTO `userhascanvas` (`user_id`, `canvas_id`, `id`) VALUES
(1182800656, 2, 4),
(1234, 1, 3),
(1182800656, 6, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
