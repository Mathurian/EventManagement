-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 02:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
(1, 'Garde', 'Duff', 'O', 'CITE', '09212265298', 'me.jpg', 18, 1, 'finish', '', 434519, 0),
(2, 'Arivas', 'Christian', 'Luar', 'CITE', '09212265298', 'me.jpg', 18, 2, 'finish', '', 0, 0),
(3, 'Catindoy', 'Noralyn', 'P.', 'CITE', '09212265298', 'me.jpg', 18, 3, 'finish', '', 0, 0),
(4, 'Palomares', 'Sanvie', 'P', 'CITE', '09212265298', 'me.jpg', 18, 4, 'finish', '', 0, 0),
(5, 'Ygot', 'John Marie', 'B.', 'CITE', '09212265298', 'me.jpg', 18, 5, 'finish', '', 0, 0);

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
(126, 18, 'Need and Feasibility', 30, 1),
(127, 18, 'Concept and Innovation', 25, 2),
(128, 18, 'Execution', 20, 3),
(129, 18, 'Synergy', 15, 4),
(130, 18, 'Presentation', 10, 5);

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
(4, 18, 0, 'Ira Pongasi', 'ecocv1', 'Chairman'),
(5, 18, 2, 'Desiree Perreras', '6tg2e5', ''),
(6, 18, 3, 'Jo Cartalla', 'p1pbko', '');

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
(2, 'CITE Week', 'activated', 41, '2023', 2024, '2024-02-16', '2024-02-17', 'swu');

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
(41, 'John Marie', 'Biwang', 'Ygot', 'johnygot21', '123', 'janygot21@gmail.com', '', 'Organizer', '', 'offline', '', '', '', '', '', '');

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
(11, '5', 'IT', '2024-03-25 21:43:36'),
(12, '5', 'Pharmacy', '2024-03-25 21:43:36'),
(13, '5', 'Nursing', '2024-03-25 21:43:36');

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
(5, 'Siglakas', '2024', '2025', '2024-03-25', '2024-03-29', 'swu', '2024-03-25 21:42:38');

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
(11, 5, 'Basketball', '2024-03-25 21:43:48'),
(12, 5, 'Volleyball', '2024-03-25 21:44:03'),
(13, 5, 'Futsal', '2024-03-25 21:44:03');

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
(77, 5, 11, 11, '1'),
(78, 5, 12, 11, '2'),
(79, 5, 13, 11, '1'),
(80, 5, 11, 12, '3'),
(81, 5, 12, 12, '1'),
(82, 5, 13, 12, '2'),
(83, 5, 11, 13, '2'),
(84, 5, 12, 13, '3'),
(85, 5, 13, 13, '3'),
(86, 5, 11, 14, ''),
(87, 5, 12, 14, '1'),
(88, 5, 13, 14, '3'),
(89, 5, 11, 15, ''),
(90, 5, 12, 15, '2'),
(91, 5, 13, 15, '1');

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
(106, '5', '11', '11', '1'),
(107, '5', '11', '12', '1'),
(108, '5', '11', '13', '1'),
(109, '5', '12', '11', '1'),
(110, '5', '12', '12', '1'),
(111, '5', '12', '13', '1'),
(112, '5', '13', '11', '1'),
(113, '5', '13', '12', '1'),
(114, '5', '13', '13', '1'),
(115, '5', '14', '11', '1'),
(116, '5', '14', '12', '1'),
(117, '5', '14', '13', '1'),
(118, '5', '15', '11', '1'),
(119, '5', '15', '12', '1'),
(120, '5', '15', '13', '1');

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
(18, 2, 41, 'Mini Hackathon', 'activated', '2024-02-15', '09:00', 'Non-Academic', 'swu', 'uploads/mini.png', '', '', '');

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
(382, 18, 2, 1, 4, 81.0, NULL, 25.0, 23.0, 15.0, 11.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '2nd'),
(383, 18, 2, 2, 4, 73.0, NULL, 21.0, 21.0, 14.0, 11.0, 6.0, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '3rd'),
(384, 18, 2, 3, 4, 72.0, NULL, 23.0, 24.0, 10.0, 8.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '4th'),
(385, 18, 2, 4, 4, 69.0, NULL, 20.0, 20.0, 11.0, 11.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '5', '', '5th'),
(386, 18, 2, 5, 4, 94.0, NULL, 29.0, 24.0, 18.0, 14.0, 9.0, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', '1st'),
(387, 18, 2, 1, 5, 77.0, NULL, 19.0, 21.0, 16.0, 14.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '2nd'),
(388, 18, 2, 2, 5, 84.0, NULL, 23.0, 25.0, 15.0, 11.0, 10.0, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '3rd'),
(389, 18, 2, 3, 5, 73.0, NULL, 25.0, 15.0, 16.0, 11.0, 6.0, NULL, NULL, NULL, NULL, NULL, '', '', '5', '', '4th'),
(390, 18, 2, 4, 5, 76.0, NULL, 29.0, 11.0, 16.0, 12.0, 8.0, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '5th'),
(391, 18, 2, 5, 5, 93.0, NULL, 25.0, 25.0, 18.0, 15.0, 10.0, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', '1st'),
(392, 18, 2, 1, 6, 85.0, NULL, 27.0, 23.0, 16.0, 12.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '1', '', '2nd'),
(393, 18, 2, 2, 6, 75.0, NULL, 21.0, 23.0, 14.0, 14.0, 3.0, NULL, NULL, NULL, NULL, NULL, '', '', '5', '', '3rd'),
(394, 18, 2, 3, 6, 84.0, NULL, 23.0, 23.0, 16.0, 14.0, 8.0, NULL, NULL, NULL, NULL, NULL, '', '', '2', '', '4th'),
(395, 18, 2, 4, 6, 83.0, NULL, 25.0, 22.0, 17.0, 10.0, 9.0, NULL, NULL, NULL, NULL, NULL, '', '', '3', '', '5th'),
(396, 18, 2, 5, 6, 82.0, NULL, 25.0, 21.0, 16.0, 13.0, 7.0, NULL, NULL, NULL, NULL, NULL, '', '', '4', '', '1st');

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
  MODIFY `criteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_event`
--
ALTER TABLE `main_event`
  MODIFY `mainevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sports_event`
--
ALTER TABLE `sports_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sports_management`
--
ALTER TABLE `sports_management`
  MODIFY `sports_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sports_name`
--
ALTER TABLE `sports_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sports_tabulation`
--
ALTER TABLE `sports_tabulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `sports_tagging`
--
ALTER TABLE `sports_tagging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `sub_event`
--
ALTER TABLE `sub_event`
  MODIFY `subevent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sub_results`
--
ALTER TABLE `sub_results`
  MODIFY `subresult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT for table `sub_results_awards`
--
ALTER TABLE `sub_results_awards`
  MODIFY `subresult_awards_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
