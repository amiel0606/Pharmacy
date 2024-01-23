-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2024 at 01:11 PM
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
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `transID` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `pID` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stock` int(255) NOT NULL,
  `priceBought` float NOT NULL,
  `priceSale` float NOT NULL,
  `exp_date` date NOT NULL,
  `stockAlert` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`pID`, `barcode`, `category`, `brandName`, `description`, `stock`, `priceBought`, `priceSale`, `exp_date`, `stockAlert`) VALUES
(18, '1313', 'Supply', 'adwd', 'awdawd', 333, 23, 3232, '2024-01-17', 30),
(19, '123123', '', '123awdaw', 'dawdaw', 2323, 22, 1113, '0000-00-00', 0),
(20, '12312', '', 'qdawd', 'awdawdaw', 2323, 232, 11, '0000-00-00', 0),
(21, '1312', '', 'adaw', 'awda', 333, 22, 222, '0000-00-00', 0),
(22, '13123123123', '', 'tite', 'tarantado', 222, 333, 222, '2024-01-27', 0),
(23, '12313123', 'meds', 'awdawdaw', 'dawwdad', 1113, 333, 3222, '0000-00-00', 0),
(24, '12313123', 'Medicine', 'qdadwda', 'adwawda', 111, 333, 22, '0000-00-00', 0),
(25, '12312312312', 'Supply', 'daawdawd', 'wadawdaw', 333, 222, 2111, '0000-00-00', 0),
(26, '123123123', 'Supply', 'awdawd', 'awdad', 332, 211, 113, '0000-00-00', 0),
(27, '123123123123', 'Supply', 'adawd', 'awdaw', 333, 2221, 111, '0000-00-00', 0),
(28, '123123', 'Supply', 'asdaw', 'awdaw', 33211, 111, 23232, '0000-00-00', 0),
(29, '3213123', 'Supply', 'adwad', 'awdawdwad', 111, 111, 1231, '0000-00-00', 0),
(30, '1313', 'Supply', 'awda', 'wdawdad', 3232, 2111, 3222, '0000-00-00', 0),
(31, '1231', 'Medicine', '3awda', 'dawdaw', 322, 211, 332, '0000-00-00', 0),
(32, '12313', 'Medicine', 'adawd', 'awdaw', 3232, 11, 32, '0000-00-00', 0),
(33, '123123', 'Supply', '2asd', 'awdawd', 232, 321, 11123, '0000-00-00', 0),
(34, '21313', 'Supply', 'adawd', '232ad', 23232, 131, 1313, '0000-00-00', 0),
(35, '123123', 'Supply', 'awda', 'dadad', 1231, 3111, 111, '0000-00-00', 0),
(36, '123123', 'Medicine', 'qwd', 'qeqeq', 113, 232, 113, '0000-00-00', 0),
(37, '1311', 'Medicine', 'adaw', 'awaw', 333, 222, 31231, '2024-01-19', 0),
(38, '1211111', 'Supply', 'awdaw', 'dawdaw', 3232, 3211, 13131, '2024-02-03', 0),
(39, 'heelllo', 'Medicine', 'qqq', 'qqqq', 3232, 111, 23333, '2024-01-27', 0),
(40, '33333333333', 'Supply', 'stock sample', 'samplee', 232, 22, 23, '0000-00-00', 31);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uID` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`uID`, `username`, `role`, `password`, `fName`, `lName`) VALUES
(2, 'amiel', 'Admin', '$2y$10$FbdXDklgj2lMY8P.8g1qj.dnkmayS.rLYLzcybrT31oFdSz4IeX4q', 'Amiel Carhyl', 'Lapid'),
(3, 'amiels', 'Employee', '$2y$10$rEOCkWKVdQGUfMFbKMjILO8/serBWOZxpxeBb..0o698Nou8QmsfW', 'emp', 'empp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`transID`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`pID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
