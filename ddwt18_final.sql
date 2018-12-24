-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 24, 2018 at 11:13 AM
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
(21, 'haha.jpg', 'images/users/uploads/1/rooms/1/haha.jpg', 1),
(22, 'WhatsApp Image 2018-11-11 at 18.59.30.jpeg', 'images/users/uploads/1/rooms/1/WhatsApp Image 2018-11-11 at 18.59.30.jpeg', 1),
(23, 'haha.jpg', 'images/users/uploads/1/rooms/2/haha.jpg', 2),
(24, 'Screen Shot 2018-10-17 at 18.38.14.png', 'images/users/uploads/1/rooms/2/Screen Shot 2018-10-17 at 18.38.14.png', 2);

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
(17, 'hiuhui', '23', NULL, NULL, '2018-12-17'),
(18, 'jioh', '8', NULL, NULL, '2018-12-17'),
(19, '7632GT', '2', NULL, NULL, '2018-12-17'),
(20, '9712Ta', '1', NULL, NULL, '2018-12-17'),
(21, '9712TA', '1', NULL, NULL, '2018-12-17'),
(22, '9712TA', '1', NULL, NULL, '2018-12-17'),
(23, '9712TA', '1', NULL, NULL, '2018-12-17'),
(24, '9712TA', '1', NULL, NULL, '2018-12-17'),
(25, 'ohuoh', '2', NULL, NULL, '2018-12-17'),
(26, '87868', '2', NULL, NULL, '2018-12-17'),
(27, 'jioj', '3', NULL, NULL, '2018-12-17'),
(28, 'jiojio', '3', NULL, NULL, '2018-12-17'),
(29, 'jkh', '3', NULL, NULL, '2018-12-17'),
(30, 'hiu', '3', NULL, NULL, '2018-12-17'),
(31, 'hiu', '3', NULL, NULL, '2018-12-17'),
(32, 'jouhui', '3', NULL, NULL, '2018-12-17'),
(33, '3768CH', '42', NULL, NULL, '2018-12-17'),
(34, '3768CH', '42', NULL, NULL, '2018-12-17'),
(35, '3768CH', '42', NULL, NULL, '2018-12-17'),
(36, '3768CH', '242', NULL, NULL, '2018-12-17'),
(37, '3768CH', '242', NULL, NULL, '2018-12-17'),
(38, '3768CH', '242', NULL, NULL, '2018-12-17'),
(39, '3768CH', '3', NULL, NULL, '2018-12-17'),
(40, '3768CH', '3', NULL, NULL, '2018-12-17'),
(41, '3768CH', '2', NULL, NULL, '2018-12-17'),
(42, '3768CH', '2', NULL, NULL, '2018-12-17'),
(43, '3768CH', '2', NULL, NULL, '2018-12-17'),
(44, '3768CH', '3', NULL, NULL, '2018-12-17'),
(45, '3232', '3', NULL, NULL, '2018-12-17'),
(46, '3768CH', '3', NULL, NULL, '2018-12-17'),
(47, 'nhhuoi', '90809', NULL, NULL, '2018-12-17'),
(48, '3768CH', '3', NULL, NULL, '2018-12-17'),
(49, '3768CH', '3', NULL, NULL, '2018-12-17'),
(50, 'jiouh', '6', NULL, NULL, '2018-12-18'),
(51, '7632BE', '3', NULL, NULL, '2018-12-18'),
(52, '9712TA', '1', 'Groningen', 'Havenstraat', '2018-12-19'),
(53, '3768CH', '42', 'Soest', 'Braamweg', '2018-12-19'),
(54, '1052VH', '21', NULL, NULL, '2018-12-19'),
(55, '1052VH', '21', NULL, NULL, '2018-12-19'),
(56, '8243Gz', '1', NULL, NULL, '2018-12-19'),
(57, '9712TA', '3', 'Groningen', 'Havenstraat', '2018-12-20'),
(58, '9712TA', '3', 'Groningen', 'Havenstraat', '2018-12-20'),
(59, '123445', '3', NULL, NULL, '2018-12-20'),
(60, '9712TA', '90', NULL, NULL, '2018-12-20'),
(61, '9712TA', '90', NULL, NULL, '2018-12-20'),
(62, '9712TA', '3', NULL, NULL, '2018-12-20');

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
(1, 1, 'Louis\' kamer !!!!!', 'Kamertje op de Havenstraat 1a, gemaakt voor studenten en internationals. \r\n\r\n\r\nfiwojfhowrufhwru\r\nrg894g9h', 'Havenstraat', 1, '9712TA', 'Groningen', 'Hallo', '410.00', 11),
(2, 1, 'Huiskamer in ouder\'s huis', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eu sollicitudin erat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas non arcu vel turpis blandit iaculis. Donec non lacinia arcu. In libero nibh, fringilla nec placerat eu, pretium ut elit. Suspendisse commodo, turpis eu pulvinar tempor, ex urna rhoncus ligula, a porttitor velit lacus et neque. Vestibulum tristique magna at porttitor euismod. Duis tincidunt, nisi et ultricies fringilla, elit quam convallis arcu, vitae tempus est augue nec nisl. Sed quis convallis dui. Vivamus venenatis dui orci. Cras dapibus vel est ac auctor. Maecenas sed elit id nibh iaculis fringilla tincidunt sed risus. Morbi ante magna, vulputate in nibh sed, volutpat pharetra tortor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce aliquam tortor at sagittis dictum.\r\n\r\nVivamus justo felis, viverra mattis pulvinar lobortis, commodo ac quam. Nullam scelerisque, tortor vel iaculis finibus, turpis diam porttitor purus, sit amet semper odio orci eget quam. Nulla rhoncus leo nunc, a dignissim massa hendrerit sed. Nulla ut lacinia eros. Suspendisse quis vulputate ex, quis lacinia justo. Integer non volutpat ex. Duis sodales ipsum ut velit posuere, vitae dictum arcu pretium.\r\n\r\nMauris faucibus, ante vitae euismod ultrices, nisi dui semper leo, non tincidunt magna sem sed tortor. Suspendisse mattis arcu sit amet orci dapibus facilisis. Donec nec eros feugiat, dictum eros a, hendrerit nunc. Morbi egestas purus in interdum euismod. Donec egestas nulla sit amet tellus mollis, vel cursus ante iaculis. Vivamus ex neque, elementum non commodo sed, luctus at metus. Etiam pellentesque lacus lorem, in dignissim diam iaculis in.\r\n\r\n', 'Braamweg', 42, '3768CH', 'Soest', 'optie 2', '450.00', 12),
(3, 3, 'Fred\'s kamertje in Amsterdam', 'Heerlijk plekje aan het water.', 'Appeltjesstraat', 21, '1052VH', 'Amsterdam', 'optie 3', '210.00', 10),
(4, 2, 'Cozy apartment just for 2. Hartje Groningen.', 'Cozy place for 2 people, just in the centre of the city', 'Gedempt Zuiderdiep', 1, '8243Gz', 'Groningen', 'optie 3', '210.00', 50);

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
(2, 'bob', '$2y$10$3qeHEemakDoLRYM9oQdKHOoJtvDizqSuPP/H6edNVc3XxFEo/p.lO', 'Bob', 'de Bruijn', 2, '1994-03-13', 'Bob\r\nBob', 'Informatica', 'NE', 'bob@gmail.com', '0612345678'),
(3, 'mom', '$2y$10$bSN2nXp2UpjnnKRIIClE/eQQOdyFlMeLEGlugXI/MqeaHW7dojzvK', 'mom', 'mom', 1, '1994-03-14', 'mom', 'mom', 'AF', 'mom@gmail.com', 'mom'),
(6, 'bom', '$2y$10$bENZ2ETxdG5goCw.3lono.lXcrW6NiDlylG82r8FA8YfyVdz230ke', 'bom', 'bom', 2, '1994-03-14', 'huih', 'huih', 'SV', 'louis@gmail.com', '90809128'),
(7, 'kok', '$2y$10$vY6wrryoVi2T6Zewv68PveAKOu5mmp4.f646LI9CJzqGIfea2OkKu', 'kok', 'ko', 1, '1994-03-20', 'kok', 'kok', 'AR', 'kok@gmail.com', '908');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `postcode`
--
ALTER TABLE `postcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
