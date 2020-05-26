-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 22, 2020 at 04:13 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `idCategory` int(11) NOT NULL,
  `nameCategory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`idCategory`, `nameCategory`) VALUES
(1, 'Spare Parts'),
(2, 'Weapons'),
(3, 'Constructed Suits');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `idProduct` int(11) NOT NULL,
  `nameProduct` varchar(100) NOT NULL,
  `descProduct` longtext NOT NULL,
  `amountProduct` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `dateAdded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`idProduct`, `nameProduct`, `descProduct`, `amountProduct`, `categoryid`, `dateAdded`) VALUES
(8, 'Mark III ', 'One of the most iconic Iron Man suits ever created.', 5, 3, '2020-05-21'),
(9, 'Repulsor Rays ', 'The armor\'s primary energy weapon. A particle beam weapon, standard equipment in the palm gauntlets; can repel physical and energy-based attacks, traveling as a single stream or as a wide-field dispersal.', 10, 2, '2020-05-21'),
(10, 'Plasma', 'For the Plasma Discharge weapon.', 5000, 1, '2020-05-21'),
(11, 'Mark I', 'The First Iron Man suit built in Afghanistan.', 1, 3, '2020-05-21'),
(12, 'Lasers', 'Standard lasers that can be used as weapons or for welding.', 60, 2, '2020-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL,
  `adminUsers` tinyint(1) DEFAULT NULL,
  `nameUsers` tinytext NOT NULL,
  `roleUsers` text,
  `contactUsers` text,
  `picUsers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `emailUsers`, `pwdUsers`, `adminUsers`, `nameUsers`, `roleUsers`, `contactUsers`, `picUsers`) VALUES
(7, 'keviniansimon@gmail.com', '$2y$10$HnYDiiQblnB7gYeimOK5NetfeSocl2vbPlTPCahJOlpwXJKYpedXW', 1, 'Kevin Simon', 'Full-stack developer focusing on PHP, Laravel, JavaScript, HTML, and Sass.', '083-465-1857', 7),
(10, 'test@test.com', '$2y$10$rBt/Q0aS.MM95B8WRQN6IeTxLejzlM4w.3MbijLzfmxzDEupjxtDy', NULL, 'Testing', 'This account is used for testing and for checking to see if the length is an issue', '0834651857', NULL),
(11, 'janis@gmail.com', '$2y$10$Ua4Zg6Or/phRw42EfXB5P.eYojCUWwHPThlX.0ucWWuEm2OjsGK8q', NULL, 'Janis Simon', NULL, NULL, NULL),
(12, 'tony@stark.com', '$2y$10$zDl8fjJkCXY9jsmZTtcHg.gzjNV/fSGPwktG8nvwGVaDzuH.EYHfK', 1, 'Tony Stark', 'CEO // Inventor // Iron Man // Avenger', '1234567891', 12),
(18, 'demo@gmail.com', '$2y$10$Nr1xkvOoG.mtj0HVmgMfeOUPRCk7RG.lnArKeRBmp4BA6LQrczG5i', 0, 'Demo User', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idProduct`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
