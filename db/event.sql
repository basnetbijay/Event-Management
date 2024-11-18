-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 02:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'sports'),
(2, 'technicalEvents'),
(3, 'farewellWelcome'),
(4, 'music');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `event_id`, `user_id`, `message`, `created_at`) VALUES
(31, 63, 40, 'Hello, tell me more about the event please', '2024-11-10 03:21:59'),
(32, 63, 38, 'I will tell you about it after the full detail rolls out.', '2024-11-10 03:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_picture` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `event_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_description`, `event_picture`, `created_at`, `status`, `user_id`, `email`, `venue_id`, `category`, `event_date`) VALUES
(53, 'Sports', 'Sports Week 2081', 'uploads/sports2.jpg', '2024-11-09 09:33:45', 'approved', 31, 'admin@gmail.com', 14, 'sports', '2024-12-17'),
(61, 'Welcome and farewell', 'A event to welcome the new students and to provide a farewell to the dedicated the student', 'uploads/welcome.jpg', '2024-11-10 03:05:52', 'approved', 31, 'admin@gmail.com', 27, 'farewellWelcome', '2024-11-12'),
(62, 'Internship', 'A Hands-On-Feel on landing a internship as per the interest.', 'uploads/internship.jpg', '2024-11-10 03:11:12', 'approved', 31, 'admin@gmail.com', NULL, 'technicalEvents', '2024-11-16'),
(63, 'Internship - Last Chance', 'A last Chance for the students to land a intership', 'uploads/internship.jpg', '2024-11-10 03:14:03', 'approved', 38, 'bjsyang33@gmail.com', 11, 'technicalEvents', '2024-11-17'),
(64, 'Hackathon', 'Event to increase individual coding skill', 'uploads/images.png', '2024-11-10 03:25:03', 'approved', 38, 'bjsyang33@gmail.com', 11, 'technicalEvents', '2024-11-30'),
(76, 'New Sports', 'More to come', 'uploads/welcome.jpg', '2024-11-14 02:06:10', 'approved', 38, 'bjsyang33@gmail.com', 14, 'sports', '2024-11-30'),
(78, 'BCA - Sports', 'New Bca sports', 'uploads/download.png', '2024-11-14 03:15:21', 'approved', 42, 'stephen@gmail.com', 20, 'sports', '2024-11-23'),
(79, 'BCA - Hackerthon', 'Hackerthon for BCA', 'uploads/The-Art-of-Successful-Hackathon-Management (1).jpg', '2024-11-14 03:23:14', 'approved', 38, 'bjsyang33@gmail.com', 15, 'technicalEvents', '2024-11-27'),
(80, 'BSCIT - Sports', 'Only for bscit', 'uploads/images.jpg', '2024-11-14 03:28:25', 'approved', 42, 'stephen@gmail.com', 14, 'sports', '2024-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `event_member`
--

CREATE TABLE `event_member` (
  `mid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` enum('Manager','Assistant','Member','Host') DEFAULT NULL,
  `responsibility` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_member`
--

INSERT INTO `event_member` (`mid`, `id`, `event_id`, `email`, `role`, `responsibility`) VALUES
(19, 33, 21, 'bijay.basnet2057@gmail.com', 'Host', 'Host of the Event'),
(58, 37, 60, 'bijay.077bca005@acem.edu.np', 'Host', 'Host of the Event'),
(61, 38, 63, 'bjsyang33@gmail.com', 'Host', 'Host of the Event'),
(62, 39, 63, 'bijay.077bca005@acem.edu.np', 'Assistant', 'Manage the event'),
(63, 40, 63, 'bipin.077bca007@acem.edu.np', 'Member', 'Coordinate'),
(64, 38, 64, 'bjsyang33@gmail.com', 'Host', 'Host of the Event'),
(65, 40, 65, 'bipin.077bca007@acem.edu.np', 'Host', 'Host of the Event'),
(66, 41, 66, 'biju@gmail.com', 'Host', 'Host of the Event'),
(67, 36, 67, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(68, 39, 68, 'bijay.077bca005@acem.edu.np', 'Host', 'Host of the Event'),
(69, 36, 69, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(70, 36, 70, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(71, 36, 71, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(72, 36, 72, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(73, 36, 73, 'shwetath427@gmail.com', 'Host', 'Host of the Event'),
(74, 39, 74, 'bijay.077bca005@acem.edu.np', 'Host', 'Host of the Event'),
(75, 39, 75, 'bijay.077bca005@acem.edu.np', 'Host', 'Host of the Event'),
(76, 38, 76, 'bjsyang33@gmail.com', 'Host', 'Host of the Event'),
(77, 38, 77, 'bjsyang33@gmail.com', 'Host', 'Host of the Event'),
(78, 42, 78, 'stephen@gmail.com', 'Host', 'Host of the Event'),
(79, 38, 79, 'bjsyang33@gmail.com', 'Host', 'Host of the Event'),
(80, 42, 80, 'stephen@gmail.com', 'Host', 'Host of the Event');

-- --------------------------------------------------------

--
-- Table structure for table `event_notifications`
--

CREATE TABLE `event_notifications` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_notifications`
--

INSERT INTO `event_notifications` (`id`, `user_email`, `event_name`) VALUES
(86, 'admin@gmail.com', 'ACEM Music Festival'),
(217, 'admin@gmail.com', 'adsfasd'),
(109, 'admin@gmail.com', 'asdfa'),
(223, 'admin@gmail.com', 'asdqdqsdqd'),
(84, 'admin@gmail.com', 'Basketball torunament'),
(324, 'admin@gmail.com', 'BCA - Hackerthon'),
(311, 'admin@gmail.com', 'BCA - Sports'),
(83, 'admin@gmail.com', 'BCA Hackathon'),
(131, 'admin@gmail.com', 'bijay basnet'),
(156, 'admin@gmail.com', 'Bijay Syangtan'),
(331, 'admin@gmail.com', 'BSCIT - Sports'),
(257, 'admin@gmail.com', 'dasfadsfadfadfa'),
(5, 'admin@gmail.com', 'Election 2081'),
(4, 'admin@gmail.com', 'farewell'),
(2, 'admin@gmail.com', 'Farewell Program BCA'),
(264, 'admin@gmail.com', 'gfnhm,mh'),
(211, 'admin@gmail.com', 'Hackathon'),
(53, 'admin@gmail.com', 'inter College Football'),
(244, 'admin@gmail.com', 'Internship'),
(245, 'admin@gmail.com', 'Internship - Last Chance'),
(1, 'admin@gmail.com', 'Music Fest 2024'),
(106, 'admin@gmail.com', 'musical nights'),
(305, 'admin@gmail.com', 'New Sports'),
(283, 'admin@gmail.com', 'reject'),
(3, 'admin@gmail.com', 'sports'),
(82, 'admin@gmail.com', 'Sports Fest'),
(6, 'admin@gmail.com', 'Technical Fest'),
(295, 'admin@gmail.com', 'test'),
(276, 'admin@gmail.com', 'test for aprova'),
(85, 'admin@gmail.com', 'Test for assign venue'),
(107, 'admin@gmail.com', 'test for venue'),
(269, 'admin@gmail.com', 'test test'),
(108, 'admin@gmail.com', 'test test 27'),
(229, 'admin@gmail.com', 'testing for email'),
(242, 'admin@gmail.com', 'testing for rejection'),
(284, 'admin@gmail.com', 'tets'),
(181, 'admin@gmail.com', 'VattaSaroj'),
(71, 'admin@gmail.com', 'Welcome and farewell'),
(91, 'bhatta@gmail.com', 'ACEM Music Festival'),
(113, 'bhatta@gmail.com', 'asdfa'),
(89, 'bhatta@gmail.com', 'Basketball torunament'),
(88, 'bhatta@gmail.com', 'BCA Hackathon'),
(132, 'bhatta@gmail.com', 'bijay basnet'),
(157, 'bhatta@gmail.com', 'Bijay Syangtan'),
(11, 'bhatta@gmail.com', 'Election 2081'),
(10, 'bhatta@gmail.com', 'farewell'),
(8, 'bhatta@gmail.com', 'Farewell Program BCA'),
(54, 'bhatta@gmail.com', 'inter College Football'),
(7, 'bhatta@gmail.com', 'Music Fest 2024'),
(110, 'bhatta@gmail.com', 'musical nights'),
(9, 'bhatta@gmail.com', 'sports'),
(87, 'bhatta@gmail.com', 'Sports Fest'),
(12, 'bhatta@gmail.com', 'Technical Fest'),
(90, 'bhatta@gmail.com', 'Test for assign venue'),
(111, 'bhatta@gmail.com', 'test for venue'),
(112, 'bhatta@gmail.com', 'test test 27'),
(182, 'bhatta@gmail.com', 'VattaSaroj'),
(72, 'bhatta@gmail.com', 'Welcome and farewell'),
(239, 'bijay.077bca005@acem.edu.np', 'adsfasd'),
(240, 'bijay.077bca005@acem.edu.np', 'asdqdqsdqd'),
(325, 'bijay.077bca005@acem.edu.np', 'BCA - Hackerthon'),
(312, 'bijay.077bca005@acem.edu.np', 'BCA - Sports'),
(332, 'bijay.077bca005@acem.edu.np', 'BSCIT - Sports'),
(258, 'bijay.077bca005@acem.edu.np', 'dasfadsfadfadfa'),
(265, 'bijay.077bca005@acem.edu.np', 'gfnhm,mh'),
(238, 'bijay.077bca005@acem.edu.np', 'Hackathon'),
(300, 'bijay.077bca005@acem.edu.np', 'Internship'),
(249, 'bijay.077bca005@acem.edu.np', 'Internship - Last Chance'),
(236, 'bijay.077bca005@acem.edu.np', 'Music Fest 2024'),
(306, 'bijay.077bca005@acem.edu.np', 'New Sports'),
(285, 'bijay.077bca005@acem.edu.np', 'reject'),
(237, 'bijay.077bca005@acem.edu.np', 'Sports'),
(235, 'bijay.077bca005@acem.edu.np', 'Sports Fest'),
(296, 'bijay.077bca005@acem.edu.np', 'test'),
(277, 'bijay.077bca005@acem.edu.np', 'test for aprova'),
(270, 'bijay.077bca005@acem.edu.np', 'test test'),
(241, 'bijay.077bca005@acem.edu.np', 'testing for email'),
(286, 'bijay.077bca005@acem.edu.np', 'tets'),
(248, 'bijay.077bca005@acem.edu.np', 'Welcome and farewell'),
(96, 'bijay.basnet2057@gmail.com', 'ACEM Music Festival'),
(218, 'bijay.basnet2057@gmail.com', 'adsfasd'),
(117, 'bijay.basnet2057@gmail.com', 'asdfa'),
(224, 'bijay.basnet2057@gmail.com', 'asdqdqsdqd'),
(94, 'bijay.basnet2057@gmail.com', 'Basketball torunament'),
(93, 'bijay.basnet2057@gmail.com', 'BCA Hackathon'),
(133, 'bijay.basnet2057@gmail.com', 'bijay basnet'),
(158, 'bijay.basnet2057@gmail.com', 'Bijay Syangtan'),
(17, 'bijay.basnet2057@gmail.com', 'Election 2081'),
(16, 'bijay.basnet2057@gmail.com', 'farewell'),
(14, 'bijay.basnet2057@gmail.com', 'Farewell Program BCA'),
(212, 'bijay.basnet2057@gmail.com', 'Hackathon'),
(55, 'bijay.basnet2057@gmail.com', 'inter College Football'),
(13, 'bijay.basnet2057@gmail.com', 'Music Fest 2024'),
(114, 'bijay.basnet2057@gmail.com', 'musical nights'),
(15, 'bijay.basnet2057@gmail.com', 'sports'),
(92, 'bijay.basnet2057@gmail.com', 'Sports Fest'),
(19, 'bijay.basnet2057@gmail.com', 'Technical Fest'),
(95, 'bijay.basnet2057@gmail.com', 'Test for assign venue'),
(115, 'bijay.basnet2057@gmail.com', 'test for venue'),
(116, 'bijay.basnet2057@gmail.com', 'test test 27'),
(230, 'bijay.basnet2057@gmail.com', 'testing for email'),
(183, 'bijay.basnet2057@gmail.com', 'VattaSaroj'),
(73, 'bijay.basnet2057@gmail.com', 'Welcome and farewell'),
(103, 'bijay@gmail.com', 'ACEM Music Festival'),
(121, 'bijay@gmail.com', 'asdfa'),
(100, 'bijay@gmail.com', 'Basketball torunament'),
(99, 'bijay@gmail.com', 'BCA Hackathon'),
(134, 'bijay@gmail.com', 'bijay basnet'),
(159, 'bijay@gmail.com', 'Bijay Syangtan'),
(98, 'bijay@gmail.com', 'Farewell Program BCA'),
(101, 'bijay@gmail.com', 'Music Fest 2024'),
(118, 'bijay@gmail.com', 'musical nights'),
(97, 'bijay@gmail.com', 'Sports Fest'),
(102, 'bijay@gmail.com', 'Test for assign venue'),
(119, 'bijay@gmail.com', 'test for venue'),
(120, 'bijay@gmail.com', 'test test 27'),
(184, 'bijay@gmail.com', 'VattaSaroj'),
(126, 'biju@gmail.com', 'asdfa'),
(326, 'biju@gmail.com', 'BCA - Hackerthon'),
(313, 'biju@gmail.com', 'BCA - Sports'),
(105, 'biju@gmail.com', 'BCA Hackathon'),
(135, 'biju@gmail.com', 'bijay basnet'),
(160, 'biju@gmail.com', 'Bijay Syangtan'),
(333, 'biju@gmail.com', 'BSCIT - Sports'),
(259, 'biju@gmail.com', 'dasfadsfadfadfa'),
(24, 'biju@gmail.com', 'Election 2081'),
(23, 'biju@gmail.com', 'farewell'),
(21, 'biju@gmail.com', 'Farewell Program BCA'),
(266, 'biju@gmail.com', 'gfnhm,mh'),
(256, 'biju@gmail.com', 'Hackathon'),
(56, 'biju@gmail.com', 'inter College Football'),
(301, 'biju@gmail.com', 'Internship'),
(255, 'biju@gmail.com', 'Internship - Last Chance'),
(20, 'biju@gmail.com', 'Music Fest 2024'),
(123, 'biju@gmail.com', 'musical nights'),
(307, 'biju@gmail.com', 'New Sports'),
(287, 'biju@gmail.com', 'reject'),
(22, 'biju@gmail.com', 'sports'),
(104, 'biju@gmail.com', 'Sports Fest'),
(25, 'biju@gmail.com', 'Technical Fest'),
(297, 'biju@gmail.com', 'test'),
(278, 'biju@gmail.com', 'test for aprova'),
(122, 'biju@gmail.com', 'Test for assign venue'),
(124, 'biju@gmail.com', 'test for venue'),
(271, 'biju@gmail.com', 'test test'),
(125, 'biju@gmail.com', 'test test 27'),
(288, 'biju@gmail.com', 'tets'),
(185, 'biju@gmail.com', 'VattaSaroj'),
(74, 'biju@gmail.com', 'Welcome and farewell'),
(327, 'bipin.077bca007@acem.edu.np', 'BCA - Hackerthon'),
(314, 'bipin.077bca007@acem.edu.np', 'BCA - Sports'),
(334, 'bipin.077bca007@acem.edu.np', 'BSCIT - Sports'),
(260, 'bipin.077bca007@acem.edu.np', 'dasfadsfadfadfa'),
(267, 'bipin.077bca007@acem.edu.np', 'gfnhm,mh'),
(253, 'bipin.077bca007@acem.edu.np', 'Hackathon'),
(302, 'bipin.077bca007@acem.edu.np', 'Internship'),
(252, 'bipin.077bca007@acem.edu.np', 'Internship - Last Chance'),
(275, 'bipin.077bca007@acem.edu.np', 'Music Fest 2024'),
(308, 'bipin.077bca007@acem.edu.np', 'New Sports'),
(289, 'bipin.077bca007@acem.edu.np', 'reject'),
(250, 'bipin.077bca007@acem.edu.np', 'Sports'),
(298, 'bipin.077bca007@acem.edu.np', 'test'),
(279, 'bipin.077bca007@acem.edu.np', 'test for aprova'),
(272, 'bipin.077bca007@acem.edu.np', 'test test'),
(290, 'bipin.077bca007@acem.edu.np', 'tets'),
(251, 'bipin.077bca007@acem.edu.np', 'Welcome and farewell'),
(138, 'bjsyang33@gmail.com', 'asdfa'),
(328, 'bjsyang33@gmail.com', 'BCA - Hackerthon'),
(315, 'bjsyang33@gmail.com', 'BCA - Sports'),
(128, 'bjsyang33@gmail.com', 'BCA Hackathon'),
(139, 'bjsyang33@gmail.com', 'bijay basnet'),
(161, 'bjsyang33@gmail.com', 'Bijay Syangtan'),
(335, 'bjsyang33@gmail.com', 'BSCIT - Sports'),
(261, 'bjsyang33@gmail.com', 'dasfadsfadfadfa'),
(30, 'bjsyang33@gmail.com', 'Election 2081'),
(29, 'bjsyang33@gmail.com', 'farewell'),
(27, 'bjsyang33@gmail.com', 'Farewell Program BCA'),
(268, 'bjsyang33@gmail.com', 'gfnhm,mh'),
(254, 'bjsyang33@gmail.com', 'Hackathon'),
(57, 'bjsyang33@gmail.com', 'inter College Football'),
(303, 'bjsyang33@gmail.com', 'Internship'),
(246, 'bjsyang33@gmail.com', 'Internship - Last Chance'),
(26, 'bjsyang33@gmail.com', 'Music Fest 2024'),
(130, 'bjsyang33@gmail.com', 'musical nights'),
(309, 'bjsyang33@gmail.com', 'New Sports'),
(291, 'bjsyang33@gmail.com', 'reject'),
(28, 'bjsyang33@gmail.com', 'sports'),
(127, 'bjsyang33@gmail.com', 'Sports Fest'),
(31, 'bjsyang33@gmail.com', 'Technical Fest'),
(299, 'bjsyang33@gmail.com', 'test'),
(280, 'bjsyang33@gmail.com', 'test for aprova'),
(129, 'bjsyang33@gmail.com', 'Test for assign venue'),
(136, 'bjsyang33@gmail.com', 'test for venue'),
(273, 'bjsyang33@gmail.com', 'test test'),
(137, 'bjsyang33@gmail.com', 'test test 27'),
(292, 'bjsyang33@gmail.com', 'tets'),
(186, 'bjsyang33@gmail.com', 'VattaSaroj'),
(75, 'bjsyang33@gmail.com', 'Welcome and farewell'),
(219, 'corona@gmail.com', 'adsfasd'),
(146, 'corona@gmail.com', 'asdfa'),
(225, 'corona@gmail.com', 'asdqdqsdqd'),
(141, 'corona@gmail.com', 'BCA Hackathon'),
(147, 'corona@gmail.com', 'bijay basnet'),
(162, 'corona@gmail.com', 'Bijay Syangtan'),
(36, 'corona@gmail.com', 'Election 2081'),
(35, 'corona@gmail.com', 'farewell'),
(33, 'corona@gmail.com', 'Farewell Program BCA'),
(213, 'corona@gmail.com', 'Hackathon'),
(58, 'corona@gmail.com', 'inter College Football'),
(32, 'corona@gmail.com', 'Music Fest 2024'),
(143, 'corona@gmail.com', 'musical nights'),
(34, 'corona@gmail.com', 'sports'),
(140, 'corona@gmail.com', 'Sports Fest'),
(38, 'corona@gmail.com', 'Technical Fest'),
(142, 'corona@gmail.com', 'Test for assign venue'),
(144, 'corona@gmail.com', 'test for venue'),
(145, 'corona@gmail.com', 'test test 27'),
(231, 'corona@gmail.com', 'testing for email'),
(187, 'corona@gmail.com', 'VattaSaroj'),
(76, 'corona@gmail.com', 'Welcome and farewell'),
(154, 'govinda@gmail.com', 'asdfa'),
(149, 'govinda@gmail.com', 'BCA Hackathon'),
(155, 'govinda@gmail.com', 'bijay basnet'),
(163, 'govinda@gmail.com', 'Bijay Syangtan'),
(43, 'govinda@gmail.com', 'Election 2081'),
(42, 'govinda@gmail.com', 'farewell'),
(40, 'govinda@gmail.com', 'Farewell Program BCA'),
(59, 'govinda@gmail.com', 'inter College Football'),
(39, 'govinda@gmail.com', 'Music Fest 2024'),
(151, 'govinda@gmail.com', 'musical nights'),
(41, 'govinda@gmail.com', 'sports'),
(148, 'govinda@gmail.com', 'Sports Fest'),
(44, 'govinda@gmail.com', 'Technical Fest'),
(150, 'govinda@gmail.com', 'Test for assign venue'),
(152, 'govinda@gmail.com', 'test for venue'),
(153, 'govinda@gmail.com', 'test test 27'),
(188, 'govinda@gmail.com', 'VattaSaroj'),
(77, 'govinda@gmail.com', 'Welcome and farewell'),
(170, 'hari@gmail.com', 'asdfa'),
(165, 'hari@gmail.com', 'BCA Hackathon'),
(171, 'hari@gmail.com', 'bijay basnet'),
(172, 'hari@gmail.com', 'Bijay Syangtan'),
(49, 'hari@gmail.com', 'Election 2081'),
(48, 'hari@gmail.com', 'farewell'),
(46, 'hari@gmail.com', 'Farewell Program BCA'),
(60, 'hari@gmail.com', 'inter College Football'),
(45, 'hari@gmail.com', 'Music Fest 2024'),
(167, 'hari@gmail.com', 'musical nights'),
(47, 'hari@gmail.com', 'sports'),
(164, 'hari@gmail.com', 'Sports Fest'),
(50, 'hari@gmail.com', 'Technical Fest'),
(166, 'hari@gmail.com', 'Test for assign venue'),
(168, 'hari@gmail.com', 'test for venue'),
(169, 'hari@gmail.com', 'test test 27'),
(189, 'hari@gmail.com', 'VattaSaroj'),
(78, 'hari@gmail.com', 'Welcome and farewell'),
(220, 'shweta@gmail.com', 'adsfasd'),
(179, 'shweta@gmail.com', 'asdfa'),
(226, 'shweta@gmail.com', 'asdqdqsdqd'),
(174, 'shweta@gmail.com', 'BCA Hackathon'),
(180, 'shweta@gmail.com', 'bijay basnet'),
(190, 'shweta@gmail.com', 'Bijay Syangtan'),
(63, 'shweta@gmail.com', 'Election 2081'),
(62, 'shweta@gmail.com', 'farewell'),
(52, 'shweta@gmail.com', 'Farewell Program BCA'),
(214, 'shweta@gmail.com', 'Hackathon'),
(64, 'shweta@gmail.com', 'inter College Football'),
(51, 'shweta@gmail.com', 'Music Fest 2024'),
(176, 'shweta@gmail.com', 'musical nights'),
(61, 'shweta@gmail.com', 'sports'),
(173, 'shweta@gmail.com', 'Sports Fest'),
(175, 'shweta@gmail.com', 'Test for assign venue'),
(177, 'shweta@gmail.com', 'test for venue'),
(178, 'shweta@gmail.com', 'test test 27'),
(232, 'shweta@gmail.com', 'testing for email'),
(191, 'shweta@gmail.com', 'VattaSaroj'),
(79, 'shweta@gmail.com', 'Welcome and farewell'),
(221, 'shwetath427@gmail.com', 'adsfasd'),
(227, 'shwetath427@gmail.com', 'asdqdqsdqd'),
(329, 'shwetath427@gmail.com', 'BCA - Hackerthon'),
(316, 'shwetath427@gmail.com', 'BCA - Sports'),
(336, 'shwetath427@gmail.com', 'BSCIT - Sports'),
(262, 'shwetath427@gmail.com', 'dasfadsfadfadfa'),
(263, 'shwetath427@gmail.com', 'gfnhm,mh'),
(215, 'shwetath427@gmail.com', 'Hackathon'),
(304, 'shwetath427@gmail.com', 'Internship'),
(247, 'shwetath427@gmail.com', 'Internship - Last Chance'),
(208, 'shwetath427@gmail.com', 'Music Fest 2024'),
(310, 'shwetath427@gmail.com', 'New Sports'),
(282, 'shwetath427@gmail.com', 'reject'),
(209, 'shwetath427@gmail.com', 'Sports'),
(207, 'shwetath427@gmail.com', 'Sports Fest'),
(294, 'shwetath427@gmail.com', 'test'),
(281, 'shwetath427@gmail.com', 'test for aprova'),
(274, 'shwetath427@gmail.com', 'test test'),
(233, 'shwetath427@gmail.com', 'testing for email'),
(293, 'shwetath427@gmail.com', 'tets'),
(243, 'shwetath427@gmail.com', 'Welcome and farewell'),
(198, 'shyam@gmail.com', 'asdfa'),
(193, 'shyam@gmail.com', 'BCA Hackathon'),
(199, 'shyam@gmail.com', 'bijay basnet'),
(200, 'shyam@gmail.com', 'Bijay Syangtan'),
(69, 'shyam@gmail.com', 'Election 2081'),
(68, 'shyam@gmail.com', 'farewell'),
(66, 'shyam@gmail.com', 'Farewell Program BCA'),
(70, 'shyam@gmail.com', 'inter College Football'),
(65, 'shyam@gmail.com', 'Music Fest 2024'),
(195, 'shyam@gmail.com', 'musical nights'),
(67, 'shyam@gmail.com', 'sports'),
(192, 'shyam@gmail.com', 'Sports Fest'),
(194, 'shyam@gmail.com', 'Test for assign venue'),
(196, 'shyam@gmail.com', 'test for venue'),
(197, 'shyam@gmail.com', 'test test 27'),
(201, 'shyam@gmail.com', 'VattaSaroj'),
(80, 'shyam@gmail.com', 'Welcome and farewell'),
(330, 'stephen@gmail.com', 'BCA - Hackerthon'),
(323, 'stephen@gmail.com', 'BCA - Sports'),
(337, 'stephen@gmail.com', 'BSCIT - Sports'),
(321, 'stephen@gmail.com', 'Hackathon'),
(319, 'stephen@gmail.com', 'Internship'),
(320, 'stephen@gmail.com', 'Internship - Last Chance'),
(322, 'stephen@gmail.com', 'New Sports'),
(317, 'stephen@gmail.com', 'Sports'),
(318, 'stephen@gmail.com', 'Welcome and farewell'),
(222, 'vattasaroj@gmail.com', 'adsfasd'),
(228, 'vattasaroj@gmail.com', 'asdqdqsdqd'),
(204, 'vattasaroj@gmail.com', 'BCA Hackathon'),
(203, 'vattasaroj@gmail.com', 'Farewell Program BCA'),
(216, 'vattasaroj@gmail.com', 'Hackathon'),
(205, 'vattasaroj@gmail.com', 'Music Fest 2024'),
(210, 'vattasaroj@gmail.com', 'Sports'),
(202, 'vattasaroj@gmail.com', 'Sports Fest'),
(206, 'vattasaroj@gmail.com', 'Test for assign venue'),
(234, 'vattasaroj@gmail.com', 'testing for email'),
(81, 'vattasaroj@gmail.com', 'Welcome and farewell');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `event` varchar(255) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `full_name`, `email`, `phone`, `event`, `comments`, `created_at`) VALUES
(3, 'Bijay Basnet', 'bijay@gmail.com', '9843182828', '32', 'Basketball', '2024-09-23 15:26:07'),
(5, 'Bijay Basnet', 'shiva@gmail.com', '9843182828', '53', 'singing\r\n', '2024-11-13 13:51:33'),
(6, 'bijay syangtan', 'bjsyang33@gmail.com', '9866265406', '53', 'I wnt to', '2024-11-14 02:04:51'),
(7, 'Bijay Basnet', 'bijay.basnet2057@gmail.com', '9843792922', '61', 'i want to take part in it', '2024-11-14 02:16:54'),
(8, 'Stephen Gasi', 'stephen123@gmail.com', '9863021927', '64', 'I want to participate in the event', '2024-11-14 03:11:31'),
(9, 'bijay syangtan', 'bjsyang33@gmail.com', '9866265406', '64', 'I want to participate', '2024-11-14 03:19:54'),
(10, 'bijay syangtan', 'bjsyang33@gmail.com', '9866265406', '79', 'I want to participate', '2024-11-14 03:26:15'),
(11, 'bijay syangtan', 'bjsyang33@gmail.com', '9866265406', '79', 'I want to participate', '2024-11-14 03:26:20'),
(12, 'Bijay Basnet', 'bjsyang33@gmail.com', '9843182828', '64', 'asdfasd', '2024-11-14 03:33:26'),
(13, 'Stephen Gasi', 'stephen@gmail.com', '9866265406', '64', 'part', '2024-11-14 03:43:03'),
(14, 'Stephen Gasi', 'stephen@gmail.com', '9866265406', '53', 'sports', '2024-11-14 03:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`) VALUES
(31, 'admin@gmail.com', '$2y$10$zz7tB0L9e3tFMojam41opubGvXJYN4UhP/M7p6J3pMsRTCoyz/bpy', 'admin', 'admin'),
(36, 'shwetath427@gmail.com', '$2y$10$orFfoqZc2K7AA0VdxY6JU.MRjz18/8zDa1px.7BxECeoVAbzOHHIa', 'shweta', 'thapa'),
(38, 'bjsyang33@gmail.com', '$2y$10$QN7OFM7YpxzT.UC1GGEZJuXXeYRIosZJqU2Ce/jth6kuluNT4FfQW', 'Bijay', 'syangtan'),
(39, 'bijay.077bca005@acem.edu.np', '$2y$10$RGPHL0MhkkMsRF.GA201aufGWFIIXwJ42uurhfkINTy9hxUp0EPrK', 'Bijay ', 'Basnet'),
(40, 'bipin.077bca007@acem.edu.np', '$2y$10$pZ8zoCMZLR/jL/AktPEZDuKqylSsuBeaVm5oZ2yfPEZSwILRBg/FC', 'Beepin', 'karki'),
(41, 'biju@gmail.com', '$2y$10$Rut7WG2UunB/qmXknVMNF.HDP5dQSxz6tm596m1J/BC36UpKbzdwG', 'Bijay', 'Basnet'),
(42, 'stephen@gmail.com', '$2y$10$lVywFvbnD.8G88cx4.5qK.ZKnuwC2choiqNF/ywUE458IIGr2Wo7G', 'Stephen', 'shrestha');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `venue_name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `venue_name`, `capacity`, `location`, `category`) VALUES
(1, 'Grand Ballroom', 500, 'Kalanki, Kathmandu', NULL),
(2, 'Mountain View Hall', 300, 'Banasthali, Kathmandu', 'farewellWelcome'),
(3, 'Lakeside Pavilion', 200, 'Jawalakhel, Lalitpur', 'music'),
(4, 'Heritage Garden', 150, 'Bhaktapur Durbar Square, Bhaktapur', NULL),
(5, 'Rooftop Banquet', 100, 'Pulchowk, Lalitpur', NULL),
(6, 'City Conference Center', 400, 'Baneshwor, Kathmandu', NULL),
(7, 'Sunset Terrace', 250, 'Swayambhu, Kathmandu', NULL),
(8, 'Himalayan Hall', 350, 'Godawari, Lalitpur', NULL),
(9, 'Event Plaza', 450, 'Thamel, Kathmandu', NULL),
(10, 'Academic Auditorium', 600, 'Kumaripati, Lalitpur', 'technicalEvents'),
(11, 'College Hall', 500, 'College Premises, ACEM ', 'technicalEvents'),
(14, 'Chysal', 300, 'Chysal', 'sports'),
(15, 'Acem Hall', 1000, 'balkhu', 'technicalEvents'),
(16, 'Kalanki Dance Hall', 300, 'Kalanki petrol pump, Kalanki', 'farewellWelcome'),
(17, 'Kathmandu Music Hall', 250, 'NewRoad, Kathmadnu', 'music'),
(18, 'Pragya Hall', 500, 'Nayabajar, Kathamdu', 'music'),
(19, 'Test Farewell Venue', 400, 'Test location', 'farewellWelcome'),
(20, 'Lions Sports', 150, 'Balkhu', 'sports'),
(21, 'College Hall', 2000, 'acem', 'farewellWelcome'),
(22, 'Nepal Music Hall', 350, 'Newroad, Kathmandu', 'farewellWelcome'),
(24, 'Kalanki Dance Hall', 350, 'Kalanki petrol pump, Kalanki', 'farewellWelcome'),
(25, 'Karkhana Hall', 400, 'Chappal Karkhana, Kathmandu-04, Kathmandu, Kathmandu Metropolitan City, Kathmandu, Bagmati Province, 44606, Nepal', 'technicalEvents'),
(26, 'Karkhana Hall', 400, 'Chappal Karkhana, Kathmandu-04, Kathmandu, Kathmandu Metropolitan City, Kathmandu, Bagmati Province, 44606, Nepal', 'technicalEvents'),
(27, 'Nayabazar Hall', 500, 'Hotel Darwin, nayabazar, Balaju-Sourkhutte Sadak, Nayabazar, Kathmandu-16, Kathmandu, Kathmandu Metropolitan City, Kathmandu, Bagmati Province, 44600, Nepal', 'farewellWelcome');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `event_member`
--
ALTER TABLE `event_member`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `event_notifications`
--
ALTER TABLE `event_notifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_notification` (`user_email`,`event_name`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `event_member`
--
ALTER TABLE `event_member`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `event_notifications`
--
ALTER TABLE `event_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
