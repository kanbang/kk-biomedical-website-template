-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2015 at 01:28 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rahadarmanbykk`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutbykk_de`
--

CREATE TABLE IF NOT EXISTS `aboutbykk_de` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `about_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `about_index` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aboutbykk_en`
--

CREATE TABLE IF NOT EXISTS `aboutbykk_en` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `about_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `about_index` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aboutbykk_fa`
--

CREATE TABLE IF NOT EXISTS `aboutbykk_fa` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `about_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `about_index` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filledformbykk`
--

CREATE TABLE IF NOT EXISTS `filledformbykk` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `fld_1` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_2` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_3` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_4` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_5` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_6` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_7` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_8` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_9` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_10` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_11` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_12` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_13` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_14` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_15` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_16` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_17` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_18` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_19` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_20` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_21` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_22` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_23` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_24` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_25` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_26` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_27` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_28` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_29` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_30` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_31` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_32` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_33` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_34` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_35` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_36` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_37` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_38` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_39` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_40` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_41` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_42` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_43` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_44` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_45` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_46` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_47` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_48` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_49` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_50` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_51` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_52` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_53` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_54` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_55` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_56` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_57` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_58` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_59` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_60` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_61` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_62` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_63` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_64` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_65` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_66` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_67` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_68` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_69` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fld_70` varchar(291) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `seen` int(1) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formbykk`
--

CREATE TABLE IF NOT EXISTS `formbykk` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `document_code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fclass` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `field_num` int(10) NOT NULL,
  `fs_1` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_1` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_2` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_2` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_3` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_3` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_4` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_4` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_5` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_6` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_6` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_7` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_7` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_8` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_8` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_9` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_9` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_10` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_10` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_11` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_11` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_12` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_12` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_13` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_13` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_14` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_14` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_15` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_15` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_16` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_16` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_17` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_17` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_18` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_18` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_19` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_19` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_20` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_20` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_21` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_21` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_22` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_22` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_23` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_23` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_24` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_24` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_25` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_25` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_26` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_26` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_27` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_27` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_28` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_28` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_29` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_29` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_30` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_30` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_31` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_31` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_32` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_32` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_33` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_33` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_34` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_34` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_35` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_35` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_36` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_36` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_37` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_37` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_38` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_38` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_39` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_39` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_40` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_40` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_41` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_41` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_42` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_42` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_43` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_43` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_44` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_44` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_45` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_45` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_46` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_46` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_47` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_47` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_48` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_48` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_49` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_49` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_50` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_50` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_51` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_51` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_52` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_52` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_53` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_53` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_54` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_54` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_55` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_55` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_56` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_56` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_57` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_57` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_58` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_58` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_59` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_59` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_60` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_60` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_61` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_61` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_62` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_62` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_63` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_63` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_64` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_64` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_65` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_65` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_66` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_66` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_67` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_67` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_68` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_68` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_69` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_69` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fs_70` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fn_70` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL,
  `info` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flang` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fa'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallerybykk_de`
--

