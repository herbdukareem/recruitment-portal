-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 10:53 PM
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

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_id`, `admin_password`) VALUES
(1, 'admin_1', '$2y$10$1FZL49BjbYLCFmYTFKWLs.AY6s2.RohOt3gBqD6wIzt17E0lpQeZS'),
(2, 'admin_2', '$2y$10$oJ.trq.kgRMD7gB19cMy/.AotUjojtcj.pkVnX8nq0t.OWCDIqfb2'),
(3, 'admin_3', '$2y$10$feoyMwN0/3jk/FZqVY9Qg.7Ql55.q5TUqXTGerNbdChAkhc2SKiFa');

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
(14, 'Tunmise', 'Falodun', 'ultimatefaloe@gmail.com', '$2y$10$2icOtkCzC9bUE3h/8cBUOO5rPqG4FbcjZDP6fwbTjFm57sWL5ZHrS', '2024-09-14 11:51:28', NULL),
(15, 'Bisola', 'oludare', 'bisolaoludare880@gmail.com', '$2y$10$N4dz4AAA2rGuWKKAR79fleBMCJQE3pgCDAAc8LUuDpq9cPXsfABq6', '2024-09-18 20:50:15', NULL),
(16, 'Kola', 'Tunmise', 'kolatunmise@gmail.com', '$2y$10$EfBcpKA/XQ0eaf9at9d4e.FdT8KhQDR34ThSzXs4jXJbMsaYmz54C', '2024-09-18 21:06:09', NULL),
(17, 'Roy', 'Stone', 'mail@gmail.com', '$2y$10$ZiNj3QbilOk9QGPxNM8obOTa3tt6Y2hrr3fa6PHjdEr7gOv6Roqbu', '2024-09-18 21:19:35', NULL),
(18, 'Eniola', 'Badmus', 'hello@gmail.com', '$2y$10$C5uh6gBkbEJnnSp6B43zAuqzGDY70ZnKkNfSAWo6OdPue.K14CgWO', '2024-09-18 21:20:36', NULL),
(19, 'Ibrahim', 'hafsat', 'ibrahimhafsat@gmail.com', '$2y$10$TZsbuGiHdChYvCWSvOGRquRrbkzVg0hwDJtVlL9zrvNLx71KzqkQy', '2024-09-19 17:08:26', NULL),
(20, 'Falodun', 'Covenant', 'majemu@gmail.com', '$2y$10$1lzaRULDqOvizGKBiHl8beD7Isu6l/uXxPB78xko5ghUj./h5Iq6S', '2024-09-29 14:47:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_applications`
--

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` char(20) NOT NULL,
  `dateOfBirth` varchar(20) NOT NULL,
  `birthCertificate` blob NOT NULL,
  `maritalStatus` varchar(20) NOT NULL,
  `stateOfOrigin` varchar(50) NOT NULL,
  `lga` varchar(100) NOT NULL,
  `nin` int(11) NOT NULL,
  `phoneNumber` varchar(11) NOT NULL,
  `emergencyNumber` varchar(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `lgaCertificate` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_applications`
--

