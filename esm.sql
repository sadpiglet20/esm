-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2015 at 10:33 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `esm`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('bde744346f399b34566269ab896849d2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', 1442917033, 'a:8:{s:9:"user_data";s:0:"";s:2:"id";s:1:"6";s:8:"username";s:5:"demo1";s:5:"email";s:22:"sadpiglet230@yahoo.com";s:14:"is_admin_login";b:1;s:10:"company_id";s:1:"2";s:9:"user_type";s:1:"A";s:8:"group_id";s:1:"8";}');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(500) NOT NULL,
  `delete_flag` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `delete_flag`) VALUES
(2, 'cong ty nha dat quan 2', 0),
(6, 'cong ty nha dat quan 9', 0),
(11, 'cong ty nha dat quan 3', 0),
(12, 'teset for edit1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_customer`
--

CREATE TABLE IF NOT EXISTS `m_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `delete_flag` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `m_customer`
--

INSERT INTO `m_customer` (`id`, `customer_name`, `customer_email`, `customer_phone`, `user_id`, `description`, `delete_flag`) VALUES
(1, 'Khách hàng dể thương', 'dethuong@gmail.com', '123456', 10, 'mún kua bé này', 0),
(2, 'Khấu Thị Nguyệt Anh', 'dethuong1@gmail.com', '12345', 10, 'mún kua về làm nữ hoàng', 0),
(3, 'Khấu Thị Nguyệt Anh 1', 'nguyetanh@gmail.com', '123456789', 10, 'chuyên về bất động sản', 0),
(4, 'Khấu Thị Nguyệt Anh', 'nguyetanh1@gmail.com', '1234567', 6, 'chuyên về bất động sản1', 0),
(5, 'Khấu Thị Nguyệt Anh', 'nguyetanh2@gmail.com', '12345678', 6, 'chuyên về bất động sản1', 0),
(6, 'Khấu Thị Nguyệt Anh', 'dethuong6@gmail.com', '1234567777', 6, 'chuyên về bất động sản', 0),
(7, 'Khấu Thị Nguyệt Anh', 'nguyetanh12@gmail.com', '0968304189', 6, 'dể thương', 0),
(8, 'Bùi Ngọc Thành', 'thanh@gmail.com', '4565462', 6, 'dđạp chai', 0),
(9, 'Khấu Nguyệt Anh 2', 'nguyetanh13@gmail.com', '096830418', 6, 'de xuong', 0),
(10, 'Khấu Nguyệt Anh 3', 'nguyetanh14@gmail.com', '096830419', 6, 'de xuong', 0),
(11, 'Khấu Nguyệt Anh 4', 'nguyetanh12@gmail.com', '096830420', 6, 'de xuong', 0),
(12, 'Khấu Nguyệt Anh 5', 'nguyetanhthanh@gmail.com', '096830421', 6, 'de xuong', 0),
(13, 'Khấu Nguyệt Anh 6', 'nguyetanh15@gmail.com', '096830421', 6, 'de xuong', 0),
(14, 'Khấu Nguyệt Anh 7', 'nguyetanh16@gmail.com', '096830423', 6, 'de xuong', 0),
(15, 'Khấu Nguyệt Anh 8', 'nguyetanh17@gmail.com', '096830424', 6, 'de xuong', 0),
(16, 'Bùi Ngọc Thành', 'thanh@gmail.com1', '45654622', 6, 'dđạp chai', 0),
(41, 'Khấu Nguyệt Anh 2', 'nguyetanh13@gmail.com2', '0968304182', 6, 'de xuong', 0),
(42, 'Khấu Nguyệt Anh 4', 'nguyetanh12@gmail.com4', '0968304202', 6, 'de xuong', 0),
(43, 'Khấu Nguyệt Anh 5', 'nguyetanhthanh@gmail.com6', '0968304212', 6, 'de xuong', 0),
(44, 'Khấu Nguyệt Anh 6', 'nguyetanh15@gmail.com7', '0968304212', 6, 'de xuong', 0),
(45, 'Khấu Nguyệt Anh 7', 'nguyetanh16@gmail.com8', '0968304232', 6, 'de xuong', 0),
(46, 'Khấu Nguyệt Anh 8', 'nguyetanh17@gmail.com9', '0968304242', 6, 'de xuong', 0),
(47, 'Khấu Thị Nguyệt Anh 9', 'nguyetanh12@gmail.com', '0968304189', 10, 'dể thương', 0),
(48, 'Bùi Ngọc Thành', 'thanh@gmail.com1', '45654622', 10, 'dđạp chai', 0),
(49, 'Khấu Nguyệt Anh 2', 'nguyetanh13@gmail.com2', '0968304182', 10, 'de xuong', 0),
(50, 'Khấu Nguyệt Anh 3', 'nguyetanh14@gmail.com3', '096830419', 10, 'de xuong', 0),
(51, 'Khấu Nguyệt Anh 4', 'nguyetanh12@gmail.com4', '0968304202', 10, 'de xuong', 0),
(52, 'Khấu Nguyệt Anh 5', 'nguyetanhthanh@gmail.com6', '0968304212', 10, 'de xuong', 0),
(53, 'Khấu Nguyệt Anh 6', 'nguyetanh15@gmail.com7', '0968304212', 10, 'de xuong', 0),
(54, 'Khấu Nguyệt Anh 7', 'nguyetanh16@gmail.com8', '0968304232', 10, 'de xuong', 0),
(55, 'Khấu Nguyệt Anh 8', 'nguyetanh17@gmail.com9', '0968304242', 10, 'de xuong', 0),
(56, 'Khấu Nguyệt Anh 3', 'nguyetanh14@gmail.com3', '0968304196', 5, 'de xuong', 0),
(57, 'Khấu Nguyệt Anh 5', 'nguyetanhthanh@gmail.com67', '09683042126', 5, 'de xuong', 0),
(58, 'Khấu Nguyệt Anh 6', 'nguyetanh15@gmail.com767', '09683042122', 5, 'de xuong', 0),
(59, 'Khấu Nguyệt Anh 7', 'nguyetanh16@gmail.com87', '09683042327', 5, 'de xuong', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_group`
--

CREATE TABLE IF NOT EXISTS `m_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `delete_flag` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `m_group`
--

INSERT INTO `m_group` (`id`, `group_name`, `user_id`, `description`, `delete_flag`) VALUES
(1, 'Bds4', 10, 'chuyên về bất động sản', 0),
(2, 'Bds2', 10, '343243', 0),
(3, 'Bds6', 10, 'chuyên về bất động sản', 0),
(5, 'Bds4', 6, 'chuyên về bất động sản', 0),
(7, 'Bds6', 6, 'chuyên về bất động sản6', 0),
(8, 'Bds135', 6, 'chuyên về bất động sản23424', 0),
(9, 'Bds1353', 6, 'chuyên về bất động sản2342434', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_users`
--

CREATE TABLE IF NOT EXISTS `tbl_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `company_id` int(11) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `user_type` enum('SA','A') DEFAULT 'A' COMMENT 'SA: Super Admin,A: Admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_admin_users`
--

INSERT INTO `tbl_admin_users` (`id`, `username`, `fullname`, `email`, `company_id`, `mobile`, `password`, `block`, `user_type`) VALUES
(4, 'sadpiglet21', 'Bùi Ngọc Thành5', 'thanhbn85@gmail.com', 6, '0964649810', 'e10adc3949ba59abbe56e057f20f883e', 0, 'A'),
(5, 'test2', 'Bùi Ngọc Thành68', 'thanhbn89@gmail.com', 2, '0968304180', '25d55ad283aa400af464c76d713c07ad', 0, 'A'),
(6, 'demo1', 'thanhthanhdemo1', 'sadpiglet230@yahoo.com', 2, '23332434', 'e368b9938746fa090d6afd3628355133', 0, 'A'),
(10, 'demo', NULL, 'abhishek@devzone.co.in', 0, NULL, 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 'SA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms`
--

CREATE TABLE IF NOT EXISTS `tbl_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_cms`
--

INSERT INTO `tbl_cms` (`id`, `label`, `content`) VALUES
(1, 'About Us', '<p style="padding-left: 30px; text-align: left;"><img src="/ark_admin_v2/uploads/images/Water_lilies.jpg" alt="" width="179" height="134" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br /><br />Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.<br /><br />Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.<br /><br />Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus.<br /><br />Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>\r\n<p>&nbsp;</p>'),
(2, 'What We do', '<p>This is the new text.</p>\r\n<p>&nbsp;</p>\r\n<p>ggg</p>\r\n<p>&nbsp;</p>'),
(3, 'Services', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br /><br />Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.<br /><br />Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.<br /><br />Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus.<br /><br />Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>'),
(4, 'Contact Us', '<p>294, Street Name,</p>\r\n<p>Area- Zip Code,</p>\r\n<p>City, State, Country</p>\r\n<p>&nbsp;</p>\r\n<p>phone: 999-999-9999</p>\r\n<p>Email: abc@xyz.com</p>');

-- --------------------------------------------------------

--
-- Table structure for table `t_group_customer`
--

CREATE TABLE IF NOT EXISTS `t_group_customer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_group_customer`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `signup_date` datetime DEFAULT NULL,
  `phone_mobile` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `address_street` varchar(150) DEFAULT NULL,
  `address_city` varchar(100) DEFAULT NULL,
  `address_state` varchar(100) DEFAULT NULL,
  `address_country` varchar(100) DEFAULT NULL,
  `address_postalcode` varchar(20) DEFAULT NULL,
  `deleted` enum('Y','N') DEFAULT 'N',
  `user_status` enum('A','B') DEFAULT 'A' COMMENT 'A: Active; B: Blocked',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=649 ;

--
-- Dumping data for table `users`
--

