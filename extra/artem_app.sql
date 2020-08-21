-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2020 at 08:44 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artem_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkins`
--

DROP TABLE IF EXISTS `checkins`;
CREATE TABLE `checkins` (
  `id` int(7) NOT NULL,
  `userid` int(5) NOT NULL,
  `eventid` int(5) NOT NULL,
  `points` int(3) NOT NULL,
  `dtAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(5) NOT NULL,
  `name` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `points` int(5) NOT NULL,
  `dtStart` varchar(18) NOT NULL,
  `dtEnd` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `events`
--

TRUNCATE TABLE `events`;
--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `hash`, `points`, `dtStart`, `dtEnd`) VALUES
(1, 'Test Event1', '123', 50, '2020-01-22', '2020-01-25'),
(2, 'Test Event2', '1234', 25, '2019-01-22', '2019-01-22'),
(3, 'Test Event3', '1235', 15, '2020-01-22', '2021-01-22'),
(4, 'Test Event 4', '9609d19b09bae9b92d968f0b58d9a2c9', 50, '2019-01-23', '2019-01-23'),
(5, 'Test Event 5', 'f31a4a4350519825fc6dae61b346b743', 1, '2020-01-01', '2021-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

DROP TABLE IF EXISTS `institutes`;
CREATE TABLE `institutes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `institutes`
--

TRUNCATE TABLE `institutes`;
--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`) VALUES
(1, 'ИФНиТ'),
(2, 'ИПММ'),
(3, 'ИКНТ'),
(4, 'ИММИТ'),
(5, 'ИСИ');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(2) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `roles`
--

TRUNCATE TABLE `roles`;
--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Волонтер'),
(2, 'Организатор');

-- --------------------------------------------------------

--
-- Table structure for table `roles_binds`
--

DROP TABLE IF EXISTS `roles_binds`;
CREATE TABLE `roles_binds` (
  `id` int(5) NOT NULL,
  `userid` int(5) NOT NULL,
  `eventid` int(5) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role_links`
--

DROP TABLE IF EXISTS `role_links`;
CREATE TABLE `role_links` (
  `id` int(5) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `role_set` int(2) NOT NULL,
  `eventid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `login` varchar(32) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(48) NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT '0',
  `regTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatarID` varchar(64) DEFAULT '0',
  `instituteID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_binds`
--
ALTER TABLE `roles_binds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_links`
--
ALTER TABLE `role_links`
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
-- AUTO_INCREMENT for table `checkins`
--
ALTER TABLE `checkins`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles_binds`
--
ALTER TABLE `roles_binds`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_links`
--
ALTER TABLE `role_links`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
