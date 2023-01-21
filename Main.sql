-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2022 at 10:47 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yosiket`
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------

CREATE TABLE `users` (
    `uid` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(10) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `point` int NOT NULL DEFAULT '0',
    `role` varchar(255) NOT NULL DEFAULT 'user',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `redeemcode`;

-- --------------------------------------------------------

CREATE TABLE `redeemcode` (
    `rid` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `code` varchar(255) NOT NULL,
    `count_use` int DEFAULT '0',
    `max_use` int NOT NULL DEFAULT '1',
    `point` int NOT NULL DEFAULT '0',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `redeem_his`;

-- --------------------------------------------------------

CREATE TABLE `redeem_his` (
    `rhid` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uid` varchar(255) NOT NULL,
    `code` varchar(255),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
