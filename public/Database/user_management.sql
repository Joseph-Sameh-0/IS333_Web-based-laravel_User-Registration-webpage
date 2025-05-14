-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 04:32 PM
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
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `whatsup_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `User_img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `full_name`, `phone`, `whatsup_number`, `address`, `password`, `email`, `User_img`, `created_at`) VALUES
(3, 'Amany10', 'Amany Mohamed Hussein', '01014103975', '+2001014103975', 'Cairo, Egypt', '$2y$10$gPuEP7hvlmAxPSmeJly1ROlCAy1I.AwgFGHX3rMk1d97MSuY6YghC', 'Amany@gmail.com', 'public/uploads/Girl_user1.jpg', '2025-04-14 12:58:37'),
(4, 'joe11', 'Youssef Joseph', '01000111222', '+2001000111222', 'Cairo, Egypt', '$2y$10$QSbpra3MMQXcdww0CbA3a.3d6Dmkq1CpTpPpaEYpeLyczFhfwEkhO', 'joe@gmail.com', 'public/uploads/boy_user2.jpg', '2025-04-14 13:09:10'),
(5, 'Joseph12', 'Joseph Sameh', '01022334455', '+2001022334455', 'Giza, Egypt', '$2y$10$K8VPgyB04EDxvtue1tdNM.iWs3NwXko9.pc14V6sFFWFo6lZQLTja', 'JSameh@gmail.com', 'public/uploads/boy_user1.jpg', '2025-04-14 13:21:18'),
(6, 'sara99', 'Sara Fahmy', '01097915491', '+2001097915491', 'Mansoura, Egypt', '$2y$10$2ADACnV8vbyJGp0ht/uc/OePyRmvGaG4W1/5ElZCoW/y.i7.f/elK', 'sfahmy@gmail.com', 'public/uploads/Girl_user3.jpg', '2025-04-14 13:33:39'),
(7, 'Israa55', 'Israa Mohamed', '01077889900', '+2001077889900', 'Giza, Egypt', '$2y$10$N5Ea/Ir3ksczoKLjvIZiB.meAcHDJJhfWV/AnKek4Oc2RjlX3SYFK', 'IsraaXX@gmail.com', 'public/uploads/Girl_user2.jpg', '2025-04-14 14:21:00'),
(8, 'hmohamed', 'Hassan Mohamed', '01066778899', '+2001066778899', 'Aswan, Egypt', '$2y$10$rakqYg4oWkL.msVF1hWvh.dOZwZP6B8A9xXrZAJ0.BXSDzLFrxXuO', 'hmohamed@gmail.com', 'public/uploads/boy_user3.jpg', '2025-04-14 14:25:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `Unique_User` (`user_name`),
  ADD UNIQUE KEY `Unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
