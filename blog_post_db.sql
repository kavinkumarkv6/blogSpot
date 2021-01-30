-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 30, 2021 at 11:06 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_post_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bp_like_history`
--

CREATE TABLE `bp_like_history` (
  `blh_like_id` int(11) NOT NULL,
  `blh_like_post_id` int(11) DEFAULT NULL,
  `blh_like_user_id` int(11) DEFAULT NULL,
  `blh_liked_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bp_post_list`
--

CREATE TABLE `bp_post_list` (
  `bpl_post_id` int(11) NOT NULL,
  `bpl_post_title` varchar(200) DEFAULT NULL,
  `bpl_post_description` varchar(400) DEFAULT NULL,
  `bpl_post_image_name` varchar(200) DEFAULT NULL,
  `bpl_post_likes` int(11) NOT NULL DEFAULT 0,
  `bpl_post_created_by` int(11) DEFAULT NULL,
  `bpl_post_created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `bpl_post_updated_on` datetime DEFAULT NULL,
  `bpl_post_status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bp_post_list`
--

INSERT INTO `bp_post_list` (`bpl_post_id`, `bpl_post_title`, `bpl_post_description`, `bpl_post_image_name`, `bpl_post_likes`, `bpl_post_created_by`, `bpl_post_created_on`, `bpl_post_updated_on`, `bpl_post_status`) VALUES
(1, 'Learn Web Development', 'we can learn web development using w3schools ', '2021_01_30_11_58_15.jpg', 0, 1, '2021-01-30 11:58:15', NULL, 'active'),
(2, 'Learn Html', 'Hytper text markup language', '2021_01_30_12_24_00.png', 0, 1, '2021-01-30 12:24:00', NULL, 'active'),
(3, 'learn php', 'personal homepage or hypertext preprocessor', '2021_01_30_12_24_43.png', 0, 1, '2021-01-30 12:24:43', NULL, 'active'),
(4, 'learn Artificiyal intelligence', 'ai learning ', '2021_01_30_12_25_29.png', 0, 1, '2021-01-30 12:25:29', NULL, 'active'),
(5, 'interview preparation', 'you need to prepare for your interview', '2021_01_30_12_26_08.png', 0, 1, '2021-01-30 12:26:08', NULL, 'active'),
(6, 'learn logic', 'logical thing is very important for programming', '2021_01_30_12_26_53.png', 0, 1, '2021-01-30 12:26:53', NULL, 'active'),
(7, 'kalees history', 'if you want to know my history then check this', '2021_01_30_13_35_41.jpg', 0, 2, '2021-01-30 13:35:41', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bp_user_register`
--

CREATE TABLE `bp_user_register` (
  `bur_user_register_id` int(11) NOT NULL,
  `bur_user_name` varchar(100) DEFAULT NULL,
  `bur_user_email` varchar(200) DEFAULT NULL,
  `bur_user_mobile_number` bigint(20) DEFAULT NULL,
  `bur_user_password` varchar(200) DEFAULT NULL,
  `bur_user_type` varchar(20) NOT NULL DEFAULT 'user',
  `bur_user_status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bp_user_register`
--

INSERT INTO `bp_user_register` (`bur_user_register_id`, `bur_user_name`, `bur_user_email`, `bur_user_mobile_number`, `bur_user_password`, `bur_user_type`, `bur_user_status`) VALUES
(1, 'kavin', 'kavinkumarkv6@gmail.com', 6383086229, 'BKWQNQ2D', 'admin', 'active'),
(2, 'kalees', 'kaleeswaranslcs@gmail.com', 9003191921, 'Vv/KbVQ=', 'user', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bp_like_history`
--
ALTER TABLE `bp_like_history`
  ADD PRIMARY KEY (`blh_like_id`);

--
-- Indexes for table `bp_post_list`
--
ALTER TABLE `bp_post_list`
  ADD PRIMARY KEY (`bpl_post_id`);

--
-- Indexes for table `bp_user_register`
--
ALTER TABLE `bp_user_register`
  ADD PRIMARY KEY (`bur_user_register_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bp_like_history`
--
ALTER TABLE `bp_like_history`
  MODIFY `blh_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bp_post_list`
--
ALTER TABLE `bp_post_list`
  MODIFY `bpl_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bp_user_register`
--
ALTER TABLE `bp_user_register`
  MODIFY `bur_user_register_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
