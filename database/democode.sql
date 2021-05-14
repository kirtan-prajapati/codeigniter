-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2021 at 08:58 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `democode`
--

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `value`) VALUES
(10, 'size', 'large'),
(11, '', ''),
(12, '', ''),
(13, 'color', 'red'),
(14, 'color', 'red'),
(15, 'size', 'large'),
(16, 'color', 'Blue'),
(17, 'size', 'small'),
(23, 'brand', 'LG');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `description` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `price`, `description`) VALUES
(54, 'Watch', 'DFD343', '126.00', 'TEST'),
(55, '', '', '', ''),
(56, 'sports 1', '333433', '123.21', 'tesstt'),
(57, 'sports', '343343', '343.00', 'test'),
(58, 'sports 132', '333433', '123.21', 'tesstt');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE `product_attribute` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_attribute`
--

INSERT INTO `product_attribute` (`id`, `product_id`, `attribute_id`) VALUES
(5, 55, 11),
(6, 55, 12),
(7, 56, 13),
(8, 58, 14),
(9, 58, 15),
(10, 54, 16),
(11, 54, 17),
(15, 54, 23);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`) VALUES
(12, 56, 'Screenshot_(2).png'),
(22, 54, 'Screenshot_(4).png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('1','2') NOT NULL COMMENT '1:  Admin\r\n2: Normal User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(7, 'John', 'hello@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(8, 'Romit', 'romit@test.com', 'e10adc3949ba59abbe56e057f20f883e', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
