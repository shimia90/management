-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2015 at 04:57 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `management`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE IF NOT EXISTS `project_type` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `project_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `project_type`
--

INSERT INTO `project_type` (`id`, `project_type`) VALUES
(1, 'Maintenance'),
(2, 'New Coding'),
(3, 'Domestic'),
(4, 'Newton'),
(5, 'Research'),
(6, 'Other'),
(7, 'FC'),
(8, 'Working'),
(9, 'Newton Detail'),
(10, 'New Coding Detail'),
(11, 'FC Detail');

-- --------------------------------------------------------

--
-- Table structure for table `source_link`
--

CREATE TABLE IF NOT EXISTS `source_link` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link_month` int(255) NOT NULL,
  `link_year` int(255) NOT NULL,
  `project_link` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_link` (`project_link`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `source_link`
--

INSERT INTO `source_link` (`id`, `link`, `link_month`, `link_year`, `project_link`) VALUES
(1, 'https://docs.google.com/spreadsheets/d/1VRE9AtN-csRxYwtuhWBUdt7UQlGoKMs3Bvdcne0BfWg/pub?gid=374976129&single=true&output=csv', 12, 2015, 1),
(2, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=286695846&single=true&output=csv', 12, 2015, 2),
(3, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=1804870615&single=true&output=csv', 12, 2015, 3),
(4, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=1306398297&single=true&output=csv', 12, 2015, 4),
(5, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=128550101&single=true&output=csv', 12, 2015, 5),
(6, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=42619126&single=true&output=csv', 12, 2015, 6),
(7, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=1986987761&single=true&output=csv', 12, 2015, 7),
(8, 'https://docs.google.com/spreadsheets/d/1F1wmI4sykVsF6YXiVkmbeCM4k5_-DzqE9w_6TuwILbc/pub?gid=1234491418&single=true&output=csv', 12, 2015, 8),
(9, 'https://docs.google.com/spreadsheets/d/18OztKU73I3zQHWWlYwYgalciFCWD_IowwsHd-YabkBE/pub?gid=785801277&single=true&output=csv', 12, 2015, 9),
(10, 'https://docs.google.com/spreadsheets/d/1jvI2pjdVTwdZZhe0pHFxDU4TB5w3q14xHB0B-_f9-Dc/pub?gid=152&single=true&output=csv', 12, 2015, 10),
(11, 'https://docs.google.com/spreadsheets/d/1P-x779JZq54dClDvPkzAWDxRJkg26V4XyK--GbU5Hqo/pub?gid=1&single=true&output=csv', 12, 2015, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `team` int(50) NOT NULL,
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nickname`, `fullname`, `team`, `position`) VALUES
(1, 'DatNVT', 'Nguyễn Vũ Tiến Đạt', 1, 'leader'),
(2, 'TrucPTT', 'Phan Thị Thanh Trúc', 1, 'member'),
(3, 'ThuyTTN', 'Trần Thị Ngọc Thùy', 1, 'member'),
(4, 'ThanhNT', 'Nguyễn Tấn Thành', 1, 'member'),
(5, 'DucTP', 'Trần Phú Đức', 2, 'leader'),
(6, 'LinhKT', 'Ký Tú Linh', 2, 'member'),
(7, 'ThanhNLY', 'Nguyễn Lạc Yến Thanh', 2, 'member'),
(8, 'BinhNT', 'Nguyễn Thanh Bình', 2, 'member'),
(9, 'TruyenLC', 'Lê Công Truyền', 2, 'member'),
(10, 'TrucTTT', 'Tống Thị Thanh Trúc', 3, 'leader'),
(11, 'NhaNTT', 'Nguyễn Thị Thanh Nhã', 3, 'member'),
(12, 'KhangPH', 'Phạm Hồng Khang', 3, 'member'),
(13, 'TriN', 'Nguyễn Trí', 4, 'leader'),
(14, 'BichVTN', 'Vũ Thị Ngọc Bích', 4, 'member'),
(15, 'NgocTT', 'Trầm Thái Ngọc', 4, 'member'),
(16, 'VanVTK', 'Võ Thị Kim Vân', 4, 'member'),
(17, 'ManhT', 'Trần Đức Mạnh', 5, 'leader'),
(18, 'TramNTH', 'Nguyễn Thị Hoài Trâm', 5, 'member'),
(19, 'HuyTV', 'Trần Vương Huy', 5, 'member'),
(20, 'VuLDN', 'Lê Diệp Nguyên Vũ', 5, 'member'),
(21, 'DiepBNH', 'Bạch Ngọc Hồng Điệp', 5, 'member'),
(22, 'TienND', 'Nguyễn Đức Tiến', 6, 'leader'),
(23, 'NamPQ', 'Phạm Quang Nam', 6, 'member'),
(24, 'LamNTP', 'Nguyễn Thị Phương Lam', 1, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `project_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `project_type` int(255) NOT NULL,
  `page_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` int(255) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `work_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `work_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_before` varchar(255) DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `standard_duration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `real_duration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `end` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `performance` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_type` (`project_type`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2637 ;

-- --------------------------------------------------------

--
-- Table structure for table `work_time`
--

CREATE TABLE IF NOT EXISTS `work_time` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `work_time` varchar(255) NOT NULL,
  `work_date` varchar(255) NOT NULL,
  `user` int(255) NOT NULL,
  `delay` varchar(255) NOT NULL,
  `unpaid` varchar(255) NOT NULL,
  `special_paid` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `overtime` varchar(255) NOT NULL,
  `others` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1489 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `source_link`
--
ALTER TABLE `source_link`
  ADD CONSTRAINT `source_link_ibfk_1` FOREIGN KEY (`project_link`) REFERENCES `project_type` (`id`);

--
-- Constraints for table `work`
--
ALTER TABLE `work`
  ADD CONSTRAINT `work_ibfk_1` FOREIGN KEY (`project_type`) REFERENCES `project_type` (`id`),
  ADD CONSTRAINT `work_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Constraints for table `work_time`
--
ALTER TABLE `work_time`
  ADD CONSTRAINT `work_time_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
