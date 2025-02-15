-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 09:01 PM
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
(14, 'Tunmise', 'Falodun', 'ultimatefaloe@gmail.com', '$2y$10$2icOtkCzC9bUE3h/8cBUOO5rPqG4FbcjZDP6fwbTjFm57sWL5ZHrS', '2024-09-14 11:51:28', NULL),
(15, 'Bisola', 'oludare', 'bisolaoludare880@gmail.com', '$2y$10$N4dz4AAA2rGuWKKAR79fleBMCJQE3pgCDAAc8LUuDpq9cPXsfABq6', '2024-09-18 20:50:15', NULL),
(16, 'Kola', 'Tunmise', 'kolatunmise@gmail.com', '$2y$10$EfBcpKA/XQ0eaf9at9d4e.FdT8KhQDR34ThSzXs4jXJbMsaYmz54C', '2024-09-18 21:06:09', NULL),
(17, 'Roy', 'Stone', 'mail@gmail.com', '$2y$10$ZiNj3QbilOk9QGPxNM8obOTa3tt6Y2hrr3fa6PHjdEr7gOv6Roqbu', '2024-09-18 21:19:35', NULL),
(18, 'Eniola', 'Badmus', 'hello@gmail.com', '$2y$10$C5uh6gBkbEJnnSp6B43zAuqzGDY70ZnKkNfSAWo6OdPue.K14CgWO', '2024-09-18 21:20:36', NULL),
(19, 'Ibrahim', 'hafsat', 'ibrahimhafsat@gmail.com', '$2y$10$TZsbuGiHdChYvCWSvOGRquRrbkzVg0hwDJtVlL9zrvNLx71KzqkQy', '2024-09-19 17:08:26', NULL),
(20, 'Falodun', 'Covenant', 'majemu@gmail.com', '$2y$10$1lzaRULDqOvizGKBiHl8beD7Isu6l/uXxPB78xko5ghUj./h5Iq6S', '2024-09-29 14:47:06', NULL),
(21, 'Lisa', 'Hatcher', 'lisahatcher549@gmail.com', '$2y$10$5wjeIJy0OrvWI09RLY5O3.0xg7RNvCzoJdftd31ZAnz5v7Ck3qxo6', '2024-11-22 15:08:49', NULL),
(22, 'Falodun', 'Covenant', 'majemu@gmail.com', '$2y$10$ARRz78JxrQ1i3pJOX6KRiOZq9KMN9icm0Nd2sOwmPqJl.OMVNfhxO', '2025-02-08 20:04:10', NULL),
(23, 'Mike', 'Julius', 'mikekiller@nike.com', '$2y$10$CztbIrvuLgV4A7r/w/bOVu.s5ZAm01eU3yU8XdA.PtHU2n.xxli6.', '2025-02-09 13:25:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
