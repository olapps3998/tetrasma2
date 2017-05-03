-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2017 at 07:26 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tetrasma2`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_audittrail`
--

CREATE TABLE IF NOT EXISTS `t_audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `t_audittrail`
--

INSERT INTO `t_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2017-05-03 19:37:12', '/tetrasma2/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '2017-05-03 19:37:31', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '1', '', '1'),
(3, '2017-05-03 19:37:31', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '1', '', 'Aktiva'),
(4, '2017-05-03 19:37:31', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '1', '', '1'),
(5, '2017-05-03 19:38:01', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '2', '', '2'),
(6, '2017-05-03 19:38:01', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '2', '', 'Hutang'),
(7, '2017-05-03 19:38:01', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '2', '', '2'),
(8, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', '*** Batch insert begin ***', 't_coal1', '', '', '', ''),
(9, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '3', '', '3'),
(10, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '3', '', 'Modal'),
(11, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '3', '', '3'),
(12, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '4', '', '4'),
(13, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '4', '', 'Pendapatan'),
(14, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '4', '', '4'),
(15, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '5', '', '5'),
(16, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '5', '', 'HPP'),
(17, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '5', '', '5'),
(18, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_no', '6', '', '6'),
(19, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_nm', '6', '', 'Biaya'),
(20, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', 'A', 't_coal1', 'coal1_id', '6', '', '6'),
(21, '2017-05-03 19:38:46', '/tetrasma2/t_coal1list.php', '1', '*** Batch insert successful ***', 't_coal1', '', '', '', ''),
(22, '2017-05-03 19:44:11', '/tetrasma2/t_coal2list.php', '1', '*** Batch insert begin ***', 't_coal2', '', '', '', ''),
(23, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '1', '', '1'),
(24, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '1', '', 'Aktiva Lancar'),
(25, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '1', '', '1'),
(26, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '1', '', '1'),
(27, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '2', '', '2'),
(28, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '2', '', 'Aktiva Tetap'),
(29, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '2', '', '1'),
(30, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '2', '', '2'),
(31, '2017-05-03 19:44:12', '/tetrasma2/t_coal2list.php', '1', '*** Batch insert successful ***', 't_coal2', '', '', '', ''),
(32, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', '*** Batch update begin ***', 't_coal2', '', '', '', ''),
(33, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal1_id', '3', '', '2'),
(34, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_no', '3', '', '1'),
(35, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_nm', '3', '', 'Hutang Jk. Pendek'),
(36, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_id', '3', '', '3'),
(37, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal1_id', '4', '', '2'),
(38, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_no', '4', '', '2'),
(39, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_nm', '4', '', 'Hutang Jk. Panjang'),
(40, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', 'A', 't_coal2', 'coal2_id', '4', '', '4'),
(41, '2017-05-03 23:04:52', '/tetrasma2/t_coal1edit.php', '1', '*** Batch update successful ***', 't_coal2', '', '', '', ''),
(42, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', '*** Batch insert begin ***', 't_coal2', '', '', '', ''),
(43, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '5', '', '3'),
(44, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '5', '', '1'),
(45, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '5', '', 'Modal Pemilik'),
(46, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '5', '', '5'),
(47, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '6', '', '4'),
(48, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '6', '', '1'),
(49, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '6', '', 'Pendapatan Usaha'),
(50, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '6', '', '6'),
(51, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '7', '', '5'),
(52, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '7', '', '1'),
(53, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '7', '', 'HPP'),
(54, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '7', '', '7'),
(55, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal1_id', '8', '', '6'),
(56, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_no', '8', '', '1'),
(57, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_nm', '8', '', 'Biaya'),
(58, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', 'A', 't_coal2', 'coal2_id', '8', '', '8'),
(59, '2017-05-03 23:06:36', '/tetrasma2/t_coal2list.php', '1', '*** Batch insert successful ***', 't_coal2', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_coal1`
--

CREATE TABLE IF NOT EXISTS `t_coal1` (
  `coal1_id` int(11) NOT NULL AUTO_INCREMENT,
  `coal1_no` varchar(2) NOT NULL,
  `coal1_nm` varchar(50) NOT NULL,
  PRIMARY KEY (`coal1_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_coal1`
--

INSERT INTO `t_coal1` (`coal1_id`, `coal1_no`, `coal1_nm`) VALUES
(1, '1', 'Aktiva'),
(2, '2', 'Hutang'),
(3, '3', 'Modal'),
(4, '4', 'Pendapatan'),
(5, '5', 'HPP'),
(6, '6', 'Biaya');

-- --------------------------------------------------------

--
-- Table structure for table `t_coal2`
--

CREATE TABLE IF NOT EXISTS `t_coal2` (
  `coal2_id` int(11) NOT NULL AUTO_INCREMENT,
  `coal2_no` varchar(2) NOT NULL,
  `coal2_nm` varchar(50) NOT NULL,
  `coal1_id` int(11) NOT NULL,
  PRIMARY KEY (`coal2_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `t_coal2`
--

INSERT INTO `t_coal2` (`coal2_id`, `coal2_no`, `coal2_nm`, `coal1_id`) VALUES
(1, '1', 'Aktiva Lancar', 1),
(2, '2', 'Aktiva Tetap', 1),
(3, '1', 'Hutang Jk. Pendek', 2),
(4, '2', 'Hutang Jk. Panjang', 2),
(5, '1', 'Modal Pemilik', 3),
(6, '1', 'Pendapatan Usaha', 4),
(7, '1', 'HPP', 5),
(8, '1', 'Biaya', 6);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nm` varchar(50) NOT NULL,
  `user_pw` varchar(50) NOT NULL,
  `user_lv` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`user_id`, `user_nm`, `user_pw`, `user_lv`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', -1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
