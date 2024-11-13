-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2024 at 06:14 AM
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
-- Database: `swuetsdb3`
--

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE `contestants` (
  `contestant_id` int(11) NOT NULL,
  `lname` text NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `department` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `contestant_ctr` int(11) NOT NULL,
  `status` text NOT NULL,
  `txt_code` text NOT NULL,
  `rand_code` int(15) NOT NULL,
  `txtPollScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`contestant_id`, `lname`, `fname`, `mname`, `department`, `contact`, `image_url`, `subevent_id`, `contestant_ctr`, `status`, `txt_code`, `rand_code`, `txtPollScore`) VALUES
(1, 'Silvederio', 'Merose', 'O', 'IT', '09239187293', 'image1.jpg', 17, 1, 'finish', '', 156153, 0),
(2, 'Arivas', 'Christian', 'Luar', 'SHS', '09239187293', 'image1.jpg', 17, 2, 'finish', '', 319691, 0),
(3, 'Ygot', 'John Marie', 'Biwang', 'Dent', '09239187293', 'image1.jpg', 17, 3, 'finish', '', 539217, 0),
(4, 'Palomares', 'Sanvie', 'P', 'opto', '09212265298', 'image1.jpg', 17, 4, 'finish', '', 0, 0),
(5, 'Garde', 'Duff', 'O', 'Nursing', '09212265298', 'image1.jpg', 17, 5, 'finish', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `criteria` text NOT NULL,
  `percentage` int(11) NOT NULL,
  `criteria_ctr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criteria_id`, `subevent_id`, `criteria`, `percentage`, `criteria_ctr`) VALUES
(122, 17, 'Production Number', 25, 1),
(123, 17, 'Beauty and Poise', 25, 2),
(124, 17, 'Casual Interview', 25, 3),
(125, 17, 'Evening Gown', 25, 4);

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `judge_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `judge_ctr` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `code` varchar(6) NOT NULL,
  `jtype` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `subevent_id`, `judge_ctr`, `fullname`, `code`, `jtype`) VALUES
(1, 17, 0, 'Ira Pongasi', 'a1minn', 'Chairman'),
(2, 17, 2, 'Marie Ygot', 'nf4qsh', ''),
(3, 17, 3, 'Jo Cartalla', '50kq4m', '');

-- --------------------------------------------------------

--
-- Table structure for table `main_event`
--

