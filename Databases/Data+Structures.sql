-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2013 at 01:43 PM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bncapps_currentbitcoin`
--

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exchange` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `high` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `low` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastupdate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `exchange`, `last`, `high`, `low`, `lastupdate`) VALUES
(1, 'btc-e', '91.3', '97.4', '89.106', 1372444201),
(2, 'mtgox', '96.7', '102.92', '95.5', 1372444976),
(3, 'btc-eltc', '2.6419', '2.845', '2.6', 1372444970),
(4, 'mtgoxltc', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `track_currencies`
--

CREATE TABLE IF NOT EXISTS `track_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `short` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `track_currencies`
--

INSERT INTO `track_currencies` (`id`, `name`, `short`) VALUES
(1, 'Bitcoin', 'BTC'),
(2, 'Litecoin', 'LTC'),
(3, 'Namecoin', 'NMC'),
(4, 'PPCoin', 'PPC'),
(5, 'Terracoin', 'TRC'),
(6, 'Novacoin', 'NVC');

-- --------------------------------------------------------

--
-- Table structure for table `track_exchanges`
--

CREATE TABLE IF NOT EXISTS `track_exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currencyid` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apipair` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `last` float NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `track_exchanges`
--

INSERT INTO `track_exchanges` (`id`, `currencyid`, `name`, `apipair`, `last`, `high`, `low`, `updated`) VALUES
(1, 1, 'MtGox', '', 96.7, 102.92, 95.5, 1372444972),
(2, 1, 'BTC-E', 'btc_usd', 90.1, 97.4, 89.106, 1372444972),
(3, 2, 'BTC-E', 'ltc_usd', 2.6419, 2.845, 2.6, 1372444972),
(4, 3, 'BTC-E', 'nmc_btc', 0.485639, 0.54544, 0.476717, 1372444972),
(5, 4, 'BTC-E', 'ppc_btc', 0.110823, 0.125646, 0.104254, 1372444973),
(6, 5, 'BTC-E', 'trc_btc', 0.118932, 0.129542, 0.116729, 1372444973),
(7, 6, 'BTC-E', 'nvc_btc', 2.8832, 3.1655, 2.85139, 1372444973);

-- --------------------------------------------------------

--
-- Table structure for table `track_stats`
--

CREATE TABLE IF NOT EXISTS `track_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statkey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `track_stats`
--

INSERT INTO `track_stats` (`id`, `statkey`, `value`) VALUES
(1, 'updated', 1372444972);

-- --------------------------------------------------------

--
-- Table structure for table `track_usdrates`
--

CREATE TABLE IF NOT EXISTS `track_usdrates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rate` float NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `track_usdrates`
--

INSERT INTO `track_usdrates` (`id`, `name`, `rate`, `updated`) VALUES
(1, 'CAD', 1.0473, 1372442402),
(2, 'EUR', 0.766225, 1372442402),
(3, 'GBP', 0.655437, 1372442402);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
