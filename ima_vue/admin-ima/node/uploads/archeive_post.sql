-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 08:12 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ima_laravel_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `archeive_post`
--

CREATE TABLE `archeive_post` (
  `id` int(250) NOT NULL,
  `post_id` int(45) NOT NULL,
  `post_title` varchar(250) CHARACTER SET latin1 NOT NULL,
  `post_released` varchar(250) CHARACTER SET latin1 NOT NULL,
  `post_cms` longtext CHARACTER SET utf8 NOT NULL,
  `post_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `post_heading` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `updated_date1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_date` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archeive_post`
--
ALTER TABLE `archeive_post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archeive_post`
--
ALTER TABLE `archeive_post`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
