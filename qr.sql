-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2020 at 10:43 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qr`
--

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE `instructions` (
  `id` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instructions_data`
--

CREATE TABLE `instructions_data` (
  `id` int(11) NOT NULL,
  `instruction_id` int(11) NOT NULL,
  `instruction_order` int(11) NOT NULL,
  `type` enum('text','image','video','') NOT NULL,
  `content` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instructions_users`
--

CREATE TABLE `instructions_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `instruction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `email` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  `rank` enum('0','1','2','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verification_answers`
--

CREATE TABLE `verification_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `correct_answer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verification_questions`
--

CREATE TABLE `verification_questions` (
  `id` int(11) NOT NULL,
  `instruction_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `creator` (`creator`);

--
-- Indexes for table `instructions_data`
--
ALTER TABLE `instructions_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instruction_id` (`instruction_id`);

--
-- Indexes for table `instructions_users`
--
ALTER TABLE `instructions_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `instruction_id` (`instruction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_answers`
--
ALTER TABLE `verification_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_id` (`question_id`);

--
-- Indexes for table `verification_questions`
--
ALTER TABLE `verification_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instruction_id` (`instruction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instructions`
--
ALTER TABLE `instructions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructions_data`
--
ALTER TABLE `instructions_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructions_users`
--
ALTER TABLE `instructions_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_answers`
--
ALTER TABLE `verification_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_questions`
--
ALTER TABLE `verification_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instructions`
--
ALTER TABLE `instructions`
  ADD CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`);

--
-- Constraints for table `instructions_data`
--
ALTER TABLE `instructions_data`
  ADD CONSTRAINT `instructions_data_ibfk_1` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`);

--
-- Constraints for table `instructions_users`
--
ALTER TABLE `instructions_users`
  ADD CONSTRAINT `instructions_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `instructions_users_ibfk_2` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`);

--
-- Constraints for table `verification_answers`
--
ALTER TABLE `verification_answers`
  ADD CONSTRAINT `verification_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `verification_questions` (`id`);

--
-- Constraints for table `verification_questions`
--
ALTER TABLE `verification_questions`
  ADD CONSTRAINT `verification_questions_ibfk_1` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
