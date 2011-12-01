/*
 Navicat MySQL Data Transfer

 Source Server         : local
 Source Server Version : 50144
 Source Host           : localhost
 Source Database       : samples

 Target Server Version : 50144
 File Encoding         : utf-8

 Date: 12/01/2011 15:20:01 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `elements`
-- ----------------------------
DROP TABLE IF EXISTS `elements`;
CREATE TABLE `elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `properties` varchar(255) NOT NULL,
  `canvas` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `styles` varchar(255) NOT NULL,
  `unix_timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `elements`
-- ----------------------------
BEGIN;
INSERT INTO `elements` VALUES ('1', '1', '2011-11-30 23:34:01', 'content', '1', 'undefined', 'left:360px,top:23px,width:200px,height:150px', '1322724841'), ('2', '1', '2011-11-30 23:33:53', '', '1', 'undefined', 'left:754px,top:-64px,width:100px,height:150px', '1322724833');
COMMIT;

-- ----------------------------
--  Table structure for `empty_table`
-- ----------------------------
DROP TABLE IF EXISTS `empty_table`;
CREATE TABLE `empty_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `events`
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type` int(11) NOT NULL,
  `canvas_id` int(11) NOT NULL,
  `unix_timestamp` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `events`
-- ----------------------------
BEGIN;
INSERT INTO `events` VALUES ('2', '1', '1', '1322720782', '2', '2'), ('3', '1', '1', '6', '2', '3'), ('4', '1', '1', '4', '1', '2'), ('5', '1', '1', '1322723156', '2', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
