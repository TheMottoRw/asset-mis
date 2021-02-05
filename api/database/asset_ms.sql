-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 06:40 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_ms`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `names` varchar(140) NOT NULL,
  `state` varchar(140) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(70) NOT NULL,
  `serial_number` varchar(70) NOT NULL,
  `type` varchar(70) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `names`, `state`, `description`, `code`, `serial_number`, `type`, `dept_id`, `registered_on`) VALUES
(1, ' VGA', ' ssd', ' double VGA used tosddsfsfs', '5YIT-2000', ' 2YMATE', ' COMPUTER ACCESSORY', 1, '2021-01-29 19:29:57'),
(2, ' PROJECTOR', ' SA', ' 3D', '5YIT-2000', ' 2YMATE', ' COMPUTER ACCESSORY', 1, '2021-01-29 19:30:00'),
(4, 'RTETRETEET', 'WER', 'WRW', 'FDS', 'DSF', 'DSD', 1, '2021-01-29 21:09:40'),
(5, 'dfs', 'sfs', 'sf', 'sf', 'sfs', 'sfs', 2, '2021-01-29 21:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `asset_movement`
--

CREATE TABLE `asset_movement` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `booked_on` datetime DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `quantity` datetime DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_movement`
--

INSERT INTO `asset_movement` (`id`, `student_id`, `asset_id`, `booked_on`, `submitted_on`, `location`, `status`, `quantity`, `registered_on`) VALUES
(1, 1, 1, '2020-11-11 00:00:00', '2021-01-20 00:00:00', 'KWA GATUZA', ' Available', '0000-00-00 00:00:00', '2021-01-29 19:39:17'),
(2, 1, 1, '2020-11-11 21:21:12', '2021-01-20 12:12:12', 'FACEBOOK HALL', ' Available', '0000-00-00 00:00:00', '2021-01-29 19:42:17'),
(3, 1, 1, '2020-11-11 00:00:00', '2021-01-20 00:00:00', 'KWA GATUZA', ' Available', '0000-00-00 00:00:00', '2021-01-29 19:42:18'),
(4, 1, 1, '2020-11-11 21:21:12', '2021-01-20 12:12:12', 'LIBRARY-CAMP KIGALI', ' Available', '0000-00-00 00:00:00', '2021-01-29 19:44:34'),
(5, 2, 2, '2021-01-02 02:29:12', '2021-01-02 02:59:12', 'MU GATENGA', NULL, '0000-00-00 00:00:00', '2021-01-29 22:02:10'),
(6, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KN12 av2, 3rd Floor', NULL, '0000-00-00 00:00:00', '2021-01-29 22:04:12'),
(7, 4, 4, '2021-01-02 02:29:12', '2021-01-02 02:59:12', 'MU GATENGA', 'taken', '0000-00-00 00:00:00', '2021-01-29 22:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `academic_year`, `registered_on`) VALUES
(1, 'Year II IS', '2019-2020', '2021-01-29 18:24:38'),
(2, 'Updated...!!!!', '2020-2021', '2021-01-29 18:24:47'),
(3, 'Year II IT', '2020-2021', '2021-01-29 18:25:49'),
(4, 'year one Material', '2019-2020', '2021-01-29 18:32:01'),
(6, 'S1B', '2010', '2021-01-29 22:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `acronym` varchar(100) DEFAULT NULL,
  `names` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `acronym`, `names`, `location`, `registered_on`) VALUES
(1, 'IT', 'Information Technology', ' SABE', '2021-01-29 18:44:52'),
(2, 'CST ENG', 'CONSTRUCTION ENGINEERING', ' MUHABURA', '2021-01-29 18:45:02'),
(4, 'CST ENG', 'CONSTRUCTION ENGINEERING', ' MUHABURA', '2021-01-29 18:47:00'),
(5, 'BIT', 'BUSINESS IN INFOMATION TECHNOLOGY', 'MUHABURA BLOCK', '2021-01-29 22:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `lastname`, `email`, `phone`, `role`, `password`, `dept_id`, `registered_on`) VALUES
(1, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 0, '$2y$10$v2HXr0gZYseA7KyR5U2DUOn82o62khn1M4tBDK4jmS56uW84Rle1W', 1, '2021-01-29 19:09:20'),
(2, ' BYIRINGIRO', 'EMMANUEL', 'manunudi@muhire.com', '0788332245', 1, '$2y$10$VXemQD4Q3q59mvC7hBYh2.P2XNVSil4hEy3pAsYtHDPnEWoXC.S8e', 1, '2021-01-29 19:11:10'),
(3, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 1, '$2y$10$pJ9sD9C/gB/uxHU2us/dxOaeuLVFuO0a7mtT.oycLuPyR6f0tgjDO', 1, '2021-01-29 19:13:07'),
(4, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 1, '$2y$10$bWAdRfT7R8V/vp4JRYNFBOsfj2B1iy9wB.8y3E0CN.jxay3GaQLj.', 1, '2021-01-29 19:51:19'),
(5, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 1, '$2y$10$0L4lTRsK9aUNZ0nxJdxvve1S3HBHhVhkapIIahW4AK3GMzWqp0Tau', 1, '2021-01-29 19:53:03'),
(6, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 1, '$2y$10$FDmu40Xhgclq1EVQW7FDwOmuimybb5N90Qm/ZwJ.vgJvFr/9mSvpO', 1, '2021-01-29 19:53:04'),
(7, ' MUHIRE ', 'KJOHON', 'muhire@muhire.com', '0788332245', 1, '$2y$10$WhbVoT0hqwx4v62SeoYUQuVFEKNqLmHXYPfrqgK.GgWjZkMLxaVYS', 1, '2021-01-29 19:53:25'),
(8, 'CYUBAHIRO', 'Theotime', 'omar@omar.com', '0782343423', 0, '$2y$10$66pxGUgBrqEZ/Qasn7RK5OYMDmFISusIkeMxUY3//Qxz.oKsq.clm', 5, '2021-01-29 22:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `reg_number` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `firstname`, `lastname`, `reg_number`, `email`, `password`, `dept_id`, `class_id`, `registered_on`) VALUES
(1, 'MUSANGWA ', ' PASCAL', '219007056', 'pascal@ur.rw', '123', 1, 1, '2021-01-29 18:54:57'),
(2, 'NTURANYENABANGA', 'RABAN', '219007056', 'pascal@ur.rw', '123', 1, 1, '2021-01-29 18:55:02'),
(4, 'MUSANGWA ', ' PASCAL', '219007056', 'pascal@ur.rw', '123', 1, 1, '2021-01-29 18:55:27'),
(6, 'asdadsadasd', 'sdfsfd', 'sfds', 'shyaka@shyaka.com', '$2y$10$BdU5w4fTsth39DdpUAQQHOG97sfzQ0VwnU6idpLyBS8N9n6wfVaIW', 5, 2, '2021-01-29 22:36:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dpt_fk` (`dept_id`);

--
-- Indexes for table `asset_movement`
--
ALTER TABLE `asset_movement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `std_fk` (`student_id`),
  ADD KEY `asset_fk` (`asset_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_fk` (`dept_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk2` (`dept_id`),
  ADD KEY `class_dk` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `asset_movement`
--
ALTER TABLE `asset_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `dpt_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_movement`
--
ALTER TABLE `asset_movement`
  ADD CONSTRAINT `asset_fk` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `std_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `dept_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `class_dk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
