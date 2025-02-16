-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
<<<<<<< HEAD
-- Generation Time: Feb 16, 2025 at 01:48 AM
=======
-- Generation Time: Feb 09, 2025 at 02:53 PM
>>>>>>> ca0affc (latest)
=======
-- Generation Time: Feb 16, 2025 at 01:48 AM
>>>>>>> 5a50f72 (lastest)
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
-- Database: `recruitment_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `admin_password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_scores`
--

CREATE TABLE `quiz_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(2) NOT NULL,
  `score_percentage` int(3) NOT NULL,
  `quiz_time_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_applications`
--

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
<<<<<<< HEAD
<<<<<<< HEAD
  `supPosition` varchar(250) NOT NULL,
=======
>>>>>>> ca0affc (latest)
=======
  `supPosition` varchar(250) NOT NULL,
>>>>>>> 5a50f72 (lastest)
  `position` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` char(20) NOT NULL,
  `dateOfBirth` varchar(20) NOT NULL,
<<<<<<< HEAD
<<<<<<< HEAD
=======
  `birthCertificate` blob NOT NULL,
>>>>>>> ca0affc (latest)
=======
>>>>>>> 5a50f72 (lastest)
  `maritalStatus` varchar(20) NOT NULL,
  `stateOfOrigin` varchar(50) NOT NULL,
  `lga` varchar(100) NOT NULL,
  `nin` int(11) NOT NULL,
  `phoneNumber` varchar(11) NOT NULL,
  `emergencyNumber` varchar(11) NOT NULL,
  `address` varchar(250) NOT NULL,
<<<<<<< HEAD
<<<<<<< HEAD
  `status` varchar(100) NOT NULL
=======
  `lgaCertificate` blob NOT NULL
>>>>>>> ca0affc (latest)
=======
  `status` varchar(100) NOT NULL
>>>>>>> 5a50f72 (lastest)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_education_details`
--

CREATE TABLE `user_education_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `primary_school_name` text DEFAULT NULL,
  `primary_graduation_year` varchar(10) DEFAULT NULL,
  `secondarySchoolName` text DEFAULT NULL,
  `secondaryGraduationYear` varchar(10) DEFAULT NULL,
  `certificateType` varchar(100) DEFAULT NULL,
  `classOfDegree` varchar(100) DEFAULT NULL,
  `institution` text DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `highGraduationYear` varchar(10) NOT NULL,
  `nyscCertificateNumber` int(11) NOT NULL,
  `yearOfService` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a50f72 (lastest)
-- Table structure for table `user_files`
--

CREATE TABLE `user_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lga_file_path` varchar(250) NOT NULL,
  `birth_certificate_file_path` varchar(250) NOT NULL,
  `passport_file_path` varchar(250) NOT NULL,
  `sec_file_path` varchar(250) NOT NULL,
  `high_certificate_file_path` varchar(250) NOT NULL,
  `nysc_file_path` varchar(250) NOT NULL,
  `pmc_file_path` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
<<<<<<< HEAD
=======
>>>>>>> ca0affc (latest)
=======
>>>>>>> 5a50f72 (lastest)
-- Table structure for table `user_pmc_details`
--

CREATE TABLE `user_pmc_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bodyName` varchar(200) NOT NULL,
  `membershipID` varchar(50) NOT NULL,
  `membershipType` varchar(200) NOT NULL,
  `membershipResposibilities` varchar(1000) NOT NULL,
  `certificateDate` date NOT NULL,
  `membershipCertificate` blob NOT NULL,
  `applications_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_work_details`
--

CREATE TABLE `user_work_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organizationName` varchar(500) NOT NULL,
  `rank` varchar(100) NOT NULL,
  `responsibilities` varchar(300) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_applications`
--
ALTER TABLE `user_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_education_details`
--
ALTER TABLE `user_education_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a50f72 (lastest)
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`);

--
<<<<<<< HEAD
=======
>>>>>>> ca0affc (latest)
=======
>>>>>>> 5a50f72 (lastest)
-- Indexes for table `user_pmc_details`
--
ALTER TABLE `user_pmc_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_work_details`
--
ALTER TABLE `user_work_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_education_details`
--
ALTER TABLE `user_education_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a50f72 (lastest)
-- AUTO_INCREMENT for table `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
<<<<<<< HEAD
=======
>>>>>>> ca0affc (latest)
=======
>>>>>>> 5a50f72 (lastest)
-- AUTO_INCREMENT for table `user_pmc_details`
--
ALTER TABLE `user_pmc_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_work_details`
--
ALTER TABLE `user_work_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
