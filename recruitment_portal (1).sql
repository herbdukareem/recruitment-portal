-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 02:44 PM
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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`, `updated_at`) VALUES
(13, 'Roy', 'Stone', 'troy19156@gmail.com', '$2y$10$ls93dc/tc.RXqoNtFxSNgOrZRWKsmHE05Z8EBOqflZb.NLlTEAe72', '2024-09-14 02:30:52', NULL),
(14, 'Tunmise', 'Falodun', 'ultimatefaloe@gmail.com', '$2y$10$2icOtkCzC9bUE3h/8cBUOO5rPqG4FbcjZDP6fwbTjFm57sWL5ZHrS', '2024-09-14 11:51:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_applications`
--

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` char(20) NOT NULL,
  `dateOfBirth` varchar(20) NOT NULL,
  `maritalStatus` varchar(20) NOT NULL,
  `stateOfOrigin` varchar(50) NOT NULL,
  `localGovernmentArea` varchar(100) NOT NULL,
  `nin` int(11) NOT NULL,
  `phoneNumber` varchar(11) NOT NULL,
  `emergencyNumber` varchar(11) NOT NULL,
  `address` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_applications`
--

INSERT INTO `user_applications` (`id`, `user_id`, `firstname`, `middlename`, `lastname`, `gender`, `dateOfBirth`, `maritalStatus`, `stateOfOrigin`, `localGovernmentArea`, `nin`, `phoneNumber`, `emergencyNumber`, `address`) VALUES
(6, 14, 'Tunmise', 'Kolawole', ' Falodun', 'Male', '2005-02-02', 'Single', 'Ekiti', 'Obokun', 79238488, '79238488', '79238488', 'no 1, bora, apata, ibadan'),
(7, 13, 'Roy', 'Mark', ' Stone', 'Male', '2000-02-01', 'Single', 'Osun', 'Ido', 2147483647, '08025413752', '08097256741', 'Futminna, Gidan Kwano, Minna, Niger State');

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

--
-- Dumping data for table `user_education_details`
--

INSERT INTO `user_education_details` (`id`, `user_id`, `primary_school_name`, `primary_graduation_year`, `secondarySchoolName`, `secondaryGraduationYear`, `certificateType`, `classOfDegree`, `institution`, `course`, `highGraduationYear`, `nyscCertificateNumber`, `yearOfService`) VALUES
(1, 14, 'Faith Nursery and Primary school', '2007-2014', 'Omoniyi International College, Aba-Elesin, Apata, Ibadan', '2014-2021', 'Male', 'Female', 'Federal University Of Minna', 'IFT', '2026', 776767238, '2027'),
(2, 13, 'Halo Nursery and Primary School', '2000-2007', 'Dynamic Pillars International college, Owode', '2007-2013', 'Male', 'Male', 'Male', 'Male', '2026', 2147483647, '2017');

-- --------------------------------------------------------

--
-- Table structure for table `user_work_details`
--

CREATE TABLE `user_work_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organizationName` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL,
  `responsibilities` varchar(300) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_work_details`
--

INSERT INTO `user_work_details` (`id`, `user_id`, `organizationName`, `role`, `responsibilities`, `startDate`, `endDate`) VALUES
(1, 14, 'UTE-Tech', 'Softwre Engineer', 'I work as system analyst and software engineer', '2024-09-01', '2024-09-17');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `user_work_details`
--
ALTER TABLE `user_work_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_education_details`
--
ALTER TABLE `user_education_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_work_details`
--
ALTER TABLE `user_work_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
