-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 07:55 AM
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
-- Database: `pesodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `applicationId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `middleName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `age` int(2) NOT NULL,
  `gender` varchar(11) NOT NULL,
  `birthdate` date NOT NULL,
  `profilePicture` varchar(25) NOT NULL,
  `workExperience` varchar(1000) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`applicationId`, `userId`, `firstName`, `middleName`, `lastName`, `address`, `contact`, `age`, `gender`, `birthdate`, `profilePicture`, `workExperience`, `status`) VALUES
(4, 18, 'Gary', 'B', 'Malonzo', 'asdasd', '123098', 29, 'male', '2024-05-01', '1716176649.png', 'asfasfasfasf', 'approved'),
(5, 16, 'asd', 'asfasf', 'asfasfasfasf', '123', '123098', 29, 'male', '2024-05-09', '1716176716.png', 'asfasfasf asfas fa sfa fas f', 'rejected'),
(6, 19, 'gabriel', 'bandibas', 'malonzo', 'caloocan city', '0988 765 89', 22, 'male', '2002-04-26', '1716207128.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed congue at metus sed tincidunt. Nulla feugiat velit vel nisi elementum feugiat. Maecenas elementum massa vulputate faucibus blandit. Suspendisse potenti. Cras dictum arcu ante, a tincidunt sem lo', 'approved'),
(7, 17, 'zed', 'z.', 'sartorio', 'cal city', '0995 678 98', 21, 'male', '2002-04-16', '1716270416.png', 'I have no work experience.', 'approved'),
(8, 21, 'romark', 'a', 'asdasd', 'asasas', '0995 678 98', 21, 'male', '2000-04-01', '1716285840.png', 'no experience.', 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `appliedjobs`
--

CREATE TABLE `appliedjobs` (
  `appliedJobId` int(11) NOT NULL,
  `applicationId` int(11) NOT NULL,
  `jobId` int(11) NOT NULL,
  `dateSent` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appliedjobs`
--

INSERT INTO `appliedjobs` (`appliedJobId`, `applicationId`, `jobId`, `dateSent`) VALUES
(6, 4, 2, '2024-05-20 11:44:08'),
(7, 4, 3, '2024-05-20 11:44:08'),
(8, 5, 2, '2024-05-20 11:45:15'),
(9, 5, 1, '2024-05-20 11:45:15'),
(10, 6, 2, '2024-05-20 20:12:08'),
(11, 6, 3, '2024-05-20 20:12:08'),
(12, 6, 1, '2024-05-20 20:12:08'),
(13, 7, 2, '2024-05-21 13:46:56'),
(14, 7, 3, '2024-05-21 13:46:56'),
(15, 7, 1, '2024-05-21 13:46:56'),
(16, 8, 2, '2024-05-21 18:04:00'),
(17, 8, 3, '2024-05-21 18:04:00'),
(18, 8, 1, '2024-05-21 18:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobId` int(11) NOT NULL,
  `jobName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobId`, `jobName`) VALUES
(1, 'Truck Driver'),
(2, 'Clerk'),
(3, 'Painter');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT 0,
  `dateRegistered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`, `password`, `isAdmin`, `dateRegistered`) VALUES
(16, 'no@thanks.com', '$2y$10$Ke8IajhjBzl7MPmz70EXAeyUisxdw0b7cfIoqUoziAbpMLrIeSDji', 0, '2024-05-20 09:17:21'),
(17, 'admin@email.com', '$2y$10$IxlCTEE/FrQuMiOaTmpjM.vfeiDKATvjvn.FMF6AprrVQzaA2uIGu', 1, '2024-05-20 10:58:19'),
(18, 'sample@email.com', '$2y$10$psf3drQDWBSxc2FjWec.R.ZX7G4x8sfcL4oZSkJEOwCHpgFisY1N2', 0, '2024-05-20 11:39:52'),
(19, 'gab@gmail.com', '$2y$10$wwFj3ta8MfaM36QoQ3b1jeNOFjs/vhhiSs5FiJEpUPgSkiXFfgyaW', 0, '2024-05-20 20:08:42'),
(20, 'zed@gmail.com', '$2y$10$X9POdGzPWrPOSfMGgogY5uxH/LnVpBc2r3lANEYYEKG7Bgkvi/zvW', 0, '2024-05-21 13:24:44'),
(21, 'romark@gmail.com', '$2y$10$MUN.El6BCcGHAv4Ln/K4se0AipTbmoq3Xx.mH0HCeCLBjwwsjlwnS', 0, '2024-05-21 17:58:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`applicationId`);

--
-- Indexes for table `appliedjobs`
--
ALTER TABLE `appliedjobs`
  ADD PRIMARY KEY (`appliedJobId`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `applicationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appliedjobs`
--
ALTER TABLE `appliedjobs`
  MODIFY `appliedJobId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
