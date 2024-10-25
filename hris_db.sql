-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 12:48 AM
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
(1, 6, '2024-10-12 15:42:40', 'clock_in'),
(2, 1, '2024-10-12 15:42:51', 'clock_in'),
(3, 2, '2024-10-12 15:42:56', 'clock_in'),
(4, 3, '2024-10-12 15:43:01', 'clock_in'),
(5, 4, '2024-10-12 15:43:07', 'clock_in'),
(6, 5, '2024-10-12 15:43:11', 'clock_in'),
(7, 1, '2024-10-17 06:35:46', 'clock_in'),
(8, 2, '2024-10-17 06:35:54', 'clock_in'),
(9, 1, '2024-10-21 02:57:27', 'clock_in'),
(10, 2, '2024-10-21 02:58:13', 'clock_in'),
(11, 2, '2024-10-21 03:01:55', 'clock_in'),
(12, 1, '2024-10-25 13:35:34', 'clock_in'),
(13, 2, '2024-10-25 13:36:35', 'clock_in');

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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name`, `employee_id`, `rfid`, `date_of_birth`, `contact_information`, `position`, `department`, `date_of_hire`, `employment_status`, `salary`, `bank_account_details`, `emergency_contact`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Dolly P. Mamauag', 'DPM123', '0003403864', '2024-10-11', 'dolly@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 15000.00, 'lpb 0123456789', '911', '/uploads/employees/4db02504c5f0df92968e662782980928.jpg', '2024-10-12 15:21:48', '2024-10-12 15:21:48'),
(2, 'Jefrey F. Collado', 'JCFC123', '0003388020', '2024-10-11', 'jefrey@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 25000.00, 'lpb 0123456789', '911', '/uploads/employees/f4c226b14991d5aaeaf49a1b29f2013b.jpg', '2024-10-12 15:22:47', '2024-10-12 15:22:47'),
(3, 'Fredrich B. Manuel', 'FBM123', '0003404962', '2024-10-11', 'fredrich@gmail.com', 'Guard', 'Admin', '2024-10-12', 'Full-time', 10000.00, 'BPI 098776523', '911', '/uploads/employees/ef5d052e6a0891642857918b3476d3ac.jpg', '2024-10-12 15:23:46', '2024-10-12 15:23:46'),
(4, 'Mery J. Mindioro', 'MJM', '0008331680', '2024-10-11', 'mery@gmail.com', 'Teacher1', 'High School', '2024-10-12', 'Full-time', 13000.00, 'lbp 0987654321', '911', '/uploads/employees/ae0aed78ea7e7843c4d5f9d2d7cc5a04.jpg', '2024-10-12 15:24:47', '2024-10-12 15:24:47'),
(5, 'Mike Kevin A. Cerdeñola', 'MAC123', '0003378935', '2024-10-11', 'mike@gmail.com', 'Instructor II', 'Crim', '2024-10-12', 'Full-time', 16000.00, 'lbp 0987654321', '911', '/uploads/employees/4406751701f19608a7d2add5d2d3f0b7.jpg', '2024-10-12 15:25:39', '2024-10-12 15:25:39'),
(6, 'Marlou Jr. C. Infante', 'MCI123', '0003393381', '2024-10-11', 'marlou@gmail.com', 'programmer I', 'IICT', '2024-10-12', 'Full-time', 16000.00, 'lbp 0987654321', '911', '/uploads/employees/32a82b93a0c523d531652a66505e2f00.jpg', '2024-10-12 15:26:28', '2024-10-12 15:26:28');

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
(16, 27, '2024-10-25', '2024-10-31', 'Taylor swift concert', 'Approved', '2024-10-05 00:45:33', '2024-10-05 00:46:12');

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
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$ga4FC.PXoBUIqODlTT04Qe7slxkN4gzfpzqzp/MGHpwvrkAqmVW/.', NULL, NULL, NULL, 'admin', NULL, 'Active');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
