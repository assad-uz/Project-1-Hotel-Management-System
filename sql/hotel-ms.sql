-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 03:44 AM
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
-- Database: `hotel-ms`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `users_id`, `room_id`, `booking_date`, `checkin_date`, `checkout_date`, `payment_status`, `total_amount`) VALUES
(1, 12, 1, '2025-08-19 03:43:46', '2025-08-25', '2025-08-27', 'Cash-on', 8900.00);

-- --------------------------------------------------------

--
-- Table structure for table `cancellation`
--

CREATE TABLE `cancellation` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `cancel_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

CREATE TABLE `checkin` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `checkin_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `checkout_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_service`
--

CREATE TABLE `food_service` (
  `id` int(11) NOT NULL,
  `meal_type_id` int(11) DEFAULT NULL,
  `meal_period_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_service`
--

INSERT INTO `food_service` (`id`, `meal_type_id`, `meal_period_id`, `price`) VALUES
(1, 11, 1, 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `payment_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meal_period`
--

CREATE TABLE `meal_period` (
  `id` int(11) NOT NULL,
  `period_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_period`
--

INSERT INTO `meal_period` (`id`, `period_name`, `price`) VALUES
(1, 'Launch', 250.00),
(2, 'Breakfast', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `meal_type`
--

CREATE TABLE `meal_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_type`
--

INSERT INTO `meal_type` (`id`, `type_name`) VALUES
(4, 'BD food'),
(12, 'Korean Food'),
(11, 'Pakistani Food'),
(10, 'Thai Food');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_type`) VALUES
(1, 'admin'),
(2, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_type_price` decimal(10,2) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `room_status` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `service_id`, `service_price`, `room_type_id`, `room_type_price`, `room_number`, `total_price`, `room_status`, `description`) VALUES
(1, 2, 450.00, 1, 4000.00, '1256', 4450.00, 'Available', ''),
(2, 3, 350.00, 3, 5500.00, '236', 5850.00, 'Available', '');

-- --------------------------------------------------------

--
-- Table structure for table `room_service`
--

CREATE TABLE `room_service` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_service`
--

INSERT INTO `room_service` (`id`, `service_name`, `price`) VALUES
(1, 'Laundry', 100.00),
(2, 'WiFi', 200.00),
(3, 'House-keeping', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`id`, `room_name`, `price`) VALUES
(1, 'KING Size', 4000.00),
(3, 'QUEEN Size', 5500.00);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `room_service_id` int(11) DEFAULT NULL,
  `room_service_price` decimal(10,2) NOT NULL,
  `food_service_id` int(11) DEFAULT NULL,
  `food_service_price` decimal(10,2) NOT NULL,
  `total_service_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `room_service_id`, `room_service_price`, `food_service_id`, `food_service_price`, `total_service_price`) VALUES
(1, 3, 0.00, 1, 0.00, 450.00),
(2, 1, 0.00, 1, 0.00, 450.00),
(3, 1, 100.00, 1, 250.00, 350.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `firstname`, `lastname`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 1, 'Assaduzzaman', 'Shaon', 'assad.uz255@gmail.com', '01515-255259', '00008888', '2025-08-15 05:10:30'),
(12, 2, 'Akib', 'Hossain', 'akib1@gmail.com', '01742-453245', '45673154', '2025-08-15 15:59:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `cancellation`
--
ALTER TABLE `cancellation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `food_service`
--
ALTER TABLE `food_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_type_id` (`meal_type_id`),
  ADD KEY `meal_period_id` (`meal_period_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `meal_period`
--
ALTER TABLE `meal_period`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `period_name` (`period_name`);

--
-- Indexes for table `meal_type`
--
ALTER TABLE `meal_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `room_service`
--
ALTER TABLE `room_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_service_id` (`room_service_id`),
  ADD KEY `food_service_id` (`food_service_id`) USING BTREE;

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cancellation`
--
ALTER TABLE `cancellation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkin`
--
ALTER TABLE `checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_service`
--
ALTER TABLE `food_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meal_period`
--
ALTER TABLE `meal_period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meal_type`
--
ALTER TABLE `meal_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room_service`
--
ALTER TABLE `room_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`);

--
-- Constraints for table `cancellation`
--
ALTER TABLE `cancellation`
  ADD CONSTRAINT `cancellation_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `checkin_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `food_service`
--
ALTER TABLE `food_service`
  ADD CONSTRAINT `food_service_ibfk_1` FOREIGN KEY (`meal_type_id`) REFERENCES `meal_type` (`id`),
  ADD CONSTRAINT `food_service_ibfk_2` FOREIGN KEY (`meal_period_id`) REFERENCES `meal_period` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`id`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`room_service_id`) REFERENCES `room_service` (`id`),
  ADD CONSTRAINT `service_ibfk_2` FOREIGN KEY (`food_service_id`) REFERENCES `food_service` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`),
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
