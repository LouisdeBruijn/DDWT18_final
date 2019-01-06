-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 27, 2018 at 12:24 PM
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
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `name`, `path`, `room_id`) VALUES
(42, 'room4.JPG', 'images/users/uploads/11/rooms/19/room4.JPG', 19),
(43, 'room1.jpg', 'images/users/uploads/11/rooms/20/room1.jpg', 20),
(44, 'room2.jpg', 'images/users/uploads/11/rooms/20/room2.jpg', 20),
(45, 'room3.jpeg', 'images/users/uploads/11/rooms/20/room3.jpeg', 20);

-- --------------------------------------------------------

--
-- Table structure for table `optin`
--

CREATE TABLE `optin` (
  `tenant` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(163, '9712Ta', '1', 'Groningen', 'Havenstraat', '2018-12-27'),
(164, '9712GZ', '2', 'Groningen', 'Kwinkenplein', '2018-12-27'),
(165, '9734Va', '2', '', '', '2018-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `street` varchar(255) NOT NULL,
  `streetnumber` int(11) NOT NULL,
  `postalcode` varchar(6) NOT NULL,
  `city` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `owner`, `name`, `description`, `street`, `streetnumber`, `postalcode`, `city`, `type`, `price`, `size`) VALUES
(19, 11, 'Student\'s room overlooking water bay area', 'A beautiful and light-written room right between the Noorderplantsoen and the canals. Easy access to supermarkets and a nice and quiet neighbourhood. ', 'Havenstraat', 1, '9712Ta', 'Groningen', 'Student\'s house', '410.00', 10),
(20, 11, 'Beautiful and spacious apartment for international housing', 'This beautiful apartment is well-lit with natural lighting and close-by the nearest supermarkets at the Kwinkenplein. The neighbourhood is attracting lots of international students.', 'Kwinkenplein', 2, '9712GZ', 'Groningen', 'Apartment', '440.00', 20);

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
(11, 'louis_de_bruijn', '$2y$10$.WayG.fNq8R5u.pC9Vlb1ePnstFxqbPaNWispSNQhM59BLZsYl12G', 'Louis', 'de Bruijn', 1, '1994-03-14', 'My name is Louis, I am a 24-year old student of Information Science at the University of Groningen. ', 'Information Science', 'NL', 'l.e.d.de.bruijn@student.rug.nl', '+31615443390'),
(12, 'china_international', '$2y$10$0rNI0nrXztUkwQnsLtzn5eeGGRV8qMq4CqixMOAssyVYCJ15FhoJa', 'Hong', 'Tong', 2, '1998-01-11', 'I spleak English not so good. I come from Beijing and want to study in Groningen but I no find house. ', 'Biochemistry', 'ZH', 'hongtong@china.com', '+31612345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `optin`
--
ALTER TABLE `optin`
  ADD KEY `room` (`room`),
  ADD KEY `tenant` (`tenant`);

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
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `postcode`
--
ALTER TABLE `postcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `optin`
--
ALTER TABLE `optin`
  ADD CONSTRAINT `optin_ibfk_1` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `optin_ibfk_2` FOREIGN KEY (`tenant`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
