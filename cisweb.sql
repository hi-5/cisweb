-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2014 at 06:01 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cis`
--

-- --------------------------------------------------------

--
-- Table structure for table `athletehistory`
--

CREATE TABLE IF NOT EXISTS `athletehistory` (
  `ah_id` int(11) NOT NULL AUTO_INCREMENT,
  `ah_studentId` int(11) NOT NULL,
  `ah_teamId` int(11) NOT NULL,
  `ah_teamName` varchar(64) NOT NULL,
  `ah_institute` varchar(64) NOT NULL,
  `ah_year` int(11) NOT NULL,
  `ah_position` varchar(32) NOT NULL,
  `ah_jerseyNumber` int(11) NOT NULL,
  `ah_charged` tinyint(1) NOT NULL,
  PRIMARY KEY (`ah_id`),
  UNIQUE KEY `ah_id` (`ah_id`),
  KEY `ah_studentId` (`ah_studentId`),
  KEY `ah_teamId` (`ah_teamId`),
  KEY `ah_year` (`ah_year`),
  KEY `ah_studentId_2` (`ah_studentId`),
  KEY `ah_teamId_2` (`ah_teamId`),
  KEY `ah_year_2` (`ah_year`),
  KEY `ah_studentId_3` (`ah_studentId`,`ah_teamId`,`ah_year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `athletequeue`
--

CREATE TABLE IF NOT EXISTS `athletequeue` (
  `aq_studentId` int(11) NOT NULL,
  `aq_resident` tinyint(1) NOT NULL,
  `aq_lastName` varchar(64) NOT NULL,
  `aq_firstName` varchar(64) NOT NULL,
  `aq_initials` varchar(16) NOT NULL,
  `aq_gender` varchar(16) NOT NULL,
  `aq_dob` date NOT NULL,
  `aq_height` varchar(6) NOT NULL,
  `aq_weight` int(11) NOT NULL,
  `aq_email` varchar(128) NOT NULL,
  `aq_hometown` text NOT NULL,
  `aq_highSchool` varchar(64) NOT NULL,
  `aq_gradYear` int(11) NOT NULL,
  `aq_program` varchar(64) NOT NULL,
  `aq_yearOfStudy` int(11) NOT NULL,
  `aq_cStreet` varchar(64) NOT NULL,
  `aq_cCity` varchar(64) NOT NULL,
  `aq_cProvince` varchar(2) NOT NULL,
  `aq_cPostalCode` varchar(7) NOT NULL,
  `aq_cCountry` varchar(64) NOT NULL,
  `aq_cPhone` varchar(64) NOT NULL,
  `aq_pStreet` varchar(64) NOT NULL,
  `aq_pCity` varchar(64) NOT NULL,
  `aq_pProvince` varchar(2) NOT NULL,
  `aq_pPostalCode` varchar(7) NOT NULL,
  `aq_pCountry` varchar(64) NOT NULL,
  `aq_pPhone` varchar(64) NOT NULL,
  PRIMARY KEY (`aq_studentId`),
  UNIQUE KEY `aq_studentId` (`aq_studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `athletequeuehistory`
--

CREATE TABLE IF NOT EXISTS `athletequeuehistory` (
  `aqh_id` int(11) NOT NULL AUTO_INCREMENT,
  `aqh_studentId` int(11) NOT NULL,
  `aqh_teamId` int(11) NOT NULL,
  `aqh_teamName` varchar(64) NOT NULL,
  `aqh_institute` varchar(64) NOT NULL,
  `aqh_year` int(11) NOT NULL,
  `aqh_position` varchar(32) NOT NULL,
  `aqh_jerseyNumber` int(11) NOT NULL,
  `aqh_charged` tinyint(1) NOT NULL,
  PRIMARY KEY (`aqh_id`),
  UNIQUE KEY `ah_id` (`aqh_id`),
  KEY `ah_studentId` (`aqh_studentId`),
  KEY `ah_teamId` (`aqh_teamId`),
  KEY `ah_year` (`aqh_year`),
  KEY `ah_studentId_2` (`aqh_studentId`),
  KEY `ah_teamId_2` (`aqh_teamId`),
  KEY `ah_year_2` (`aqh_year`),
  KEY `ah_studentId_3` (`aqh_studentId`,`aqh_teamId`,`aqh_year`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE IF NOT EXISTS `athletes` (
  `a_studentId` int(11) NOT NULL,
  `a_resident` tinyint(1) NOT NULL,
  `a_lastName` varchar(64) NOT NULL,
  `a_firstName` varchar(64) NOT NULL,
  `a_initials` varchar(16) NOT NULL,
  `a_gender` varchar(16) NOT NULL,
  `a_dob` date NOT NULL,
  `a_height` varchar(6) NOT NULL,
  `a_weight` int(11) NOT NULL,
  `a_email` varchar(128) NOT NULL,
  `a_hometown` text NOT NULL,
  `a_highSchool` varchar(64) NOT NULL,
  `a_gradYear` int(11) NOT NULL,
  `a_program` varchar(64) NOT NULL,
  `a_yearOfStudy` int(11) NOT NULL,
  `a_cStreet` varchar(64) NOT NULL,
  `a_cCity` varchar(64) NOT NULL,
  `a_cProvince` varchar(2) NOT NULL,
  `a_cPostalCode` varchar(7) NOT NULL,
  `a_cCountry` varchar(64) NOT NULL,
  `a_cPhone` varchar(64) NOT NULL,
  `a_pStreet` varchar(64) NOT NULL,
  `a_pCity` varchar(64) NOT NULL,
  `a_pProvince` varchar(2) NOT NULL,
  `a_pPostalCode` varchar(7) NOT NULL,
  `a_pCountry` varchar(64) NOT NULL,
  `a_pPhone` varchar(64) NOT NULL,
  PRIMARY KEY (`a_studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `f_studentId` int(11) NOT NULL,
  `f_lastName` varchar(64) NOT NULL,
  `f_firstName` varchar(64) NOT NULL,
  `f_phone` varchar(64) NOT NULL,
  `f_email` varchar(128) NOT NULL,
  `f_isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`f_studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(64) NOT NULL,
  `r_string` text NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `t_id` int(11) NOT NULL,
  `t_year` int(11) NOT NULL,
  `t_name` varchar(64) NOT NULL,
  `t_headCoachId` int(11) NOT NULL,
  `t_asstCoachId` int(11) NOT NULL,
  `t_managerId` int(11) NOT NULL,
  `t_trainerId` int(11) NOT NULL,
  `t_doctorId` int(11) NOT NULL,
  `t_therapistId` int(11) NOT NULL,
  PRIMARY KEY (`t_id`,`t_year`),
  KEY `t_id` (`t_id`),
  KEY `t_year` (`t_year`),
  KEY `t_id_2` (`t_id`),
  KEY `t_id_3` (`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
