-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 08:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab08`
--
CREATE DATABASE IF NOT EXISTS `lab08` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lab08`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `crn` int(11) NOT NULL,
  `prefix` varchar(4) NOT NULL,
  `number` smallint(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `section` varchar(10) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`crn`, `prefix`, `number`, `title`, `section`, `year`) VALUES
(36661, 'PSYC', 4430, 'PSYCHOLOGY OF MINDFULNESS', '01', '2026'),
(36667, 'PHYS', 2210, 'QUANTUM PHYSICS I', '01', '2026'),
(35831, 'MATH', 2010, 'MULTIVAR CALC & MATRIX ALGEBRA', '09', '2026'),
(37187, 'CSCI', 4600, 'DATA ANALYTICS', '01', '2026');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `crn` int(11) NOT NULL,
  `rin` int(11) NOT NULL,
  `grade` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `crn`, `rin`, `grade`) VALUES
(1, 36661, 123456789, 95),
(2, 37187, 234567890, 88),
(3, 36667, 345678901, 76),
(4, 36667, 123456789, 90),
(5, 35831, 234567890, 92),
(6, 37187, 345678901, 85),
(7, 35831, 456789012, 93),
(8, 37187, 345678901, 89),
(9, 36661, 234567890, 91),
(10, 35831, 123456789, 97);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `rin` int(9) NOT NULL,
  `rcsID` char(7) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `phone` int(10) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`rin`, `rcsID`, `first_name`, `last_name`, `alias`, `phone`, `street`, `city`, `state`, `zip`) VALUES
(123456789, 'syeda3', 'Aliza', 'Syed', 'Aliza', 518000000, '123 Main St', 'Troy', 'NY', '12180'),
(234567890, 'smithj1', 'John', 'Smith', 'Johnny', 518111222, '456 Oak St', 'Albany', 'NY', '12084'),
(345678901, 'kimt6', 'Tina', 'Kim', 'TK', 518222333, '789 Pine St', 'Troy', 'NY', '12180'),
(456789012, 'patelr', 'Ravi', 'Patel', 'Rav', 518333444, '101 Maple St', 'Schenectady', 'NY', '12307');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rin` (`rin`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`rin`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`rin`) REFERENCES `students` (`rin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
