-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2023 at 08:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_by`, `created_time`) VALUES
(1, 'cateName_1\r\n', 1, '2023-09-08 14:44:19'),
(2, 'cateName_2', 1, '2023-09-11 10:21:58'),
(3, 'cateName_3', 1, '2023-09-11 10:22:03'),
(4, 'cateName_4', 1, '2023-09-11 10:22:09'),
(5, 'cateName_5', 1, '2023-09-11 10:22:13'),
(6, 'cateName_6', 1, '2023-09-11 10:22:29'),
(7, 'cateName_7', 1, '2023-09-11 10:22:33'),
(8, 'cateName_8', 1, '2023-09-11 10:22:38'),
(9, 'cateName_9', 1, '2023-09-11 10:22:44'),
(10, 'cateName_10', 1, '2023-09-11 10:22:51'),
(26, 'cateName_11', 1, '2023-09-11 10:30:20'),
(27, 'cateName_12', 1, '2023-09-11 10:30:27'),
(28, 'cateName_13', 1, '2023-09-11 10:31:38'),
(29, 'cateName_14', 1, '2023-09-11 10:31:43'),
(30, 'cateName_15', 1, '2023-09-11 10:31:48');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(15) NOT NULL,
  `cate_id` int(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(14) NOT NULL,
  `created_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `cate_id`, `name`, `description`, `content`, `created_by`, `created_time`) VALUES
(1, 1, 'postName_1', 'this is description', 'content', 1, '2023-09-08 14:50:08'),
(2, 2, 'postName_2', 'desc', 'cont', 1, '2023-09-11 10:24:52'),
(3, 3, 'postName_3', 'desc', 'cont', 1, '2023-09-11 10:25:18'),
(4, 4, 'postName_4', 'desc', 'cont\r\n', 1, '2023-09-11 10:26:25'),
(5, 5, 'postName_5', 'desc', 'content\r\n', 1, '2023-09-11 10:26:41'),
(6, 6, 'postName_6', 'desc', 'ct', 1, '2023-09-11 10:26:54'),
(7, 7, 'postName_7', 'desc', 'ct', 1, '2023-09-11 10:27:14'),
(8, 8, 'postName_8', 'desc', 'ct', 1, '2023-09-11 10:27:28'),
(9, 9, 'postName_9', 'desc', 'ct', 1, '2023-09-11 10:27:42'),
(10, 10, 'postName_10', 'desc', 'ct', 1, '2023-09-11 10:28:03'),
(11, 1, 'postName_11', 'desc', 'ct', 1, '2023-09-11 10:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_time`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '0000-00-00 00:00:00'),
(2, 'user2', '7e58d63b60197ceb55a1c487989a3720', '2023-09-11 10:09:07'),
(3, 'user3', '92877af70a45fd6a2ed7fe81e1236b78', '2023-09-11 10:09:39'),
(4, 'user4', '3f02ebe3d7929b091e3d8ccfde2f3bc6', '2023-09-11 10:14:00'),
(5, 'user5', '0a791842f52a0acfbb3a783378c066b8', '2023-09-11 10:14:00'),
(6, 'user6', 'affec3b64cf90492377a8114c86fc093', '2023-09-11 10:14:00'),
(7, 'user7', '3e0469fb134991f8f75a2760e409c6ed', '2023-09-11 10:14:00'),
(8, 'user8', '7668f673d5669995175ef91b5d171945', '2023-09-11 10:14:00'),
(9, 'user9', '8808a13b854c2563da1a5f6cb2130868', '2023-09-11 10:14:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`,`name`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
