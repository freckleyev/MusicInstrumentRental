-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 18, 2026 at 12:29 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MusicInstrumentsRental`
--
CREATE DATABASE IF NOT EXISTS `MusicInstrumentsRental` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `MusicInstrumentsRental`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'Electronic'),
(4, 'Keyboard'),
(3, 'Percussion'),
(1, 'String'),
(2, 'Wind');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260818114214', '2026-08-18 11:42:21', 28),
('DoctrineMigrations\\Version20260818114917', '2026-08-18 11:49:22', 10),
('DoctrineMigrations\\Version20260818120733', '2026-08-18 12:07:40', 53);

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `instrument_condition` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `daily_rental_price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`id`, `name`, `instrument_condition`, `description`, `daily_rental_price`, `image`, `is_active`, `category_id`) VALUES
(1, 'Acoustic Guitar', 'Excellent', 'Dreadnought acoustic guitar with warm resonance.', 15.00, 'instrument_default.jpg', 0, 1),
(2, 'Violin 4/4', 'Good', 'Full-size student violin with bow and hard case.', 12.50, 'instrument_default.jpg', 0, 1),
(3, 'Alto Saxophone', 'Good', 'E-flat alto saxophone suitable for beginners and intermediate players.', 22.00, 'instrument_default.jpg', 0, 2),
(4, 'Bb Trumpet', 'Excellent', 'Standard B-flat brass trumpet with carrying case.', 18.00, 'instrument_default.jpg', 0, 2),
(5, '5-Piece Drum Kit', 'Fair', 'Complete acoustic drum set including cymbals and hardware.', 35.00, 'instrument_default.jpg', 0, 3),
(6, 'Cajon', 'Excellent', 'Peruvian-style wooden percussion box with internal snares.', 10.00, 'instrument_default.jpg', 0, 3),
(7, '88-Key Digital Piano', 'Excellent', 'Weighted action digital piano with sustain pedal.', 30.00, 'instrument_default.jpg', 0, 4),
(8, 'Upright Piano', 'Good', 'Acoustic upright piano with classic mahogany finish.', 50.00, 'instrument_default.jpg', 0, 4),
(9, 'Analog Synthesizer', 'Excellent', '37-key monophonic analog synth with patch points.', 25.00, 'instrument_default.jpg', 0, 5),
(10, 'DJ Controller', 'Good', '2-channel USB DJ controller with integrated audio interface.', 20.00, 'instrument_default.jpg', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_requests`
--

CREATE TABLE `rental_requests` (
  `id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `purpose` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `reviewed_by` int DEFAULT NULL,
  `rejection_reason` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `instrument_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `is_blocked` tinyint NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3AF346685E237E06` (`name`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E350DE0B12469DE2` (`category_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`);

--
-- Indexes for table `rental_requests`
--
ALTER TABLE `rental_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4BE3CF62A76ED395` (`user_id`),
  ADD KEY `IDX_4BE3CF62CF11D9C` (`instrument_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_requests`
--
ALTER TABLE `rental_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instruments`
--
ALTER TABLE `instruments`
  ADD CONSTRAINT `FK_E350DE0B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `rental_requests`
--
ALTER TABLE `rental_requests`
  ADD CONSTRAINT `FK_4BE3CF62A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_4BE3CF62CF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
