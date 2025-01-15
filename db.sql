-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 08:11 AM
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
-- Database: `hris_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_type` enum('clock_in','clock_out') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `employee_id`, `timestamp`, `event_type`) VALUES
(1, 1, '2025-01-01 23:30:00', 'clock_in'),
(2, 1, '2025-01-02 04:00:00', 'clock_out'),
(3, 1, '2025-01-02 04:30:00', 'clock_in'),
(4, 1, '2025-01-02 09:01:00', 'clock_out'),
(5, 1, '2025-01-02 23:30:00', 'clock_in'),
(6, 1, '2025-01-03 04:00:00', 'clock_out'),
(7, 1, '2025-01-03 04:30:00', 'clock_in'),
(8, 1, '2025-01-03 09:01:00', 'clock_out'),
(9, 1, '2025-01-05 23:30:00', 'clock_in'),
(10, 1, '2025-01-06 04:00:00', 'clock_out'),
(11, 1, '2025-01-06 04:30:00', 'clock_in'),
(12, 1, '2025-01-06 09:01:00', 'clock_out'),
(13, 1, '2025-01-06 23:30:00', 'clock_in'),
(14, 1, '2025-01-07 04:00:00', 'clock_out'),
(15, 1, '2025-01-07 04:30:00', 'clock_in'),
(16, 1, '2025-01-07 09:01:00', 'clock_out'),
(17, 1, '2025-01-07 23:30:00', 'clock_in'),
(18, 1, '2025-01-08 04:00:00', 'clock_out'),
(19, 1, '2025-01-08 04:30:00', 'clock_in'),
(20, 1, '2025-01-08 09:01:00', 'clock_out'),
(21, 1, '2025-01-08 23:30:00', 'clock_in'),
(22, 1, '2025-01-09 04:00:00', 'clock_out'),
(23, 1, '2025-01-09 04:30:00', 'clock_in'),
(24, 1, '2025-01-09 09:01:00', 'clock_out'),
(25, 1, '2025-01-12 23:30:00', 'clock_in'),
(26, 1, '2025-01-13 04:00:00', 'clock_out'),
(27, 1, '2025-01-13 04:30:00', 'clock_in'),
(28, 1, '2025-01-13 09:01:00', 'clock_out'),
(29, 1, '2025-01-13 23:30:00', 'clock_in'),
(30, 1, '2025-01-14 04:00:00', 'clock_out'),
(31, 1, '2025-01-14 04:30:00', 'clock_in'),
(32, 1, '2025-01-14 09:01:00', 'clock_out'),
(33, 1, '2025-01-14 23:30:00', 'clock_in'),
(34, 1, '2025-01-15 04:00:00', 'clock_out'),
(35, 1, '2025-01-15 04:30:00', 'clock_in'),
(36, 1, '2025-01-15 09:01:00', 'clock_out'),
(37, 1, '2025-01-15 23:30:00', 'clock_in'),
(38, 1, '2025-01-16 04:00:00', 'clock_out'),
(39, 1, '2025-01-16 04:30:00', 'clock_in'),
(40, 1, '2025-01-16 09:01:00', 'clock_out'),
(41, 1, '2025-01-16 23:30:00', 'clock_in'),
(42, 1, '2025-01-17 04:00:00', 'clock_out'),
(43, 1, '2025-01-17 04:30:00', 'clock_in'),
(44, 1, '2025-01-17 09:01:00', 'clock_out'),
(45, 1, '2025-01-20 23:30:00', 'clock_in'),
(46, 1, '2025-01-21 04:00:00', 'clock_out'),
(47, 1, '2025-01-21 04:30:00', 'clock_in'),
(48, 1, '2025-01-21 09:01:00', 'clock_out'),
(49, 1, '2025-01-21 23:30:00', 'clock_in'),
(50, 1, '2025-01-22 04:00:00', 'clock_out'),
(51, 1, '2025-01-22 04:30:00', 'clock_in'),
(52, 1, '2025-01-22 09:01:00', 'clock_out'),
(53, 1, '2025-01-22 23:30:00', 'clock_in'),
(54, 1, '2025-01-23 04:00:00', 'clock_out'),
(55, 1, '2025-01-23 04:30:00', 'clock_in'),
(56, 1, '2025-01-23 09:01:00', 'clock_out'),
(57, 1, '2025-01-23 23:30:00', 'clock_in'),
(58, 1, '2025-01-24 04:00:00', 'clock_out'),
(59, 1, '2025-01-24 04:30:00', 'clock_in'),
(60, 1, '2025-01-24 09:01:00', 'clock_out'),
(61, 1, '2025-01-26 23:30:00', 'clock_in'),
(62, 1, '2025-01-27 04:00:00', 'clock_out'),
(63, 1, '2025-01-27 04:30:00', 'clock_in'),
(64, 1, '2025-01-27 09:01:00', 'clock_out'),
(65, 1, '2025-01-28 23:30:00', 'clock_in'),
(66, 1, '2025-01-29 04:00:00', 'clock_out'),
(67, 1, '2025-01-29 04:30:00', 'clock_in'),
(68, 1, '2025-01-29 09:01:00', 'clock_out'),
(69, 1, '2025-01-29 23:30:00', 'clock_in'),
(70, 1, '2025-01-30 04:00:00', 'clock_out'),
(71, 1, '2025-01-30 04:30:00', 'clock_in'),
(72, 1, '2025-01-30 09:01:00', 'clock_out'),
(73, 1, '2025-01-30 23:30:00', 'clock_in'),
(74, 1, '2025-01-31 04:00:00', 'clock_out'),
(75, 1, '2025-01-31 04:30:00', 'clock_in'),
(76, 1, '2025-01-31 09:01:00', 'clock_out'),
(77, 3, '2025-02-04 03:01:40', 'clock_in'),
(78, 3, '2025-02-04 03:12:31', 'clock_out');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `rfid` varchar(100) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `contact_information` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `date_of_hire` date NOT NULL,
  `employment_status` enum('Full-time','Part-time','Contractual') NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `bank_account_details` varchar(255) NOT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pay_type` enum('Monthly','Daily','Hourly') NOT NULL DEFAULT 'Monthly'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name`, `employee_id`, `rfid`, `date_of_birth`, `contact_information`, `position`, `department`, `date_of_hire`, `employment_status`, `salary`, `bank_account_details`, `emergency_contact`, `image_path`, `created_at`, `updated_at`, `pay_type`) VALUES
