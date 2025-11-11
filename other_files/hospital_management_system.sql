-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2025 at 06:38 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `admit_date` datetime DEFAULT current_timestamp(),
  `reason` text DEFAULT NULL,
  `status` enum('admitted','discharged') DEFAULT 'admitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` enum('pending','approved','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `bed_number` varchar(20) DEFAULT NULL,
  `status` enum('available','occupied','cleaning') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `admission_id` bigint(20) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `tax_amount` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `net_amount` decimal(12,2) DEFAULT NULL,
  `status` enum('unpaid','paid','cancelled') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `billing_items`
--

CREATE TABLE `billing_items` (
  `id` bigint(20) NOT NULL,
  `bill_id` bigint(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discharge_summaries`
--

CREATE TABLE `discharge_summaries` (
  `id` bigint(20) NOT NULL,
  `admission_id` bigint(20) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `discharge_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `display_name` varchar(150) DEFAULT NULL,
  `photo_url` varchar(1000) DEFAULT NULL,
  `specialty` varchar(150) DEFAULT NULL,
  `sub_specialty` varchar(150) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `years_experience` smallint(6) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `medical_license_no` varchar(100) DEFAULT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT 0.00,
  `available_days` varchar(100) DEFAULT NULL,
  `available_time_from` time DEFAULT NULL,
  `available_time_to` time DEFAULT NULL,
  `languages_spoken` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `phone_verified` tinyint(1) DEFAULT 0,
  `is_consultation_online` tinyint(1) DEFAULT 0,
  `ratings_avg` decimal(3,2) DEFAULT 0.00,
  `ratings_count` int(11) DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `two_fa_enabled` tinyint(1) DEFAULT 0,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_rounds`
--

CREATE TABLE `doctor_rounds` (
  `id` bigint(20) NOT NULL,
  `admission_id` bigint(20) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_claims`
--

CREATE TABLE `insurance_claims` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `bill_id` bigint(20) DEFAULT NULL,
  `claim_status` enum('submitted','approved','rejected') DEFAULT 'submitted',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_tests`
--

CREATE TABLE `lab_tests` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_results`
--

CREATE TABLE `lab_test_results` (
  `id` bigint(20) NOT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `result_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result_json`)),
  `report_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nurse_notes`
--

CREATE TABLE `nurse_notes` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `photo_url` varchar(1000) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `height_cm` decimal(5,2) DEFAULT NULL,
  `weight_kg` decimal(5,2) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `chronic_conditions` text DEFAULT NULL,
  `medications_current` text DEFAULT NULL,
  `insurance_provider` varchar(150) DEFAULT NULL,
  `insurance_number` varchar(100) DEFAULT NULL,
  `emergency_contact_name` varchar(150) DEFAULT NULL,
  `emergency_contact_phone` varchar(30) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `bill_id` bigint(20) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `method` enum('cash','card','upi','insurance') DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` bigint(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE `prescription_items` (
  `id` bigint(20) NOT NULL,
  `prescription_id` bigint(20) NOT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `dosage` varchar(100) DEFAULT NULL,
  `frequency` varchar(100) DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `instructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radiology_reports`
--

CREATE TABLE `radiology_reports` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `type` varchar(150) DEFAULT NULL,
  `report_url` varchar(500) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'doctor'),
(3, 'patient'),
(4, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module` varchar(100) NOT NULL,
  `can_view` tinyint(1) DEFAULT 1,
  `can_add` tinyint(1) DEFAULT 0,
  `can_edit` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `module`, `can_view`, `can_add`, `can_edit`, `can_delete`) VALUES
(1, 1, 'dashboard', 1, 1, 1, 1),
(2, 1, 'doctors', 1, 1, 1, 1),
(3, 1, 'patients', 1, 1, 1, 1),
(4, 1, 'staff', 1, 1, 1, 1),
(5, 1, 'appointments', 1, 1, 1, 1),
(6, 1, 'billing', 1, 1, 1, 1),
(7, 2, 'dashboard', 1, 0, 0, 0),
(8, 2, 'appointments', 1, 0, 1, 0),
(9, 2, 'patients', 1, 0, 0, 0),
(10, 2, 'prescriptions', 1, 1, 1, 0),
(11, 2, 'vitals', 1, 1, 1, 0),
(12, 3, 'dashboard', 1, 0, 0, 0),
(13, 3, 'appointments', 1, 0, 0, 0),
(14, 3, 'prescriptions', 1, 0, 0, 0),
(15, 3, 'billing', 1, 0, 0, 0),
(16, 4, 'patients', 1, 1, 1, 0),
(17, 4, 'appointments', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `room_type` enum('general','semi_private','private','icu') DEFAULT NULL,
  `charges` decimal(10,2) DEFAULT NULL,
  `status` enum('available','occupied','maintenance') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `designation` varchar(150) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `shift` enum('morning','evening','night','rotational') DEFAULT 'rotational',
  `join_date` date DEFAULT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `phone_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` enum('active','inactive','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE `vitals` (
  `id` bigint(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `bp` varchar(20) DEFAULT NULL,
  `pulse` int(11) DEFAULT NULL,
  `spo2` int(11) DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `sugar_level` decimal(5,2) DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `bed_id` (`bed_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `admission_id` (`admission_id`);

--
-- Indexes for table `billing_items`
--
ALTER TABLE `billing_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discharge_summaries`
--
ALTER TABLE `discharge_summaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_id` (`admission_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `medical_license_no` (`medical_license_no`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `specialty` (`specialty`),
  ADD KEY `medical_license_no_2` (`medical_license_no`);

--
-- Indexes for table `doctor_rounds`
--
ALTER TABLE `doctor_rounds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_id` (`admission_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `insurance_claims`
--
ALTER TABLE `insurance_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `lab_tests`
--
ALTER TABLE `lab_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_test_results`
--
ALTER TABLE `lab_test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `blood_group` (`blood_group`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Indexes for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `designation` (`designation`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_items`
--
ALTER TABLE `billing_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discharge_summaries`
--
ALTER TABLE `discharge_summaries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_rounds`
--
ALTER TABLE `doctor_rounds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_claims`
--
ALTER TABLE `insurance_claims`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_test_results`
--
ALTER TABLE `lab_test_results`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `admissions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `admissions_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `admissions_ibfk_4` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`);

--
-- Constraints for table `billing_items`
--
ALTER TABLE `billing_items`
  ADD CONSTRAINT `billing_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `billing` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discharge_summaries`
--
ALTER TABLE `discharge_summaries`
  ADD CONSTRAINT `discharge_summaries_ibfk_1` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`),
  ADD CONSTRAINT `discharge_summaries_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctors_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `doctor_rounds`
--
ALTER TABLE `doctor_rounds`
  ADD CONSTRAINT `doctor_rounds_ibfk_1` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`),
  ADD CONSTRAINT `doctor_rounds_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `insurance_claims`
--
ALTER TABLE `insurance_claims`
  ADD CONSTRAINT `insurance_claims_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `insurance_claims_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `billing` (`id`);

--
-- Constraints for table `lab_test_results`
--
ALTER TABLE `lab_test_results`
  ADD CONSTRAINT `lab_test_results_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`id`),
  ADD CONSTRAINT `lab_test_results_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lab_test_results_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `medical_history_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  ADD CONSTRAINT `nurse_notes_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `nurse_notes_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `billing` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD CONSTRAINT `prescription_items_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `radiology_reports`
--
ALTER TABLE `radiology_reports`
  ADD CONSTRAINT `radiology_reports_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `radiology_reports_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `vitals`
--
ALTER TABLE `vitals`
  ADD CONSTRAINT `vitals_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vitals_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
