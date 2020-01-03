-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2020 at 11:19 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `base1`
--

-- --------------------------------------------------------

--
-- Table structure for table `b1_users`
--

CREATE TABLE `b1_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(80) NOT NULL,
  `bday` date NOT NULL,
  `bplace` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telno` varchar(50) NOT NULL,
  `type` enum('s','t','a','d') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `b1_users`
--

INSERT INTO `b1_users` (`id`, `fname`, `lname`, `bday`, `bplace`, `address`, `telno`, `type`) VALUES
(1, 'Ian', 'Koval', '2001-01-01', 'Dublin', '11 Baggot Street, Dublin 2', '087654321', 's'),
(2, 'Alan', 'Koval', '2002-02-02', 'Dublin', '11 Baggot street, Dublin 2', '087654322', 's'),
(3, 'Eva', 'Evans', '2003-03-03', 'Even', '13 Even Street, Even', '09975331', 't'),
(4, 'Iann', 'Kovall', '2011-11-11', 'London', '33 Eden Quay, Dublin 1', '087654666', 's'),
(5, 'Alann', 'Kovall', '2012-12-12', 'London', '43 Eden Close, Dublin 1', '087654444', 's'),
(6, 'Evaa', 'Evanss', '2013-03-03', 'Meath', '22 Meath Street, Meath', '099753222', 't');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b1_users`
--
ALTER TABLE `b1_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b1_users`
--
ALTER TABLE `b1_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
