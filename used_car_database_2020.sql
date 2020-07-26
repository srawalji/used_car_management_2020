-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2020 at 11:54 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `used_car_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `makes`
--

CREATE TABLE `makes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makes`
--

INSERT INTO `makes` (`id`, `name`) VALUES
(1, 'Ford'),
(8, 'Hello'),
(2, 'Honda'),
(3, 'Nissan'),
(7, 'Suburu'),
(5, 'Suzuki'),
(4, 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `make_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `make_id`) VALUES
(1, 'F150', 1),
(2, 'Highlander', 4),
(3, 'Altima', 3),
(4, 'Outback', 7),
(5, 'CR-V', 2),
(6, 'Accord', 2),
(10, 'Focus', 1),
(12, 'Taurus', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(50) NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `last_name`, `first_name`, `email`, `is_admin`, `password`, `registration_date`) VALUES
(1, 'satyam.rawalji', 'Rawalji', 'Satyam', 'srawalji1@gmail.com', 1, 'a6dd8e3848cb0e765429380653f12746a8f9256d', '2019-10-01 20:37:42'),
(27, 'theRock', 'Dwayne', 'Johnson', 'knowyourrole@aol.com', 0, 'theRock', '2020-07-06 22:27:30'),
(36, 'what', 'what', 'what', 'what', 0, 'a110e6b9a361653a042e3f5dfbac4c6105693789', '2020-07-08 08:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `year` int(10) UNSIGNED NOT NULL,
  `vehicle_type_id` int(10) UNSIGNED NOT NULL,
  `vehicle_power_type_id` int(10) UNSIGNED NOT NULL,
  `vin` varchar(20) NOT NULL,
  `dealer_purchased_date` datetime NOT NULL,
  `dealer_purchased_price` double NOT NULL,
  `sold_date` datetime DEFAULT NULL,
  `sold_price` double DEFAULT NULL,
  `additional_cost` double DEFAULT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `model_id`, `year`, `vehicle_type_id`, `vehicle_power_type_id`, `vin`, `dealer_purchased_date`, `dealer_purchased_price`, `sold_date`, `sold_price`, `additional_cost`, `color`) VALUES
(1, 2, 2004, 4, 3, '123847123876', '2019-11-16 00:00:00', 12735, '2019-11-30 00:00:00', 13456, 500, 'Blue'),
(5, 4, 1111, 2, 2, '1111111111111', '1111-11-11 00:00:00', 1111, '0001-01-01 00:00:00', 11111, 111, 'White');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_power_types`
--

CREATE TABLE `vehicle_power_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_power_types`
--

INSERT INTO `vehicle_power_types` (`id`, `name`) VALUES
(1, 'Diesel'),
(2, 'Electric Vehicle'),
(3, 'Gasoline'),
(4, 'Hybrid');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`) VALUES
(1, 'ATV'),
(4, 'Crossover'),
(3, 'Sedan'),
(2, 'SUV'),
(5, 'Truck'),
(6, 'Van'),
(7, 'Wagon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `makes`
--
ALTER TABLE `makes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_UNIQUE_MAKES_NAME` (`name`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_UNIQUE_MODELS_NAME` (`name`),
  ADD KEY `IDX_MODELS_MAKE_ID` (`make_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `IDX_UNIQUE_USERS_USER_NAME` (`user_name`),
  ADD KEY `IDX_USERS_LAST_NAME` (`last_name`),
  ADD KEY `IDX_USERS_FIRST_NAME` (`first_name`),
  ADD KEY `IDX_USERS_EMAIL` (`email`),
  ADD KEY `IDX_USERS_PASSWORD` (`password`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `IDX_UNIQUE_VEHICLES_VIN` (`vin`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `year` (`year`),
  ADD KEY `vehicle_type_id` (`vehicle_type_id`),
  ADD KEY `vehicle_power_type_id` (`vehicle_power_type_id`);

--
-- Indexes for table `vehicle_power_types`
--
ALTER TABLE `vehicle_power_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_VEHICLE_POWER_TYPE_NAME` (`name`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_VEHICLE_TYPE_NAME` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `makes`
--
ALTER TABLE `makes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_power_types`
--
ALTER TABLE `vehicle_power_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `IDX_FR_MODELS_MAKE_ID` FOREIGN KEY (`make_id`) REFERENCES `makes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `IDX_FR_MODELS_ID` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IDX_FR_VEHICLE_POWER_TYPES_ID` FOREIGN KEY (`vehicle_power_type_id`) REFERENCES `vehicle_power_types` (`id`),
  ADD CONSTRAINT `IDX_FR_VEHICLE_TYPES_ID` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
