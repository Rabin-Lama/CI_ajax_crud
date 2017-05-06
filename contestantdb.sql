-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2017 at 08:07 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contestantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `contestant`
--

CREATE TABLE `contestant` (
  `Id` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `DateOfBirth` datetime NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `PhotoUrl` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contestant`
--

INSERT INTO `contestant` (`Id`, `Firstname`, `Lastname`, `DateOfBirth`, `IsActive`, `DistrictId`, `Gender`, `PhotoUrl`, `Address`) VALUES
(141, 'somer', 'name', '2016-12-12 00:00:00', b'1', 1, 'male', 'assets/images/Screenshot (19).png', 'shot'),
(142, 'another', 'name', '2017-05-01 00:00:00', b'0', 1, 'male', 'assets/images/$N$.jpg', 'test'),
(143, 'test', 'name', '2017-05-09 00:00:00', b'1', 1, 'male', 'assets/images/01-02.jpg', 'test addr'),
(144, 'come', 'on', '2017-05-01 00:00:00', b'1', 4, 'female', 'assets/images/1146281-800x600-39.jpg', 'file'),
(145, 'more', 'data', '2017-05-04 00:00:00', b'1', 2, 'female', 'assets/images/42216-bigthumbnail.jpg', 'yha'),
(146, 'yet', 'another', '2017-03-29 00:00:00', b'1', 5, 'female', 'assets/images/1147168-800x600-68.jpg', 'another');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`Id`, `Name`) VALUES
(1, 'Kathmandu'),
(2, 'Bhaktapur'),
(3, 'Butwal'),
(4, 'Lalitpur'),
(5, 'Kavre');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestant`
--
ALTER TABLE `contestant`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `DistrictId` (`DistrictId`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestant`
--
ALTER TABLE `contestant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
