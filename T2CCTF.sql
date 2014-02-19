-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014 年 2 月 19 日 09:36
-- サーバのバージョン： 5.6.15
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `T2CCTF`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ans_log`
--

CREATE TABLE IF NOT EXISTS `ans_log` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `q_no` int(10) unsigned NOT NULL,
  `q_point` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `team` varchar(64) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;


--
-- テーブルの構造 `chat_log`
--

CREATE TABLE IF NOT EXISTS `chat_log` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `comments` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;



--
-- テーブルの構造 `false_log`
--

CREATE TABLE IF NOT EXISTS `false_log` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `q_no` int(10) unsigned NOT NULL,
  `ans` varchar(64) NOT NULL,
  `team` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=346 ;



--
-- テーブルの構造 `game_time`
--

CREATE TABLE IF NOT EXISTS `game_time` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


--
-- テーブルの構造 `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `category` varchar(32) NOT NULL,
  `sentence` text NOT NULL,
  `flag` varchar(64) NOT NULL,
  `point` int(11) NOT NULL,
  `hint1` text NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;



--
-- テーブルの構造 `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `points` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


--
-- テーブルの構造 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `team` varchar(64) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