(1, 'Dolly P. Mamauag', 'DPM123', '0003403864', '2024-10-11', 'dolly@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 15000.00, 'lpb 0123456789', '911', '/uploads/employees/4db02504c5f0df92968e662782980928.jpg', '2024-10-12 15:21:48', '2024-10-12 15:21:48', 'Monthly'),
(2, 'Jefrey F. Collado', 'JCFC123', '0003388020', '2024-10-11', 'jefrey@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 25000.00, 'lpb 0123456789', '911', '/uploads/employees/f4c226b14991d5aaeaf49a1b29f2013b.jpg', '2024-10-12 15:22:47', '2024-10-12 15:22:47', 'Monthly'),
(3, 'Fredrich B. Manuel', 'FBM123', '0003404962', '2024-10-11', 'fredrich@gmail.com', 'Guard', 'Admin', '2024-10-12', 'Full-time', 10000.00, 'BPI 098776523', '911', '/uploads/employees/ef5d052e6a0891642857918b3476d3ac.jpg', '2024-10-12 15:23:46', '2024-10-12 15:23:46', 'Monthly'),
(4, 'Mery J. Mindioro', 'MJM', '0008331680', '2024-10-11', 'mery@gmail.com', 'Teacher1', 'High School', '2024-10-12', 'Full-time', 13000.00, 'lbp 0987654321', '911', '/uploads/employees/ae0aed78ea7e7843c4d5f9d2d7cc5a04.jpg', '2024-10-12 15:24:47', '2024-10-12 15:24:47', 'Monthly'),
(5, 'Mike Kevin A. Cerdeñola', 'MAC123', '0003378935', '2024-10-11', 'mike@gmail.com', 'Instructor II', 'Crim', '2024-10-12', 'Full-time', 16000.00, 'lbp 0987654321', '911', '/uploads/employees/4406751701f19608a7d2add5d2d3f0b7.jpg', '2024-10-12 15:25:39', '2024-10-12 15:25:39', 'Monthly'),
(6, 'Marlou Jr. C. Infante', 'MCI123', '52345234\\', '2024-10-11', 'marlou@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 16000.00, 'lbp 0987654321', '911', '/uploads/employees/32a82b93a0c523d531652a66505e2f00.jpg', '2024-10-12 15:26:28', '2024-10-26 14:12:25', 'Monthly'),
(7, 'Franklin Salacup', 'FS', '123456', '1992-07-03', 'franklin@gmail.com', 'Custodian', 'Admin', '2022-02-03', 'Full-time', 500.00, 'lpb 0123456789', '911', '/uploads/employees/f7137aa1a373a1d4c144eca3f0bea42b.jpg', '2025-01-03 04:08:34', '2025-01-03 04:08:34', 'Daily');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '2024-10-10', '2024-10-17', 'marrying my love of my life', 'Rejected', '2024-10-02 20:41:32', '2024-10-02 20:42:43'),
(2, 5, '2024-10-04', '2024-10-10', 'asdf', 'Approved', '2024-10-02 20:51:08', '2024-10-03 07:01:46'),
(3, 5, '2024-10-26', '2024-10-31', 'asfas', 'Pending', '2024-10-02 20:52:33', '2024-10-02 20:52:33'),
(4, 5, '2024-10-11', '2024-10-26', 'asf', 'Pending', '2024-10-02 20:54:25', '2024-10-02 20:54:25'),
(5, 5, '2024-10-12', '2024-10-17', 'asdasd', 'Pending', '2024-10-02 20:56:11', '2024-10-02 20:56:11'),
(6, 7, '2024-11-01', '2024-11-05', 'Family vacation', 'Approved', '2024-10-05 03:00:00', '2024-10-05 03:00:00'),
(7, 8, '2024-11-10', '2024-11-15', 'Medical leave', 'Pending', '2024-10-05 03:05:00', '2024-10-05 03:05:00'),
(8, 9, '2024-12-01', '2024-12-10', 'Annual leave', 'Approved', '2024-10-05 03:10:00', '2024-10-05 03:10:00'),
(9, 10, '2024-12-15', '2024-12-20', 'Personal reasons', 'Rejected', '2024-10-05 03:15:00', '2024-10-05 03:15:00'),
(10, 11, '2025-01-05', '2025-01-15', 'Travel', 'Pending', '2024-10-05 03:20:00', '2024-10-05 03:20:00'),
(11, 12, '2025-01-20', '2025-01-25', 'Conference', 'Approved', '2024-10-05 03:25:00', '2024-10-05 03:25:00'),
(12, 13, '2025-02-10', '2025-02-20', 'Relocation', 'Pending', '2024-10-05 03:30:00', '2024-10-05 03:30:00'),
(13, 14, '2025-02-25', '2025-03-05', 'Training', 'Approved', '2024-10-05 03:35:00', '2024-10-05 03:35:00'),
(14, 15, '2025-03-10', '2025-03-15', 'Family event', 'Rejected', '2024-10-05 03:40:00', '2024-10-05 03:40:00'),
(15, 16, '2025-03-20', '2025-03-25', 'Medical leave', 'Approved', '2024-10-05 03:45:00', '2024-10-05 03:45:00'),
(16, 27, '2024-10-25', '2024-10-31', 'Taylor swift concert', 'Approved', '2024-10-05 00:45:33', '2024-10-05 00:46:12'),
(17, 3, '2025-01-04', '2025-01-10', 'kasal', 'Rejected', '2025-01-04 03:22:29', '2025-01-04 03:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_days` int(11) NOT NULL DEFAULT 0,
  `total_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `gross_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `late_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_lates` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payslips`
--

INSERT INTO `payslips` (`id`, `employee_id`, `period_start`, `period_end`, `total_days`, `total_hours`, `gross_pay`, `net_pay`, `deductions`, `created_at`, `late_deductions`, `total_lates`) VALUES
(1, 1, '2025-01-01', '2025-01-31', 19, 171.38, 10961.54, 10961.54, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(2, 2, '2025-01-01', '2025-01-31', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(3, 3, '2025-01-01', '2025-01-31', 1, 0.18, 384.62, 336.54, 48.08, '2025-01-04 03:13:18', 48.08, 1),
(4, 4, '2025-01-01', '2025-01-31', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(5, 5, '2025-01-01', '2025-01-31', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(6, 6, '2025-01-01', '2025-01-31', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(7, 7, '2025-01-01', '2025-01-31', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:13:18', 0.00, 0),
(8, 1, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(9, 2, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(10, 3, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(11, 4, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(12, 5, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(13, 6, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(14, 7, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:18:20', 0.00, 0),
(15, 1, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0),
(16, 2, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0),
(17, 3, '2025-02-01', '2025-02-28', 1, 0.18, 384.62, 336.54, 48.08, '2025-01-04 03:19:03', 48.08, 1),
(18, 4, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0),
(19, 5, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0),
(20, 6, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0),
(21, 7, '2025-02-01', '2025-02-28', 0, 0.00, 0.00, 0.00, 0.00, '2025-01-04 03:19:03', 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','employee') NOT NULL DEFAULT 'employee',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Active','Disabled') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `employee_id`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$ga4FC.PXoBUIqODlTT04Qe7slxkN4gzfpzqzp/MGHpwvrkAqmVW/.', NULL, NULL, NULL, 'admin', NULL, 'Active'),
(7, 'Dolly P. Mamauag', 'dolly@gmail.com', NULL, '$2y$10$1H/3Iqi.ngn4h4YvSKGvfOK1PHs4eckkub60t7CXp1W3jDwJRMaWm', NULL, NULL, NULL, 'employee', 1, 'Active'),
(8, 'Fredrich B. Manuel', 'fredrich@gmail.com', NULL, '$2y$10$1lVYxBg3xek6CXe05NXbE.8zhPYHDSAbNNaXwJjNYimfc8K5Xbx2m', NULL, NULL, NULL, 'employee', 3, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attendance_logs_employee` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `rfid` (`rfid`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_leave_requests_employee` (`employee_id`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD CONSTRAINT `fk_attendance_logs_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `fk_leave_requests_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `fk_payslips_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
