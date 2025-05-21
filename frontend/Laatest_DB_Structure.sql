-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 01:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `admin_password` varchar(200) DEFAULT NULL,
  `admin_role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_id`, `admin_password`, `admin_role`) VALUES
(1, 'admin_vc', '$2y$10$aqCPU87ny66ulOzeZgHpleWvWd4TucunDuN63uP2V0eA8mmU5EQhC', 'sup_admin'),
(2, 'admin_1', '$2y$10$.QAjeRxkD4HBZMWlBHDOUOODCy3p4q9TQGYubAmkHFqGUyXjUY4bO', 'admin');

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

--
-- Dumping data for table `quiz_scores`
--

INSERT INTO `quiz_scores` (`id`, `user_id`, `score`, `score_percentage`, `quiz_time_stamp`) VALUES
(1, 6, 7, 70, '2025-03-16 13:26:30'),
(2, 5, 5, 50, '2025-03-17 01:44:13');

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
(5, 'Bisola', 'oludare', 'bisolaoludare880@gmail.com', '$2y$10$2/DshHhahiz9nA3u1rQgCednFKS/ZVlTsm.nt8Q8eg4.wQJxo1E3C', '2025-03-16 12:42:40', NULL),
(6, 'aaa', 'ccc', 'ultimate@gmail.com', '$2y$10$b2LFl/hRx2FSJwSHahS3R.Xgjx1byT5bn3P0KB3xH8t00S2PTWrpa', '2025-03-16 12:53:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_applications`
--

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `positionType` varchar(250) NOT NULL,
  `supPosition` varchar(250) NOT NULL,
  `position` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` char(20) NOT NULL,
  `dateOfBirth` varchar(20) NOT NULL,
  `maritalStatus` varchar(20) NOT NULL,
  `stateOfOrigin` varchar(50) NOT NULL,
  `lga` varchar(100) NOT NULL,
  `nin` int(11) NOT NULL,
  `phoneNumber` varchar(11) NOT NULL,
  `emergencyNumber` varchar(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_applications`
--

INSERT INTO `user_applications` (`id`, `user_id`, `positionType`, `supPosition`, `position`, `firstname`, `middlename`, `lastname`, `gender`, `dateOfBirth`, `maritalStatus`, `stateOfOrigin`, `lga`, `nin`, `phoneNumber`, `emergencyNumber`, `address`, `status`) VALUES
(3, 5, 'Non-Teaching', 'Administrative Cadre', 'Administrative Cadre', 'Bisola', 'Dorcas', 'oludare', 'Male', '2025-02-24', 'Single', 'Kogi', 'Ajaokuta', 2147483647, '08025413757', '08097256741', 'admin_vc', 'interviewed'),
(4, 6, 'Academic', 'Academic Staff', 'Professor', 'aaa', 'bbb', 'ccc', 'Female', '2025-02-23', 'Married', 'Delta', 'Ughelli South', 2147483647, '4377757027', '08097256741', 'admin_vcjn', 'shortlisted');

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
(1, 6, '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>44</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>44</b><br />', '<br /><b>W', '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>81</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>81</b><br />', '<br /><b>W', '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pa', '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pa', '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>148</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\education.php</b> on line <b>148</b><br />', '<br /><b>Warning</b>:  Undefined variable $user_edu_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pa', '<br /><b>W', 0, '<br /><b>W'),
(2, 5, 'Halo Nursery and Primary School', '2000-2007', 'Bosso Community Secondary School', '2022', 'B.tech', 'B.sc', 'Futminna', 'IFT', '2028', 2147483647, '2017');

-- --------------------------------------------------------

--
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

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`id`, `user_id`, `lga_file_path`, `birth_certificate_file_path`, `passport_file_path`, `sec_file_path`, `high_certificate_file_path`, `nysc_file_path`, `pmc_file_path`) VALUES
(3, 5, '../Application_Dashboard/uploads5_lgaCertificate.jpg', '../Application_Dashboard/uploads5_birthCertificate.jpg', '../Application_Dashboard/uploads5_passport.jpg', './uploads/5_secondaryCertificate.jpg', './uploads/5_highCertificate.jpg', './uploads/5_nyscCertificate.pdf', './uploads/5_membershipCertificate.jpg'),
(4, 6, '../Application_Dashboard/uploads6_lgaCertificate.jpg', '../Application_Dashboard/uploads6_birthCertificate.jpg', '../Application_Dashboard/uploads6_passport.jpg', '../Application_Dashboard/uploads6_secondaryCertificate.jpg', '../Application_Dashboard/uploads6_highCertificate.png', '../Application_Dashboard/uploads6_nyscCertificate.pdf', './uploads/6_membershipCertificate.jpg');

-- --------------------------------------------------------

--
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

--
-- Dumping data for table `user_pmc_details`
--

INSERT INTO `user_pmc_details` (`id`, `user_id`, `bodyName`, `membershipID`, `membershipType`, `membershipResposibilities`, `certificateDate`, `membershipCertificate`, `applications_timestamp`) VALUES
(1, 6, '<br /><b>Warning</b>:  Undefined variable $user_pmc_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\pmc.php</b> on line <b>62</b><br /><br /><b>Warning</b>:  Trying to access array offset on value', '<br /><b>Warning</b>:  Undefined variable $user_pm', '<br /><b>Warning</b>:  Undefined variable $user_pmc_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\pmc.php</b> on line <b>72</b><br /><br /><b>Warning</b>:  Trying to access array offset on value', '<br /><b>Warning</b>:  Undefined variable $user_pmc_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\pmc.php</b> on line <b>77</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\pmc.php</b> on line <b>77</b><br />', '2025-03-03', '', '2025-03-16 13:07:06'),
(2, 5, 'Pantent Corporation', '#463489', 'Regulator', 'okay patent', '2025-02-23', '', '2025-03-17 01:46:42');

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
(1, 6, '<br /><b>Warning</b>:  Undefined variable $user_work_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\work.php</b> on line <b>54</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\work.php</b> on line <b>54</b><br />', '<br /><b>Warning</b>:  Undefined variable $user_work_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\p', '<br /><b>Warning</b>:  Undefined variable $user_work_data in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\work.php</b> on line <b>64</b><br /><br /><b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\recruitment-portal\\pages\\work.php</b> on line <b>64</b><br />', '2025-02-23', '2025-03-10'),
(2, 5, 'Silicon IntelliSense Corporation', 'Supervisor', 'Takes, Process, and computes orders, and maintain the balance', '2025-02-23', '2025-03-16');

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
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_education_details`
--
ALTER TABLE `user_education_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_pmc_details`
--
ALTER TABLE `user_pmc_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_work_details`
--
ALTER TABLE `user_work_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
