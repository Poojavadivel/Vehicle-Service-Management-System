-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 04:39 PM
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
-- Database: `vehicle_service_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`) VALUES
(1, 'shishi', 'ma', 'vadivelpooja68@gmail.com', '7594681302');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `service_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `requested_date` date NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `payment_status` varchar(50) DEFAULT 'Not Paid',
  `amount_due` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`service_id`, `customer_id`, `vehicle_id`, `staff_id`, `requested_date`, `service_type`, `status`, `payment_status`, `amount_due`) VALUES
(1, 1, 2, 1, '0000-00-00', 'Radiator Service', 'Pending', 'Pending', 9512.00);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `expertise` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `position`, `phone_number`, `password`, `expertise`) VALUES
(1, 'Rahul Sharma', 'Mechanic', '9876543210', 'rahul@123', 'Engine Repair'),
(2, 'Priya Verma', 'Technician', '9823456789', 'priya@123', 'Electrical Systems'),
(3, 'Amit Das', 'Supervisor', '9812345678', 'amit@123', 'Team Management'),
(4, 'Neha Gupta', 'Service Advisor', '9845671230', 'neha@123', 'Customer Handling'),
(5, 'Vikram Singh', 'Electrician', '9798765432', 'vikram@123', 'Battery & Wiring'),
(6, 'Anjali Rao', 'Mechanic', '9734567890', 'anjali@123', 'Brake Systems'),
(7, 'Siddharth Roy', 'Technician', '9687654321', 'sid@123', 'Diagnostics');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `service_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `customer_id`, `model`, `company_name`, `vehicle_number`, `service_type`) VALUES
(1, 1, 'taar 12', 'taar', 'TN-09-8895', 'Radiator Service'),
(2, 1, 'taar 12', 'taar', 'TN-09-8895', 'Radiator Service');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service_request` (`service_id`);

--
-- Constraints for table `service_request`
--
ALTER TABLE `service_request`
  ADD CONSTRAINT `service_request_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `service_request_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`),
  ADD CONSTRAINT `service_request_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