CREATE TABLE `main_event` (
  `mainevent_id` int(11) NOT NULL,
  `event_name` text NOT NULL,
  `status` text NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `sy` varchar(9) NOT NULL,
  `sy2` int(50) NOT NULL,
  `date_start` text NOT NULL,
  `date_end` text NOT NULL,
  `place` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `main_event`
--

INSERT INTO `main_event` (`mainevent_id`, `event_name`, `status`, `organizer_id`, `sy`, `sy2`, `date_start`, `date_end`, `place`) VALUES
(1, 'Miss Southwestern', 'activated', 40, '2023', 2024, '2023-12-12', '2023-12-16', 'swu');

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `organizer_id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `pnum` varchar(15) NOT NULL,
  `access` varchar(25) NOT NULL,
  `org_id` varchar(12) NOT NULL,
  `status` varchar(12) NOT NULL,
  `company_name` varchar(55) NOT NULL,
  `company_address` varchar(55) NOT NULL,
  `company_logo` varchar(55) NOT NULL,
  `company_telephone` varchar(55) NOT NULL,
  `company_email` varchar(55) NOT NULL,
  `company_website` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`organizer_id`, `fname`, `mname`, `lname`, `username`, `password`, `email`, `pnum`, `access`, `org_id`, `status`, `company_name`, `company_address`, `company_logo`, `company_telephone`, `company_email`, `company_website`) VALUES
(40, 'John Marie', 'Biwang', 'Ygot', 'johnygot21', '123', 'janygot21@gmail.com', '', 'Organizer', '', 'offline', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rank_system`
--

CREATE TABLE `rank_system` (
  `rs_id` int(11) NOT NULL,
  `subevent_id` varchar(12) NOT NULL,
  `contestant_id` varchar(12) NOT NULL,
  `total_rank` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_awards`
--

CREATE TABLE `special_awards` (
  `awards_id` int(11) NOT NULL,
  `subevent_id` int(11) NOT NULL,
  `special_awards` text NOT NULL,
  `score` int(11) NOT NULL,
  `awards_ctr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_awards`
--

INSERT INTO `special_awards` (`awards_id`, `subevent_id`, `special_awards`, `score`, `awards_ctr`) VALUES
(34, 17, 'Best in Gown', 10, 1),
(35, 17, 'Best in Playsuit', 10, 2),
(36, 17, 'Best in Swimsuit', 10, 3),
(37, 17, 'Best in Production', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sports_contestant`
--

CREATE TABLE `sports_contestant` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `contestant` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_contestant`
--

INSERT INTO `sports_contestant` (`id`, `event_id`, `contestant`, `date_created`) VALUES
(1, '1', 'IT Department', '2024-01-18 12:23:46'),
(2, '2', 'HR', '2024-01-18 13:02:00'),
(3, '1', 'HRM', '2024-01-18 15:35:21'),
(4, '1', 'Nursing', '2024-01-18 17:15:26'),
(5, '3', 'IT', '2024-01-19 12:42:22'),
(6, '3', 'Medtech', '2024-01-19 12:42:36'),
(7, '3', 'CS', '2024-01-19 12:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `sports_event`
--

CREATE TABLE `sports_event` (
  `id` int(11) NOT NULL,
  `sport_event_name` text NOT NULL,
  `from_year` text NOT NULL,
  `to_year` text NOT NULL,
  `date_start` text NOT NULL,
  `date_end` text NOT NULL,
  `venue` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_event`
--

INSERT INTO `sports_event` (`id`, `sport_event_name`, `from_year`, `to_year`, `date_start`, `date_end`, `venue`, `date_created`) VALUES
(1, 'sample', '2019', '2022', '2024-01-18', '2024-01-18', 'test', '2024-01-18 11:26:02'),
(2, 'sample2', '2022', '2022', '2024-01-18', '2024-01-18', 'asd', '2024-01-18 11:27:54'),
(3, 'Intrams', '2023', '2024', '2024-01-19', '2024-01-19', 'Court', '2024-01-19 12:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `sports_management`
--

CREATE TABLE `sports_management` (
  `sports_event_id` int(11) NOT NULL,
  `sport_event_name` text NOT NULL,
  `status` text NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `sy_1` varchar(11) NOT NULL,
  `sy_2` varchar(11) NOT NULL,
  `dateStart` text NOT NULL,
  `dateEnd` text NOT NULL,
  `venue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_management`
--

INSERT INTO `sports_management` (`sports_event_id`, `sport_event_name`, `status`, `organizer_id`, `sy_1`, `sy_2`, `dateStart`, `dateEnd`, `venue`) VALUES
(17, 'Siglakas', 'activated', 40, '2023', '2024', '2024-01-03', '2024-01-06', 'sw');

-- --------------------------------------------------------

--
-- Table structure for table `sports_name`
--

CREATE TABLE `sports_name` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_name`
--

INSERT INTO `sports_name` (`id`, `event_id`, `name`, `date_created`) VALUES
(1, 1, 'Basketball', '2024-01-18 12:33:31'),
(2, 1, 'Volleyball', '2024-01-18 13:00:01'),
(3, 2, 'Football', '2024-01-18 13:02:09'),
(5, 3, 'Basketball Intrams', '2024-01-19 12:43:00'),
(6, 3, 'Volleyball Intrams', '2024-01-19 12:43:09'),
(7, 3, 'Badminton Intrams', '2024-01-19 12:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `sports_tabulation`
--

CREATE TABLE `sports_tabulation` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `sports_name_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `rank` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_tabulation`
--

INSERT INTO `sports_tabulation` (`id`, `event_id`, `sports_name_id`, `contestant_id`, `rank`) VALUES
(19, 1, 1, 1, '2'),
(20, 1, 2, 1, '2'),
(21, 1, 1, 3, '1'),
(22, 1, 2, 3, '1'),
(23, 1, 1, 4, '3'),
(24, 1, 2, 4, '3'),
(59, 3, 5, 5, '1'),
(60, 3, 6, 5, '1'),
(61, 3, 7, 5, '1'),
(62, 3, 5, 6, '2'),
(63, 3, 6, 6, '2'),
(64, 3, 7, 6, '2'),
(65, 3, 5, 7, '3'),
(66, 3, 6, 7, '3'),
(67, 3, 7, 7, '3');

-- --------------------------------------------------------

--
-- Table structure for table `sports_tagging`
--

CREATE TABLE `sports_tagging` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `contestant_id` text NOT NULL,
  `sports_name_id` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports_tagging`
--

INSERT INTO `sports_tagging` (`id`, `event_id`, `contestant_id`, `sports_name_id`, `status`) VALUES
(27, '2', '2', '3', '1'),
(48, '1', '1', '1', '1'),
(49, '1', '1', '2', '1'),
(50, '1', '3', '1', '1'),
(51, '1', '3', '2', '1'),
(52, '1', '4', '1', '1'),
(53, '1', '4', '2', '1'),
(88, '3', '5', '5', '1'),
(89, '3', '5', '6', '1'),
(90, '3', '5', '7', '1'),
(91, '3', '6', '5', '1'),
(92, '3', '6', '6', '1'),
(93, '3', '6', '7', '1'),
(94, '3', '7', '5', '1'),
(95, '3', '7', '6', '1'),
(96, '3', '7', '7', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_event`
--

CREATE TABLE `sub_event` (
  `subevent_id` int(11) NOT NULL,
  `mainevent_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_name` text NOT NULL,
  `status` text NOT NULL,
  `eventdate` text NOT NULL,
  `eventtime` text NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `place` text NOT NULL,
  `event_banner` varchar(255) NOT NULL,
  `txtpoll_status` text NOT NULL,
  `view` varchar(15) NOT NULL,
  `txtpollview` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_event`
--

INSERT INTO `sub_event` (`subevent_id`, `mainevent_id`, `organizer_id`, `event_name`, `status`, `eventdate`, `eventtime`, `event_type`, `place`, `event_banner`, `txtpoll_status`, `view`, `txtpollview`) VALUES
(17, 1, 40, 'Elimination Round - Miss Southwestern', 'activated', '2023-12-13', '11:24', 'Non-Academic', 'swu', 'uploads/Miss Southwestern (1).png', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_results`
--

CREATE TABLE `sub_results` (
  `subresult_id` int(11) NOT NULL,
  `subevent_id` int(11) DEFAULT NULL,
  `mainevent_id` int(11) DEFAULT NULL,
  `contestant_id` int(11) NOT NULL,
  `judge_id` int(11) DEFAULT NULL,
  `total_score` decimal(11,1) NOT NULL,
  `deduction` int(11) DEFAULT NULL,
  `criteria_ctr1` decimal(11,1) DEFAULT NULL,
  `criteria_ctr2` decimal(11,1) DEFAULT NULL,
  `criteria_ctr3` decimal(11,1) DEFAULT NULL,
  `criteria_ctr4` decimal(11,1) DEFAULT NULL,
  `criteria_ctr5` decimal(11,1) DEFAULT NULL,
  `criteria_ctr6` decimal(11,1) DEFAULT NULL,
  `criteria_ctr7` decimal(11,1) DEFAULT NULL,
  `criteria_ctr8` decimal(11,1) DEFAULT NULL,
  `criteria_ctr9` decimal(11,1) DEFAULT NULL,
  `criteria_ctr10` decimal(11,1) DEFAULT NULL,
  `comments` longtext NOT NULL,
  `comments2` longtext NOT NULL,
  `rank` varchar(11) NOT NULL,
  `judge_rank_stat` varchar(15) DEFAULT NULL,
  `place_title` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_results`
--

INSERT INTO `sub_results` (`subresult_id`, `subevent_id`, `mainevent_id`, `contestant_id`, `judge_id`, `total_score`, `deduction`, `criteria_ctr1`, `criteria_ctr2`, `criteria_ctr3`, `criteria_ctr4`, `criteria_ctr5`, `criteria_ctr6`, `criteria_ctr7`, `criteria_ctr8`, `criteria_ctr9`, `criteria_ctr10`, `comments`, `comments2`, `rank`, `judge_rank_stat`, `place_title`) VALUES
(367, 17, 1, 1, 1, 92.0, NULL, 23.0, 23.0, 23.0, 23.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', '4th'),
(368, 17, 1, 2, 1, 91.0, NULL, 21.0, 21.0, 24.0, 25.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '3rd'),
(369, 17, 1, 3, 1, 84.0, NULL, 21.0, 21.0, 21.0, 21.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '2nd'),
(370, 17, 1, 4, 1, 88.0, NULL, 21.0, 23.0, 22.0, 22.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '1st'),
(371, 17, 1, 5, 1, 75.0, NULL, 21.0, 24.0, 15.0, 15.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', NULL, '5th'),
(372, 17, 1, 1, 2, 84.0, NULL, 21.0, 21.0, 21.0, 21.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', '', '4th'),
(373, 17, 1, 2, 2, 92.0, NULL, 23.0, 23.0, 23.0, 23.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '3rd'),
(374, 17, 1, 3, 2, 87.0, NULL, 24.0, 21.0, 21.0, 21.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '2nd'),
(375, 17, 1, 4, 2, 89.0, NULL, 25.0, 21.0, 21.0, 22.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '1st'),
(376, 17, 1, 5, 2, 96.0, NULL, 24.0, 24.0, 24.0, 24.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', NULL, '5th'),
(377, 17, 1, 1, 3, 96.0, NULL, 24.0, 24.0, 24.0, 24.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '4th'),
(378, 17, 1, 2, 3, 89.0, NULL, 23.0, 21.0, 22.0, 23.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '3rd'),
(379, 17, 1, 3, 3, 87.0, NULL, 21.0, 22.0, 22.0, 22.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '2nd'),
(380, 17, 1, 4, 3, 98.0, NULL, 25.0, 24.0, 25.0, 24.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', '1st'),
(381, 17, 1, 5, 3, 86.0, NULL, 21.0, 21.0, 21.0, 23.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', NULL, '5th');

-- --------------------------------------------------------

--
-- Table structure for table `sub_results_awards`
--

CREATE TABLE `sub_results_awards` (
  `subresult_awards_id` int(11) NOT NULL,
  `subevent_id` int(11) DEFAULT NULL,
  `mainevent_id` int(11) DEFAULT NULL,
  `contestant_id` int(11) NOT NULL,
  `judge_id` int(11) DEFAULT NULL,
  `total_score` decimal(11,1) NOT NULL,
  `deduction` int(11) DEFAULT NULL,
  `awards_ctr1` decimal(11,1) DEFAULT NULL,
  `awards_ctr2` decimal(11,1) DEFAULT NULL,
  `awards_ctr3` decimal(11,1) DEFAULT NULL,
  `awards_ctr4` decimal(11,1) DEFAULT NULL,
  `awards_ctr5` decimal(11,1) DEFAULT NULL,
  `awards_ctr6` decimal(11,1) DEFAULT NULL,
  `awards_ctr7` decimal(11,1) DEFAULT NULL,
  `awards_ctr8` decimal(11,1) DEFAULT NULL,
  `awards_ctr9` decimal(11,1) DEFAULT NULL,
  `awards_ctr10` decimal(11,1) DEFAULT NULL,
  `comments` longtext NOT NULL,
  `comments2` longtext NOT NULL,
  `rank` varchar(11) NOT NULL,
  `judge_rank_stat` varchar(15) DEFAULT NULL,
  `place_title` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_results_awards`
--

INSERT INTO `sub_results_awards` (`subresult_awards_id`, `subevent_id`, `mainevent_id`, `contestant_id`, `judge_id`, `total_score`, `deduction`, `awards_ctr1`, `awards_ctr2`, `awards_ctr3`, `awards_ctr4`, `awards_ctr5`, `awards_ctr6`, `awards_ctr7`, `awards_ctr8`, `awards_ctr9`, `awards_ctr10`, `comments`, `comments2`, `rank`, `judge_rank_stat`, `place_title`) VALUES
(18, 17, 1, 1, 1, 24.0, NULL, 6.0, 6.0, 6.0, 6.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', NULL),
(19, 17, 1, 2, 1, 28.0, NULL, 7.0, 7.0, 7.0, 7.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', NULL),
(20, 17, 1, 3, 1, 32.0, NULL, 8.0, 8.0, 8.0, 8.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', NULL),
(21, 17, 1, 4, 1, 36.0, NULL, 9.0, 9.0, 9.0, 9.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', NULL),
(22, 17, 1, 5, 1, 20.0, NULL, 5.0, 5.0, 5.0, 5.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', NULL, NULL),
(23, 17, 1, 1, 2, 12.0, NULL, 3.0, 3.0, 3.0, 3.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', '', NULL),
(24, 17, 1, 2, 2, 18.0, NULL, 3.0, 3.0, 5.0, 7.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', NULL),
(25, 17, 1, 3, 2, 22.0, NULL, 6.0, 5.0, 4.0, 7.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', NULL),
(26, 17, 1, 4, 2, 28.0, NULL, 9.0, 8.0, 6.0, 5.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', NULL),
(27, 17, 1, 5, 2, 23.0, NULL, 5.0, 7.0, 9.0, 2.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', NULL, NULL),
(28, 17, 1, 1, 3, 32.0, NULL, 8.0, 8.0, 8.0, 8.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', NULL),
(29, 17, 1, 2, 3, 30.0, NULL, 9.0, 8.0, 7.0, 6.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', NULL),
(30, 17, 1, 3, 3, 29.0, NULL, 10.0, 5.0, 6.0, 8.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', NULL),
(31, 17, 1, 4, 3, 31.0, NULL, 7.0, 8.0, 9.0, 7.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', NULL),
(32, 17, 1, 5, 3, 27.0, NULL, 6.0, 6.0, 7.0, 8.0, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '5', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestants`
--
ALTER TABLE `contestants`
  ADD PRIMARY KEY (`contestant_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteria_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`judge_id`);

--
-- Indexes for table `main_event`
--
ALTER TABLE `main_event`
  ADD PRIMARY KEY (`mainevent_id`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`organizer_id`);

--
-- Indexes for table `rank_system`
--
ALTER TABLE `rank_system`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `special_awards`
--
ALTER TABLE `special_awards`
  ADD PRIMARY KEY (`awards_id`);

--
-- Indexes for table `sports_contestant`
--
ALTER TABLE `sports_contestant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_event`
--
ALTER TABLE `sports_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_management`
--
ALTER TABLE `sports_management`
  ADD PRIMARY KEY (`sports_event_id`);

--
-- Indexes for table `sports_name`
--
ALTER TABLE `sports_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_tabulation`
--
ALTER TABLE `sports_tabulation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_tagging`
--
ALTER TABLE `sports_tagging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_event`
--
ALTER TABLE `sub_event`
  ADD PRIMARY KEY (`subevent_id`);

--
-- Indexes for table `sub_results`
--
ALTER TABLE `sub_results`
  ADD PRIMARY KEY (`subresult_id`);

--
-- Indexes for table `sub_results_awards`
--
ALTER TABLE `sub_results_awards`
  ADD PRIMARY KEY (`subresult_awards_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestants`
--
ALTER TABLE `contestants`
  MODIFY `contestant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `main_event`
--
ALTER TABLE `main_event`
  MODIFY `mainevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `rank_system`
--
ALTER TABLE `rank_system`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `special_awards`
--
ALTER TABLE `special_awards`
  MODIFY `awards_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sports_contestant`
--
ALTER TABLE `sports_contestant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sports_event`
--
ALTER TABLE `sports_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sports_management`
--
ALTER TABLE `sports_management`
  MODIFY `sports_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sports_name`
--
ALTER TABLE `sports_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sports_tabulation`
--
ALTER TABLE `sports_tabulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `sports_tagging`
--
ALTER TABLE `sports_tagging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `sub_event`
--
ALTER TABLE `sub_event`
  MODIFY `subevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sub_results`
--
ALTER TABLE `sub_results`
  MODIFY `subresult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT for table `sub_results_awards`
--
ALTER TABLE `sub_results_awards`
  MODIFY `subresult_awards_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