CREATE TABLE IF NOT EXISTS `gallerybykk_de` (
  `id` int(11) NOT NULL,
  `album` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `cover1` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover2` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover3` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_cover` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallerybykk_en`
--

CREATE TABLE IF NOT EXISTS `gallerybykk_en` (
  `id` int(11) NOT NULL,
  `album` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `cover1` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover2` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover3` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_cover` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `gallerybykk_fa`
--

CREATE TABLE IF NOT EXISTS `gallerybykk_fa` (
  `id` int(11) NOT NULL,
  `album` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `cover1` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover2` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cover3` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `picture` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_cover` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `picture_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messagebykk`
--

CREATE TABLE IF NOT EXISTS `messagebykk` (
  `id` int(11) NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `message` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `mreply` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `seen` int(1) NOT NULL DEFAULT '0',
  `mlang` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `newsbykk_de`
--

CREATE TABLE IF NOT EXISTS `newsbykk_de` (
  `id` int(11) NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news',
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `news_index` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsbykk_en`
--

CREATE TABLE IF NOT EXISTS `newsbykk_en` (
  `id` int(11) NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news',
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `news_index` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsbykk_fa`
--

CREATE TABLE IF NOT EXISTS `newsbykk_fa` (
  `id` int(11) NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'news',
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `news_index` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productbykk_de`
--

CREATE TABLE IF NOT EXISTS `productbykk_de` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `p_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sub_category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sub_category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures_thumb` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `index1_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index1` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `whocandl` int(1) NOT NULL DEFAULT '1',
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `highlight` int(1) NOT NULL DEFAULT '0',
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productbykk_en`
--

CREATE TABLE IF NOT EXISTS `productbykk_en` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `p_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sub_category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sub_category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures_thumb` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `index1_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index1` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `whocandl` int(1) NOT NULL DEFAULT '1',
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `highlight` int(1) NOT NULL DEFAULT '0',
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productbykk_fa`
--

CREATE TABLE IF NOT EXISTS `productbykk_fa` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `p_note` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sub_category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sub_category_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `other_pictures_thumb` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `index1_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index1` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index2` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index3` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `index4` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `attachments` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `whocandl` int(1) NOT NULL DEFAULT '1',
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linktext2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `highlight` int(1) NOT NULL DEFAULT '0',
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `visitcounter` int(11) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `registerbykk`
--

CREATE TABLE IF NOT EXISTS `registerbykk` (
  `id` int(11) NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `iran_state` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `md5_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `user_level` int(2) NOT NULL DEFAULT '0',
  `uadmin` int(1) NOT NULL DEFAULT '0',
  `ulogout` int(1) NOT NULL DEFAULT '1',
  `ulaerror` int(2) NOT NULL DEFAULT '0',
  `ulang` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slidebykk_de`
--

CREATE TABLE IF NOT EXISTS `slidebykk_de` (
  `id` int(11) NOT NULL,
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slidebykk_en`
--

CREATE TABLE IF NOT EXISTS `slidebykk_en` (
  `id` int(11) NOT NULL,
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slidebykk_fa`
--

CREATE TABLE IF NOT EXISTS `slidebykk_fa` (
  `id` int(11) NOT NULL,
  `original_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `picture_thumb` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `linkto` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `linkid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `showto` int(1) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jdate` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jtime` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitbykk_de`
--

CREATE TABLE IF NOT EXISTS `visitbykk_de` (
  `id` int(11) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pmain` int(11) NOT NULL DEFAULT '0',
  `pproduct` int(11) NOT NULL DEFAULT '0',
  `pnews` int(11) NOT NULL DEFAULT '0',
  `pgallery` int(11) NOT NULL DEFAULT '0',
  `pabout` int(11) NOT NULL DEFAULT '0',
  `pcontact` int(11) NOT NULL DEFAULT '0',
  `pform` int(11) NOT NULL DEFAULT '0',
  `pitem1` int(11) NOT NULL DEFAULT '0',
  `pitem2` int(11) NOT NULL DEFAULT '0',
  `pitem3` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitbykk_en`
--

CREATE TABLE IF NOT EXISTS `visitbykk_en` (
  `id` int(11) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pmain` int(11) NOT NULL DEFAULT '0',
  `pproduct` int(11) NOT NULL DEFAULT '0',
  `pnews` int(11) NOT NULL DEFAULT '0',
  `pgallery` int(11) NOT NULL DEFAULT '0',
  `pabout` int(11) NOT NULL DEFAULT '0',
  `pcontact` int(11) NOT NULL DEFAULT '0',
  `pform` int(11) NOT NULL DEFAULT '0',
  `pitem1` int(11) NOT NULL DEFAULT '0',
  `pitem2` int(11) NOT NULL DEFAULT '0',
  `pitem3` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitbykk_fa`
--

CREATE TABLE IF NOT EXISTS `visitbykk_fa` (
  `id` int(11) NOT NULL,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pmain` int(11) NOT NULL DEFAULT '0',
  `pproduct` int(11) NOT NULL DEFAULT '0',
  `pnews` int(11) NOT NULL DEFAULT '0',
  `pgallery` int(11) NOT NULL DEFAULT '0',
  `pabout` int(11) NOT NULL DEFAULT '0',
  `pcontact` int(11) NOT NULL DEFAULT '0',
  `pform` int(11) NOT NULL DEFAULT '0',
  `pitem1` int(11) NOT NULL DEFAULT '0',
  `pitem2` int(11) NOT NULL DEFAULT '0',
  `pitem3` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
