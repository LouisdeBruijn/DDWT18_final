-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 07, 2019 at 02:02 PM
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
(53, '2ndroom1.jpg', 'images/users/uploads/16/rooms/21/2ndroom1.jpg', 21),
(54, '2ndroom2.jpg', 'images/users/uploads/16/rooms/21/2ndroom2.jpg', 21),
(55, 'room1.jpg', 'images/users/uploads/11/rooms/19/room1.jpg', 19),
(56, 'room2.jpg', 'images/users/uploads/11/rooms/19/room2.jpg', 19),
(57, 'room4.JPG', 'images/users/uploads/11/rooms/20/room4.JPG', 20);

-- --------------------------------------------------------

--
-- Table structure for table `optin`
--

CREATE TABLE `optin` (
  `tenant` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `optin`
--

INSERT INTO `optin` (`tenant`, `room`, `message`) VALUES
(13, 21, 'Hi, my name is Anna and I would very much like to rent this beautiful studio with a view!\r\n\r\nGreetings, \r\n\r\nAnna'),
(14, 21, 'I would very much like to live in this beautiful studio!\r\n\r\nGreetings, Dan'),
(14, 20, 'Wow! such a nice kitchen. I really like cooking. \r\n\r\nGreetings, Dan'),
(15, 20, 'Hi, I would like to opt-in.'),
(15, 21, 'Hi! \r\n\r\nWhat a beautiful place, I would love to spend my Bachelor degree here.\r\n\r\nGreetings,\r\n\r\nElli');

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
(20, 11, 'Beautiful and spacious apartment for international housing', 'This beautiful apartment is well-lit with natural lighting and close-by the nearest supermarkets at the Kwinkenplein. The neighbourhood is attracting lots of international students.', 'Kwinkenplein', 2, '9712GZ', 'Groningen', 'Apartment', '440.00', 20),
(21, 16, 'Studio with a view', 'A cosy studio on the 6th floor with a great view', 'Goudenregenstraat', 327, '8922CP', 'Leeuwarden', 'Studio', '350.00', 21);

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
(13, 'anna', '$2y$10$VOHPcsSdu//qDHJxOYxnM.14yvgAgb9YFBlupACMMwd.knWTMPWL.', 'Anna', 'Jung', 2, '1992-11-07', 'I\'m a student looking for an accommodation', 'Art History', 'DE', 'annajung@gmail.com', '0645493649'),
(14, 'dan', '$2y$10$ICEy9OU7oZIEJvSzuhRTueoz4/LVtbXRUH/jm3XF3LXclv71uBacm', 'Daniel', 'Howard', 2, '1989-07-15', 'Hi, I\'m Daniel. I\'m studying Engineering and I\'m looking for an accommodation.', 'Wizard', 'EN', 'dan_howard@gmail.com', '0627031088'),
(15, 'elli', '$2y$10$TXZCa9AYNa.snAfFgqdgT.HM99kB87EuIwd5Qt0X9PmfVQCGfnqa2', 'Elli', 'Virtanen', 2, '1994-12-27', 'Hey I\'m from Finland, I will be studying in the Netherlands for a year.', 'Sociology', 'FI', 'ellivirtanen@hotmail.com', '0622306813'),
(16, 'fenna', '$2y$10$PYhw2BjmFWnao6m11tVOZ.rjft7PmNPPJ6SO/k9ijent7ZShoO64O', 'Fenna', 'Dijkstra', 1, '1990-02-08', 'Hi I\'m Fenna I study psychology.', 'Psychology', 'NL', 'fenna_dijkstra@hotmailc.om', '0681698934');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `postcode`
--
ALTER TABLE `postcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
