-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 02:55 AM
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
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact_information` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `date_of_hire` date NOT NULL,
  `employment_status` enum('Full-time','Part-time','Contractual') NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `bank_account_details` varchar(255) NOT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name`, `employee_id`, `date_of_birth`, `contact_information`, `position`, `department`, `date_of_hire`, `employment_status`, `salary`, `bank_account_details`, `emergency_contact`, `created_at`, `updated_at`) VALUES
(5, 'Dolly P. dela cruz', 'DPM123', '2003-01-03', 'dolly@gmail.com', 'Instructor III', 'IICT', '2020-03-11', 'Part-time', 15000.00, '123456789', '09123456789', '2024-10-02 01:10:26', '2024-10-05 00:39:18'),
(7, 'Juan Dela Cruz', 'EMP001', '1985-06-12', '09171234567 | juan.dela.cruz@example.com', 'Software Developer', 'IT', '2020-01-15', 'Full-time', 50000.00, 'BDO 00123456789', 'Maria Dela Cruz, 09182345678', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(8, 'Maria Clara', 'EMP002', '1990-09-30', '09182345678 | maria.clara@example.com', 'HR Manager', 'HR', '2018-03-25', 'Full-time', 60000.00, 'BPI 00234567890', 'Pedro Clara, 09193344567', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(9, 'Jose Rizal', 'EMP003', '1992-07-19', '09192345679 | jose.rizal@example.com', 'Accountant', 'Finance', '2019-05-20', 'Full-time', 45000.00, 'Metrobank 00345678901', 'Paciano Rizal, 09194567890', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(10, 'Andres Bonifacio', 'EMP004', '1987-11-30', '09183344556 | andres.bonifacio@example.com', 'Operations Manager', 'Operations', '2017-08-10', 'Full-time', 70000.00, 'Landbank 00456789012', 'Gregoria Bonifacio, 09195678901', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(11, 'Apolinario Mabini', 'EMP005', '1989-07-23', '09171234678 | apolinario.mabini@example.com', 'Legal Advisor', 'Legal', '2021-02-05', 'Full-time', 55000.00, 'BDO 00567890123', 'Eufrosina Mabini, 09196789012', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(12, 'Emilio Aguinaldo', 'EMP006', '1993-03-22', '09173456789 | emilio.aguinaldo@example.com', 'Marketing Specialist', 'Marketing', '2022-06-18', 'Part-time', 30000.00, 'BPI 00678901234', 'Hilaria Aguinaldo, 09197890123', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(13, 'Gabriela Silang', 'EMP007', '1991-08-19', '09178901234 | gabriela.silang@example.com', 'Project Manager', 'Project Management', '2020-10-12', 'Full-time', 65000.00, 'Metrobank 00789012345', 'Diego Silang, 09198901234', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(14, 'Diego Silang', 'EMP008', '1988-05-27', '09174567890 | diego.silang@example.com', 'Sales Executive', 'Sales', '2019-04-30', 'Full-time', 48000.00, 'Landbank 00890123456', 'Gabriela Silang, 09179901234', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(15, 'Melchora Aquino', 'EMP009', '1979-01-06', '09175678901 | melchora.aquino@example.com', 'Admin Officer', 'Administration', '2016-07-11', 'Contractual', 35000.00, 'BDO 00901234567', 'Josefa Aquino, 09191123456', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(16, 'Gregorio Del Pilar', 'EMP010', '1995-12-15', '09176789012 | gregorio.del.pilar@example.com', 'Graphic Designer', 'Creative', '2023-01-22', 'Contractual', 32000.00, 'BPI 01012345678', 'Dolores Del Pilar, 09192234567', '2024-10-04 22:46:51', '2024-10-04 22:46:51'),
(17, 'Antonio Luna', 'EMP011', '1986-04-16', '09181234567 | antonio.luna@example.com', 'Business Analyst', 'Business', '2015-09-10', 'Full-time', 52000.00, 'BDO 01123456789', 'Carmen Luna, 09181234568', '2024-10-05 02:00:00', '2024-10-05 02:00:00'),
(18, 'Josefa Santos', 'EMP012', '1994-02-28', '09182345670 | josefa.santos@example.com', 'Customer Service', 'Customer Support', '2019-07-22', 'Part-time', 28000.00, 'Metrobank 01234567890', 'Manuel Santos, 09182345671', '2024-10-05 02:05:00', '2024-10-05 02:05:00'),
(19, 'Luis Garcia', 'EMP013', '1982-11-11', '09183456781 | luis.garcia@example.com', 'Data Scientist', 'IT', '2021-05-14', 'Full-time', 75000.00, 'BPI 01345678901', 'Ana Garcia, 09183456782', '2024-10-05 02:10:00', '2024-10-05 02:10:00'),
(20, 'Elena Rodriguez', 'EMP014', '1996-07-07', '09184567892 | elena.rodriguez@example.com', 'Recruiter', 'HR', '2022-11-30', 'Full-time', 45000.00, 'Landbank 01456789012', 'Carlos Rodriguez, 09184567893', '2024-10-05 02:15:00', '2024-10-05 02:15:00'),
(21, 'Miguel Torres', 'EMP015', '1983-03-03', '09185678903 | miguel.torres@example.com', 'Finance Analyst', 'Finance', '2016-02-18', 'Full-time', 48000.00, 'BDO 01567890123', 'Lucia Torres, 09185678904', '2024-10-05 02:20:00', '2024-10-05 02:20:00'),
(22, 'Sofia Martinez', 'EMP016', '1997-08-25', '09186789014 | sofia.martinez@example.com', 'Content Writer', 'Marketing', '2023-04-05', 'Part-time', 32000.00, 'BPI 01678901234', 'Diego Martinez, 09186789015', '2024-10-05 02:25:00', '2024-10-05 02:25:00'),
(23, 'Carlos Mendoza', 'EMP017', '1980-12-12', '09187890125 | carlos.mendoza@example.com', 'Operations Coordinator', 'Operations', '2014-06-30', 'Full-time', 55000.00, 'Metrobank 01789012345', 'Maria Mendoza, 09187890126', '2024-10-05 02:30:00', '2024-10-05 02:30:00'),
(24, 'Ana Castillo', 'EMP018', '1995-05-05', '09188901236 | ana.castillo@example.com', 'Quality Assurance', 'IT', '2020-09-17', 'Full-time', 47000.00, 'Landbank 01890123456', 'Pedro Castillo, 09188901237', '2024-10-05 02:35:00', '2024-10-05 02:35:00'),
(25, 'Fernando Alvarez', 'EMP019', '1988-10-10', '09189012347 | fernando.alvarez@example.com', 'UX Designer', 'Creative', '2017-03-08', 'Contractual', 40000.00, 'BDO 01901234567', 'Isabel Alvarez, 09189012348', '2024-10-05 02:40:00', '2024-10-05 02:40:00'),
(26, 'Isabella Fernandez', 'EMP020', '1993-06-06', '09190123458 | isabella.fernandez@example.com', 'Social Media Manager', 'Marketing', '2021-12-12', 'Full-time', 43000.00, 'BPI 02012345678', 'Juan Fernandez, 09190123459', '2024-10-05 02:45:00', '2024-10-05 02:45:00'),
(27, 'juan dela cruz', 'jdc2902200', '2000-02-29', 'dolly@gmail.com', 'programmer I', 'IICT', '2024-10-05', 'Contractual', 15000.00, 'lpb 0123456789', '911', '2024-10-05 00:41:14', '2024-10-05 00:42:05');

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
(1, 'allobang', 'gnabolla@gmail.com', NULL, '$2y$10$ga4FC.PXoBUIqODlTT04Qe7slxkN4gzfpzqzp/MGHpwvrkAqmVW/.', NULL, NULL, NULL, 'admin', NULL, 'Active'),
(2, 'Mark', 'mark@gmail.com', NULL, '$2y$10$oGf2x5.xAPhxYjoV684UZ.NfNx7bkPigHFTWdiwnv3anxSCdqAUoi', NULL, NULL, NULL, 'employee', NULL, 'Active'),
(4, 'Dolly', 'dolly@gmail.com', NULL, '$2y$10$RNFyvUJ89iR7DhmDDQA/meifKCh.KMwnRkLYna/dJ/9oYlBxPS5ci', NULL, NULL, NULL, 'employee', 5, 'Active'),
(5, 'juan dela cruz', 'juan@gmail.com', NULL, '$2y$10$RTDnL5Edw26Fad2VzX/X0uqC7B7UH8YkvROvZMvjXUPzRH0aOjBeC', NULL, NULL, NULL, 'employee', 27, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

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
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

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
