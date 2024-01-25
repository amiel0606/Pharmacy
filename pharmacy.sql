-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 07:17 PM
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
  `id` int(11) NOT NULL,
  `custName` varchar(255) NOT NULL,
  `pID` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(255) NOT NULL,
  `datePurchased` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `transID` varchar(255) NOT NULL,
  `dateToPay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `custName`, `pID`, `brandName`, `description`, `qty`, `price`, `category`, `datePurchased`, `status`, `transID`, `dateToPay`) VALUES
(275, '', 22, 'tite', 'tarantado', 1, 222, 'Medicine', '2024-01-25', 'Pending', '2024001250000', '0000-00-00'),
(301, '', 22, 'tite', 'tarantado', 3, 222, 'Medicine', '2024-01-26', 'Cash', '202400126000299', '0000-00-00'),
(302, '', 22, 'tite', 'tarantado', 1, 222, 'Medicine', '2024-01-26', 'Cash', '202400126000302', '0000-00-00'),
(303, '', 41, 'Sample', 'samplee', 1, 30, 'Supply', '2024-01-26', 'Cash', '202400126000302', '0000-00-00'),
(304, '', 22, 'tite', 'tarantado', 1, 222, 'Medicine', '2024-01-26', 'Cash', '202400126000304', '0000-00-00'),
(305, '', 41, 'Sample', 'samplee', 1, 30, 'Supply', '2024-01-26', 'Cash', '202400126000304', '0000-00-00'),
(306, '', 22, 'tite', 'tarantado', 4, 222, 'Medicine', '2024-01-26', 'Cash', '202400126000306', '0000-00-00'),
(307, '', 41, 'Sample', 'samplee', 4, 30, 'Supply', '2024-01-26', 'Cash', '202400126000306', '0000-00-00'),
(308, '', 22, 'tite', 'tarantado', 1, 222, 'Medicine', '2024-01-26', 'Pending', '202400126000308', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `pID` int(11) NOT NULL,
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

INSERT INTO `tbl_products` (`pID`, `category`, `brandName`, `description`, `stock`, `priceBought`, `priceSale`, `exp_date`, `stockAlert`) VALUES
(41, 'Supply', 'Sample', 'samplee', 286, 22, 30, '2024-01-27', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_records`
--

CREATE TABLE `tbl_records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subtotal` float NOT NULL,
  `vat` float NOT NULL,
  `total` float NOT NULL,
  `transID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_records`
--

INSERT INTO `tbl_records` (`id`, `name`, `subtotal`, `vat`, `total`, `transID`) VALUES
(16, 'Amiel Carhyl Lapid', 198.214, 23.7857, 222, '202400125000259');

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
(3, 'amiels', 'Employee', '$2y$10$rEOCkWKVdQGUfMFbKMjILO8/serBWOZxpxeBb..0o698Nou8QmsfW', 'emp', 'empp'),
(4, 'argus', 'Admin', '$2y$10$UZP4EvqmjrYPilACfpIlVuBGAJ8MtwUCup3iaDuZz8S7/8djHGb3K', 'James Argus', 'Baysa'),
(5, 'njay', 'Employee', '$2y$10$mapALmq5GOluNp3pzUCuM.ugAKsAHoFI6uU4.Eo5NASGWiq1etUqa', 'Nino Jay', 'Laurel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`pID`);

--
-- Indexes for table `tbl_records`
--
ALTER TABLE `tbl_records`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_records`
--
ALTER TABLE `tbl_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
