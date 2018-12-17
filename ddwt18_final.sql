-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 17, 2018 at 01:38 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ddwt18_final`
--
CREATE DATABASE IF NOT EXISTS `ddwt18_final` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ddwt18_final`;

-- --------------------------------------------------------

--
-- Table structure for table `postcode`
--

CREATE TABLE `postcode` (
  `id` int(11) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `streetnumber` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postcode`
--

INSERT INTO `postcode` (`id`, `postalcode`, `streetnumber`, `city`, `street`, `date`) VALUES
(7, '9712ta', '1', 'Groningen', 'Havenstraat', '2018-12-17'),
(8, '9712ta', '1', 'Groningen', 'Havenstraat', '2018-12-17'),
(9, '9712ta', '1', 'Groningen', 'Havenstraat', '2018-12-17'),
(10, '7y78', '1', '', '', '2018-12-17'),
(11, 'joij', '2', '', '', '2018-12-17'),
(12, 'w', '5', 'Groningen', 'Havenstraat', '2018-12-17'),
(13, '23r43', '3', NULL, NULL, '2018-12-17'),
(14, 'hiuh', '3', NULL, NULL, '2018-12-17'),
(15, 'hiuh', '3', NULL, NULL, '2018-12-17'),
(16, 'hiuh', '3', NULL, NULL, '2018-12-17'),
(17, 'hiuhui', '23', NULL, NULL, '2018-12-17');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `streetnumber` int(11) NOT NULL,
  `postalcode` varchar(6) NOT NULL,
  `city` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `owner`, `name`, `description`, `street`, `streetnumber`, `postalcode`, `city`, `type`, `price`, `size`) VALUES
(3, 5, 'Chille slaapplek voor internationals', '', 'Havenstraat', 1, '9712TA', 'Groningen', 1, '410.00', 11),
(4, 5, 'Hallo', 'hoiu', 'Havenstraat', 2, '9712TA', 'Groningen', 2, '34.00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `biography` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `language` varchar(2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `role`, `birthdate`, `biography`, `occupation`, `language`, `email`, `phone`) VALUES
(1, 'lol', '$2y$10$KPfsh8m4oivOXjP/QOy0MeAA2th6znSmC9ZDYx32NQvo4VsMg8P7m', 'Louis ', 'de Bruijn', 1, '1994-03-14', 'username: lol\r\nwachtwoord: lol', 'Information Science', 'NL', 'louis@email.com', '06123456789'),
(4, 'bob', '$2y$10$3qeHEemakDoLRYM9oQdKHOoJtvDizqSuPP/H6edNVc3XxFEo/p.lO', 'Bob', 'de Bruijn', 2, '1994-03-13', 'Bob\r\nBob', 'Informatica', 'NE', 'bob@gmail.com', '0612345678'),
(5, 'mom', '$2y$10$bSN2nXp2UpjnnKRIIClE/eQQOdyFlMeLEGlugXI/MqeaHW7dojzvK', 'mom', 'mom', 1, '1994-03-14', 'mom', 'mom', 'AF', 'mom@gmail.com', 'mom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `postcode`
--
ALTER TABLE `postcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `postcode`
--
ALTER TABLE `postcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