INSERT INTO `user_applications` (`id`, `user_id`, `position`, `firstname`, `middlename`, `lastname`, `gender`, `dateOfBirth`, `birthCertificate`, `maritalStatus`, `stateOfOrigin`, `lga`, `nin`, `phoneNumber`, `emergencyNumber`, `address`, `lgaCertificate`) VALUES
(6, 14, 'Administrative Cadre', 'Tunmise', 'Oluwatimilehin', ' Falodun', 'Male', '2024-08-12', '', 'Single', 'Osun', 'Obokun', 2147483647, '29202020200', '33003030', '325 S Gretna Green Way', ''),
(7, 13, 'Professors', 'Roy', 'Mark', ' Stone', 'Male', '2000-02-01', '', 'Single', 'Osun', 'Ido', 2147483647, '08025413752', '08097256741', 'Futminna, Gidan Kwano, Minna, Niger State', ''),
(8, 18, 'Clerical Officer Cadre', 'Eniola', 'Kolawole', ' Badmus', 'Male', '2024-06-06', '', 'Single', 'Ogun', 'Obokun', 2147483647, '29202020200', '66473738949', '325 S Gretna Green Way', ''),
(9, 19, 'Administrative Cadre', 'Ibrahim', 'autah', ' hafsat', 'Female', '2024-09-02', '', 'Single', 'Ekiti', 'Obokun', 2147483647, '03303003', '63535372836', '325 S Gretna Green Way', ''),
(10, 15, 'Executive Officer Cadre', 'Bisola', 'Dorcas', ' oludare', 'Female', '2024-09-01', '', 'Single', 'Kogi', 'Lokoja', 2147483647, '07017262642', '08097256741', 'Futminna, Gidan Kwano, Minna, Niger State', ''),
(11, 20, 'Executive Officer Cadre', 'Falodun', 'Adeolu', ' Covenant', 'Male', '2024-09-11', 0x546578745072696e742e706466, 'Single', 'Ebonyi', 'Obokun', 2147483647, '92392774', '08097256741', 'Futminna, Gidan Kwano, Minna, Niger State', 0x75687567752e706466),
(12, 16, 'Executive Officer (Accounts) Cadre', 'Kola', 'Oluwatimilehin', ' Tunmise', 'Male', '2024-09-29', '', 'Single', 'Osun', 'Obokun', 2147483647, '08051274015', '07017262642', 'No1, Bora Apata, Ibadan', '');

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
(1, 14, 'Faith Nursery and Primary school', '2007-2014', 'Omoniyi International College, Aba-Elesin, Apata, Ibadan', '2021', 's-class', 'B.tech', 'Federal University Of Technology, Minna', 'Information Technology', '2026', 776767238, '2027'),
(2, 13, 'Halo Nursery and Primary School', '2000-2007', 'Dynamic Pillars International college, Owode', '2007-2013', 'higher', 'B.sc', 'UI', 'Philosophy', '2027', 2147483647, '2017'),
(3, 18, 'Faith Nursery and Primary school', '2007-2014', 'Omoniyi International College, Aba-Elesin, Apata, Ibadan', '2021', 's-class', 'B.tech', 'Federal University Of Technology, Minna', 'Information Technology', '2026', 2147483647, '2000-2001'),
(4, 19, 'Nupe Nursery and Primary School', '2016', 'Bosso Community Secondary School', '2022', 'B.tech', 'Phd', 'Futminna', 'IFT', '2028', 2147483647, '2029'),
(5, 15, 'Nupe Nursery and Primary School', '2016', 'Bosso Community Secondary School', '2022', 'B.tech', 'Phd', 'Futminna', 'IFT', '2028', 2147483647, '2029'),
(6, 20, 'Halo Nursery and Primary School', '2000-2007', 'Bosso Community Secondary School', '2022', 'B.tech', 'Phd', 'Futminna', 'IFT', '2028', 2147483647, '2029'),
(7, 16, 'IMG, primary school', '2014', 'Comminuty Grammar School', '2022', 'B.tech', 'First Class', 'Federal Uniersity Of Technology, Minna', 'Information Technology', '2026', 2147483647, '2027');

-- --------------------------------------------------------

--
-- Table structure for table `user_pmc_details`
--

CREATE TABLE `user_pmc_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bodyName` varchar(200) NOT NULL,
  `membershipID` varchar(50) NOT NULL,
  `membershipResposibilities` varchar(1000) NOT NULL,
  `certificateDate` date NOT NULL,
  `membershipCertificate` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_pmc_details`
--

INSERT INTO `user_pmc_details` (`id`, `user_id`, `bodyName`, `membershipID`, `membershipResposibilities`, `certificateDate`, `membershipCertificate`) VALUES
(1, 14, 'hello', '6665636', ' i.hfihifgiuif. hio f iiorio ', '2024-09-01', ''),
(2, 18, 'hello', '6665636', 'h uihuigy8liuy uy98', '2024-09-03', ''),
(3, 19, 'Pantent Corporation', '#463489', 'Regulate the patent', '2024-09-02', ''),
(4, 20, 'Pantent Corporation', '#463489', 'mjl,kukl.', '2024-10-07', ''),
(5, 16, 'African Unity Of CEOs', '#56247', 'Member', '2024-10-01', '');

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
-- Dumping data for table `user_work_details`
--

INSERT INTO `user_work_details` (`id`, `user_id`, `organizationName`, `rank`, `responsibilities`, `startDate`, `endDate`) VALUES
(1, 14, 'UTE-Tech', 'Softwre Engineer', 'handle all the back-end of the project', '2024-09-01', '2024-09-18'),
(2, 13, 'Richard Milli Limited', 'Accountant', 'Takes, Process, and computes orders, and maintain the balance', '2024-09-03', '2024-09-15'),
(3, 18, 'UTE-Tech', 'Softwre Engineer', 'kuh uoy8fuiid9', '2024-09-01', '2024-09-18'),
(4, 19, 'Silicon IntelliSense Corporation', 'IT Assistant', 'assistant', '2024-09-17', '2024-09-20'),
(5, 15, 'Silicon IntelliSense Corporation', 'IT Assistant', 'hui fttdrdhfdstdng', '2024-09-03', '2024-09-09'),
(6, 20, 'Bitemore', 'Supervisor', 'supervise', '2024-09-30', '2024-09-29'),
(7, 16, 'UTE Paint Plc.', 'C.E.O', 'Coordinate all the activites of the firm', '2021-02-02', '2024-10-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_education_details`
--
ALTER TABLE `user_education_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_pmc_details`
--
ALTER TABLE `user_pmc_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_work_details`
--
ALTER TABLE `user_work_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
