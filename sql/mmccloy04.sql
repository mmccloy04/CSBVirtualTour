-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2024 at 10:09 PM
-- Server version: 10.4.26-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmccloy04`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL,
  `asset_ref` varchar(255) NOT NULL,
  `file_path` text NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `asset_ref`, `file_path`, `type_id`) VALUES
(1, 'audio_icon', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/audio_icon.png', 3),
(2, 'video_icon', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/video_icon.png', 3),
(3, 'task_icon', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/task_icon.png', 3),
(4, 'exit_icon', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/exit_icon.png', 3),
(5, 'password_icon', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/password_icon.jpg', 3),
(6, 'qub_logo', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/qublogo.png', 3),
(7, 'info_1', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/info1.jpg', 3),
(8, 'info_2', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/info2.jpg', 3),
(9, 'info_3', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/info3.jpg', 3),
(10, 'info_4', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/info4.jpg', 3),
(11, 'thumb_1', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/thumb1.png', 3),
(12, 'thumb_2', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/thumb2.png', 3),
(13, 'thumb_3', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/thumb3.png', 3),
(14, 'thumb_4', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/thumb4.png', 3),
(15, 'computer', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/computer.png', 3),
(16, 'screen_1', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/screen1copy.jpg', 3),
(17, 'screen_2', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/screen2.png', 3),
(18, 'screen_3', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/screen3.png', 3),
(19, 'class', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/class.png', 3),
(20, 'timetable', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/timetable.png', 3),
(21, 'student_card', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/images/studentcard.jpg', 3),
(22, 'fire_alarm_audio', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/audio/201_firealarm.mp3', 4),
(23, 'computer_lab_audio', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/audio/202_computerlab.mp3', 4),
(24, 'students_talking_audio', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/audio/203_studentstalking.mp3', 4),
(25, 'c1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/c1.jpg', 1),
(26, 'c2_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/c2.jpg', 1),
(27, 'f1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/f1.jpg', 1),
(28, 'f2_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/f2.jpg', 1),
(29, 'f3_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/f3.jpg', 1),
(30, 'g1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g1.jpg', 1),
(31, 'g3_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g3.jpg', 1),
(32, 'g5_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g5.jpg', 1),
(33, 'g6_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/g6.jpg', 1),
(34, 'l1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/lift.jpg', 1),
(35, 'l4_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/lift.jpg', 1),
(36, 'l7_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/lift.jpg', 1),
(37, 'm1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/m1.jpg', 1),
(38, 'm2_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/m2.jpg', 1),
(39, 'o1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/o1.jpg', 1),
(40, 'o4_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/o4.jpg', 1),
(41, 'o5_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/o5.jpg', 1),
(42, 'q1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q1.jpg', 1),
(43, 'q2_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q2.jpg', 1),
(44, 'q3_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q3.jpg', 1),
(45, 'q4_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q4.jpg', 1),
(46, 'q5_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q5.jpg', 1),
(47, 'q6_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q6.jpg', 1),
(48, 's1_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s1.jpg', 1),
(49, 's2_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s2.jpg', 1),
(50, 's3_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s3.jpg', 1),
(51, 's4_location_image', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s4.jpg', 1),
(52, 'g1_linked_video', 'https://player.vimeo.com/progressive_redirect/playback/916665958/rendition/1080p/file.mp4?loc=external&signature=9b2de5fee085c9caaeb50b0611686aad62c16514e26696c1b1b6a1052b63ede7', 2),
(53, 'g3_linked_video', 'https://player.vimeo.com/progressive_redirect/playback/916931931/rendition/720p/file.mp4?loc=external&signature=84891bc2fd228ffc285371a006ae0a45149741c2792718980b175ec4979b883e', 2),
(54, 'o1_linked_video', 'https://player.vimeo.com/progressive_redirect/playback/916907794/rendition/1080p/file.mp4?loc=external&signature=e94c65c8acf0a8f023fb777f8f93f4a67d6276e852bbfd60c0e808aba00cebda', 2),
(55, 'l1_linked_video_groundtofirst', 'https://player.vimeo.com/progressive_redirect/playback/916668186/rendition/1080p/file.mp4?loc=external&signature=502c07379b780175895c8038cddbec8927b3d88982fae113ae7dcce74738c6bd', 2),
(56, 'l1_linked_video_groundtosecond', 'https://player.vimeo.com/progressive_redirect/playback/916691002/rendition/1080p/file.mp4?loc=external&signature=437722d0cf627ce3a2918b692e0d6b475689513219cf0271a567ce0a303afda6', 2),
(57, 'l4_linked_video_firsttoground\r\n', 'https://player.vimeo.com/progressive_redirect/playback/916907748/rendition/1080p/file.mp4?loc=external&signature=96b7498aa2bec98db07cb7acb19711a8be9afe1cdd8f7d81c0e7d340ba8bb186', 2),
(58, 'l4_linked_video_firsttosecond', 'https://player.vimeo.com/progressive_redirect/playback/916910527/rendition/1080p/file.mp4?loc=external&signature=793ca1eb39a63f3faa1bab49062652b7bded7f34b187179034e6c36227b2b5c9', 2),
(59, 'l7_linked_video_secondtofirst', 'https://player.vimeo.com/progressive_redirect/playback/916911442/rendition/1080p/file.mp4?loc=external&signature=8f69b6dcee71ed3fd551d9b87818566451edf06681d49b0672842e374a7bf9f5', 2),
(60, 'l7_linked_video_secondtoground', 'https://player.vimeo.com/progressive_redirect/playback/916912421/rendition/1080p/file.mp4?loc=external&signature=bf4aaf14b88a2d9738f7fc02dbb55be4eafca70dd037aca44ac33498bff84d50', 2),
(62, 'f1_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/f1video.mp4', 2),
(63, 'o4_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/o4video.mp4', 2),
(64, 'o5_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/o5video.mp4', 2),
(65, 'q2_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q2video.mp4', 2),
(66, 'q3_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/q3video.mp4', 2),
(67, 's3_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s3video.mp4', 2),
(68, 's4_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/s4video_new.mp4', 2),
(69, 'l1_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/l1video.mp4', 2),
(70, 'l4_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/l4video_light.mp4', 2),
(71, 'l7_location_video', 'https://mmccloy04.webhosting5.eeecs.qub.ac.uk/assets/locations/l7video.mp4', 2),
(72, 'click_sound_audio', 'https://cdn.aframe.io/360-image-gallery-boilerplate/audio/click.ogg', 4),
(73, 'hotspot_icon', 'https://cdn.glitch.com/2087dfa6-bd02-4451-a189-36095a66f386%2Fup-arrow.png?1545397127546', 3);

-- --------------------------------------------------------

--
-- Table structure for table `asset_type`
--

CREATE TABLE `asset_type` (
  `type_id` int(11) NOT NULL,
  `asset_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset_type`
--

INSERT INTO `asset_type` (`type_id`, `asset_type`) VALUES
(1, '360image'),
(2, '360video'),
(3, 'image'),
(4, 'audio');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_code` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_code`, `location_name`, `group_id`) VALUES
(1, 'o1', 'Front of Building', 5),
(2, 'o4', 'Bottom of Steps', 5),
(3, 'o5', 'Fire Assembly Point', 5),
(4, 'g1', 'Foyer - Reception', 3),
(5, 'g3', 'Foyer - By Stairs', 3),
(6, 'g5', 'Foyer - Carpeted Area', 3),
(7, 'g6', 'Foyer - By Lift', 3),
(8, 'c1', 'Technician\'s Desk', 3),
(9, 'c2', 'Computer Lab', 3),
(10, 'm1', 'Stairs - Ground to First Floor', 4),
(11, 'm2', 'Stairs - First to Second Floor', 4),
(12, 'f1', 'Foyer - By Stairs', 1),
(13, 'f2', 'Foyer - Seating Area', 1),
(14, 'f3', 'Foyer - By Lift', 1),
(15, 'q1', 'Corridor 1', 1),
(16, 'q2', 'Learning Lab', 1),
(17, 'q3', 'Corridor 2', 1),
(18, 'q4', 'Corridor 3', 1),
(19, 'q5', 'Corridor 4', 1),
(20, 'q6', 'Quiet Space', 1),
(21, 's1', 'Foyer - By Stairs', 2),
(22, 's2', 'Foyer - Seating Area', 2),
(23, 's3', 'Foyer - By Lift', 2),
(24, 's4', 'Lecture Theatre', 2),
(25, 'l0', 'Lift', 4),
(26, 'index', 'Home Page', 4),
(27, 'l1', 'Ground Floor Lift', 3),
(28, 'l4', 'First Floor Lift', 1),
(29, 'l7', 'Second Floor Lift', 2);

-- --------------------------------------------------------

--
-- Table structure for table `locations_assets`
--

CREATE TABLE `locations_assets` (
  `entity_id` int(11) NOT NULL,
  `entity_ref` varchar(255) NOT NULL,
  `position_x` decimal(5,2) NOT NULL DEFAULT 0.00,
  `position_y` decimal(5,2) NOT NULL DEFAULT 0.00,
  `position_z` decimal(5,2) NOT NULL DEFAULT 0.00,
  `rotation_x` decimal(5,2) NOT NULL DEFAULT 0.00,
  `rotation_y` decimal(5,2) NOT NULL DEFAULT 0.00,
  `rotation_z` decimal(5,2) NOT NULL DEFAULT 0.00,
  `entity_text` text NOT NULL DEFAULT '',
  `asset_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations_assets`
--

INSERT INTO `locations_assets` (`entity_id`, `entity_ref`, `position_x`, `position_y`, `position_z`, `rotation_x`, `rotation_y`, `rotation_z`, `entity_text`, `asset_id`, `location_id`) VALUES
(2, 'audio_info', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Hover over the audio icons to view the associated information. Click and hold the audio icons to listen to the audio.', 1, 26),
(3, 'video_info', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Hover over the video icons to view the associated information. Click the video icon to play the video. You will be automatically redirected back to your location once the video has finished.', 2, 26),
(4, 'task_info', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Hover over the task boxes to view instructions about the task. In some cases you will need to click on the task box to start, you will be prompted if you need to do this.', 3, 26),
(5, 'exit_info', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Hover over the exit icons to view the associated information. Click the exit icons if you would like to exit. There is an exit button at the Fire Assembly Point which will bring you back to this page.', 4, 26),
(7, 'task_info', '10.00', '-0.70', '0.80', '0.00', '200.00', '0.00', 'Welcome to the Technician\'s Desk. You need to complete your IT induction - click on the task box to get started and then read through the information on the panels behind you.\\nOnce you\'re done, head to the Computer Lab next door (Hint: you will need to go via the foyer).', 3, 8),
(8, 'sky', '0.00', '0.00', '0.00', '0.00', '-60.00', '0.00', '', 25, 8),
(9, 'g6_link', '5.00', '1.30', '10.00', '0.00', '0.00', '0.00', 'This way to the\\nGround Floor Foyer', 33, 8),
(10, 'audio_file', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 72, 8),
(11, 'thumb_1', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 11, 8),
(12, 'thumb_2', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 12, 8),
(13, 'thumb_3', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 13, 8),
(14, 'thumb_4', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 14, 8),
(15, 'info_1', '-3.48', '0.43', '1.30', '0.50', '110.00', '0.23', '', 7, 8),
(16, 'info_2', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 8, 8),
(17, 'info_3', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 9, 8),
(18, 'info_4', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 10, 8),
(32, 'audio_info', '-7.00', '1.30', '-8.00', '0.00', '0.00', '0.00', 'Click and hold to hear the humming sound of the computers in the Computer Lab.', 1, 9),
(33, 'task_info', '8.00', '1.30', '1.00', '0.00', '0.00', '0.00', 'Your task is to logon to a computer - click on the task box below to get started.', 3, 9),
(34, 'password_info', '8.00', '0.00', '1.00', '0.00', '180.00', '0.00', '', 5, 9),
(36, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 26, 9),
(37, 'g6_link', '4.40', '1.30', '-11.00', '0.00', '0.00', '0.00', 'This way to the\\nGround Floor Foyer', 33, 9),
(38, 'computer', '6.50', '2.50', '12.00', '0.00', '0.00', '0.00', 'Enter your password...', 15, 9),
(39, 'screen_1', '0.01', '0.00', '0.01', '0.00', '0.00', '0.00', 'Click on the password icon (beneath the task box) to reveal your password. Then enter your password and select \'Submit\'.', 16, 9),
(40, 'screen_2', '0.01', '0.00', '0.01', '0.00', '0.00', '0.00', 'This is your QSIS homepage. Select the \'Classes\' icon to view your timetable.', 17, 9),
(41, 'screen_3', '0.01', '0.00', '0.01', '0.00', '0.00', '0.00', 'Your timetable is provided below. Hover over the task box to find out your next task.', 18, 9),
(42, 'classes', '2.60', '-1.05', '0.50', '0.00', '0.00', '0.00', '', 19, 9),
(43, 'timetable', '-0.20', '-3.35', '0.50', '0.00', '0.00', '0.00', '', 20, 9),
(44, 'f2_link', '-4.00', '2.60', '-15.00', '0.00', '0.00', '0.00', 'Seating Area', 28, 12),
(45, 'f3_link', '13.00', '1.50', '1.00', '0.00', '0.00', '0.00', 'First Floor\\nFoyer', 29, 12),
(46, 'm1_link', '-0.50', '0.00', '12.50', '0.00', '0.00', '0.00', 'Down to Ground Floor', 37, 12),
(47, 'm2_link', '8.00', '2.00', '10.00', '0.00', '0.00', '0.00', 'Up to Second Floor', 38, 12),
(48, 'f1_link', '-15.00', '2.70', '1.00', '0.00', '0.00', '0.00', 'First Floor Foyer', 27, 13),
(49, 'sky', '0.00', '0.00', '0.00', '0.00', '-180.00', '0.00', '', 28, 13),
(50, 'f1_link', '4.50', '1.50', '-12.00', '0.00', '0.00', '0.00', 'First Floor Foyer', 27, 14),
(51, 'sky', '0.00', '0.00', '0.00', '0.00', '100.00', '0.00', '', 29, 14),
(52, 'lift_link', '-5.70', '1.50', '-6.00', '0.00', '0.00', '0.00', 'Lift', 35, 14),
(53, 'q1_link', '-3.30', '1.50', '8.00', '0.00', '0.00', '0.00', 'This way to the\\nLearning Lab', 42, 14),
(54, 'video_info', '8.00', '1.40', '5.00', '0.00', '0.00', '0.00', 'Click to play video showing\\nhow to exit out of hours', 2, 4),
(55, 'task_info', '8.30', '0.00', '-5.50', '0.00', '10.00', '0.00', 'Welcome to EEECS!\\nPlease firstly visit the Technician\'s Desk.\\n (Hint: It\'s on the Ground Floor).', 3, 4),
(56, 'exit_info', '8.00', '-0.10', '5.00', '0.00', '0.00', '0.00', 'Click this Exit button to go outside', 4, 4),
(57, 'sky', '0.00', '0.00', '0.00', '0.00', '-90.00', '0.00', '', 30, 4),
(58, 'g3_link', '0.00', '2.00', '-10.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 31, 4),
(59, 'g5_link', '-10.00', '2.00', '-5.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 32, 4),
(61, 'linked_video', '0.00', '0.00', '0.00', '0.00', '-100.00', '0.00', '', 52, 4),
(62, 'audio_file', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 23, 9),
(71, 'video_info', '-8.00', '1.30', '-7.00', '0.00', '0.00', '0.00', 'Click to play video of\\nthe foyer when it\'s busy', 2, 5),
(72, 'g1_link', '-6.50', '1.50', '8.50', '0.00', '0.00', '0.00', 'Reception and\\nWay Out', 30, 5),
(73, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 31, 5),
(74, 'g5_link', '-12.00', '1.50', '-3.50', '0.00', '0.00', '0.00', 'Ground Floor\\nFoyer', 32, 5),
(75, 'g6_link', '-6.00', '1.50', '-15.00', '0.00', '0.00', '0.00', 'Ground Floor\\nFoyer', 33, 5),
(76, 'lift_link', '-3.50', '1.50', '-15.00', '0.00', '0.00', '0.00', 'Lift', 34, 5),
(77, 'm1_link', '4.00', '3.00', '-14.00', '0.00', '0.00', '0.00', 'Up to First Floor', 37, 5),
(78, 'linked_video', '0.00', '0.00', '0.00', '0.00', '-20.00', '0.00', '', 53, 5),
(79, 'sky', '0.00', '0.00', '0.00', '0.00', '-80.00', '0.00', '', 62, 12),
(80, 'g1_link', '4.00', '1.50', '-12.00', '0.00', '0.00', '0.00', 'Reception', 30, 6),
(81, 'g3_link', '-7.00', '1.50', '-8.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 31, 6),
(82, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 32, 6),
(83, 'g6_link', '0.60', '1.20', '10.00', '0.00', '0.00', '0.00', 'This way to the\\nComputer Lab and\\nTechnician\'s Desk', 33, 6),
(84, 'lift_link', '-10.00', '1.40', '6.20', '0.00', '0.00', '0.00', 'Lift', 34, 6),
(85, 'c1_link', '-6.00', '1.50', '3.50', '0.00', '0.00', '0.00', 'This way to the\\nTechnician\'s Desk', 25, 7),
(86, 'c2_link', '6.00', '1.50', '7.50', '0.00', '0.00', '0.00', 'Computer Lab', 26, 7),
(87, 'g3_link', '11.00', '1.50', '-10.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 31, 7),
(88, 'g5_link', '15.00', '1.50', '2.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 32, 7),
(89, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 33, 7),
(90, 'lift_link', '7.00', '1.50', '-11.00', '0.00', '0.00', '0.00', 'Lift', 34, 7),
(91, 'g5_link', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 32, 27),
(92, 'sky_g', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 69, 25),
(93, 'l1_linked_video_groundtofirst', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 55, 25),
(94, 'l1_linked_video_groundtosecond', '0.00', '0.00', '0.00', '0.00', '-113.00', '0.00', '', 56, 25),
(95, 'f3_link', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'First Floor Foyer', 29, 28),
(96, 'sky', '0.00', '0.00', '0.00', '0.00', '-107.00', '0.00', '', 70, 28),
(97, 'l4_linked_video_firsttoground', '0.00', '0.00', '0.00', '0.00', '-108.00', '0.00', '', 57, 25),
(98, 'l4_linked_video_firsttosecond', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 58, 25),
(99, 's3_link', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'Second Floor Foyer', 50, 29),
(100, 'sky', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 71, 29),
(101, 'l7_linked_video_secondtofirst', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 59, 25),
(102, 'l7_linked_video_secondtoground', '0.00', '0.00', '0.00', '0.00', '-113.00', '0.00', '', 60, 25),
(103, 'f1_link', '1.00', '3.00', '-12.00', '0.00', '0.00', '0.00', 'First Floor', 27, 10),
(104, 'g3_link', '10.00', '-4.50', '-8.00', '0.00', '0.00', '0.00', 'Ground Floor', 31, 10),
(105, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 37, 10),
(106, 'f1_link', '10.00', '-4.50', '-8.00', '0.00', '0.00', '0.00', 'First Floor', 27, 11),
(107, 'sky', '0.00', '0.00', '0.00', '0.00', '-120.00', '0.00', '', 38, 11),
(108, 's1_link', '1.00', '3.00', '-12.00', '0.00', '0.00', '0.00', 'Second Floor', 48, 11),
(109, 'video_info', '10.50', '2.00', '-1.00', '0.00', '0.00', '0.00', 'Click to play video\\nof students coming out', 2, 1),
(110, 'task_info', '10.50', '0.50', '-1.00', '0.00', '0.00', '0.00', 'To enter the building, click on your student card to scan it on the reader. Once successfully scanned, the reader will turn green and you will be able to go inside. You can then visit reception to find out your next task.  ', 3, 1),
(111, 'g1_link', '6.30', '1.50', '-6.00', '0.00', '0.00', '0.00', 'Go Inside', 30, 1),
(112, 'sky', '0.00', '0.00', '0.00', '0.00', '-133.00', '0.00', '', 39, 1),
(113, 'o4_link', '-6.00', '-1.50', '7.00', '0.00', '0.00', '0.00', 'This way to the\\nFire Assembly Point', 40, 1),
(114, 'student_card', '-1.00', '1.60', '-10.00', '0.00', '0.00', '0.00', '', 21, 1),
(115, 'linked_video', '0.00', '0.00', '0.00', '0.00', '-90.00', '0.00', '', 54, 1),
(117, 'o1_link', '9.50', '4.00', '-9.00', '0.00', '0.00', '0.00', 'Front of the\\nBuilding', 39, 2),
(118, 'o5_link', '7.20', '1.50', '9.00', '0.00', '0.00', '0.00', 'This way to the\\nFire Assembly Point', 41, 2),
(119, 'sky', '0.00', '0.00', '0.00', '0.00', '-133.00', '0.00', '', 63, 2),
(120, 'task_info', '-6.00', '1.50', '-2.50', '0.00', '0.00', '0.00', 'Well done for making it to the Fire Assembly Point. That is your final task complete.\\nYou can either navigate back to the Computer Science Building or select the \'Exit\' box.', 3, 3),
(121, 'exit_info', '-6.00', '0.20', '-2.50', '0.00', '0.00', '0.00', 'Click this Exit button to return to the homepage', 4, 3),
(122, 'o4_link', '8.50', '2.00', '8.50', '0.00', '0.00', '0.00', 'This way to the\\nBuilding Entrance', 40, 3),
(123, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 64, 3),
(124, 'task_info', '7.00', '0.00', '-5.50', '0.00', '0.00', '0.00', 'Uh oh there are boxes blocking the Learning Lab! Click the task box to start, then click on the boxes to knock them out of the way before they fall down!', 3, 15),
(125, 'f3_link', '11.00', '1.35', '-0.30', '0.00', '0.00', '0.00', 'This way to the\\nFirst Floor Foyer', 29, 15),
(126, 'sky', '0.00', '0.00', '0.00', '0.00', '185.00', '0.00', '', 42, 15),
(127, 'q2_link', '-0.50', '1.20', '-8.00', '0.00', '0.00', '0.00', 'Learning Lab', 43, 15),
(128, 'q3_link', '-11.00', '1.35', '0.00', '0.00', '0.00', '0.00', 'This way to the\\nQuiet Space', 44, 15),
(129, 'audio_info', '-4.00', '-0.20', '2.50', '0.00', '-10.00', '-2.00', 'Click and hold to play the\\nsound of the fire alarm.', 1, 16),
(130, 'task_info', '-1.50', '-0.20', '-4.70', '0.00', '-5.00', '0.00', 'Well done for finding the Learning Lab!\\n Unfortunately you can\'t stick around as the Fire Alarm has just started going off. \\nPlease exit the building via the stairs, the lifts will be disabled until you have safely reached the Fire Assembly Point outside.\r\n', 3, 16),
(131, 'q1_link', '4.50', '1.50', '9.00', '0.00', '0.00', '0.00', 'This way to\\nthe Corridor', 42, 16),
(132, 'sky', '0.00', '0.00', '0.00', '0.00', '60.00', '0.00', '', 65, 16),
(133, 'audio_file', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 22, 16),
(134, 'q1_link', '-9.00', '1.40', '4.80', '0.00', '0.00', '0.00', 'This way to the\\nFoyer', 42, 17),
(135, 'q4_link', '6.00', '1.50', '-9.00', '0.00', '0.00', '0.00', 'This way to the\\nQuiet Space', 45, 17),
(136, 'sky', '0.00', '0.00', '0.00', '0.00', '150.00', '0.00', '', 66, 17),
(137, 'q3_link', '1.00', '2.00', '11.00', '0.00', '0.00', '0.00', 'This way to the\\nFoyer', 44, 18),
(138, 'sky', '0.00', '0.00', '0.00', '0.00', '90.00', '0.00', '', 45, 18),
(139, 'q5_link', '1.20', '1.80', '-8.00', '0.00', '0.00', '0.00', 'This way to the\\nQuiet Space', 46, 18),
(140, 'q3_link', '-8.00', '1.70', '7.50', '0.00', '0.00', '0.00', 'This way back to\\nthe Foyer', 44, 19),
(141, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 46, 19),
(142, 'q6_link', '3.10', '1.10', '-8.00', '0.00', '0.00', '0.00', 'Quiet Space', 47, 19),
(143, 'q5_link', '-7.00', '1.00', '-3.50', '0.00', '0.00', '0.00', 'Back to the\\nCorridor', 46, 20),
(144, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 47, 20),
(145, 'm2_link', '-5.00', '0.80', '10.00', '0.00', '0.00', '0.00', 'Down to First Floor', 38, 21),
(146, 'sky', '0.00', '0.00', '0.00', '0.00', '-130.00', '0.00', '', 48, 21),
(147, 's3_link', '12.00', '1.00', '-5.00', '0.00', '0.00', '0.00', 'Second Floor Foyer', 50, 21),
(148, 'sky', '0.00', '0.00', '0.00', '0.00', '-90.00', '0.00', '', 49, 22),
(149, 's3_link', '7.00', '1.00', '11.00', '0.00', '0.00', '0.00', 'Second Floor Foyer', 50, 22),
(150, 'lift_link', '-9.00', '1.00', '0.30', '0.00', '0.00', '0.00', 'Lift', 36, 23),
(151, 's1_link', '-1.00', '1.20', '-10.00', '0.00', '0.00', '0.00', 'Second Floor Foyer', 48, 23),
(152, 's2_link', '9.00', '1.50', '-5.00', '0.00', '0.00', '0.00', 'Seating Area', 49, 23),
(153, 's4_link', '1.00', '1.00', '8.00', '0.00', '0.00', '0.00', 'Lecture Theatre\\n(02/027)', 51, 23),
(154, 'sky', '0.00', '0.00', '0.00', '0.00', '100.00', '0.00', '', 67, 23),
(155, 'audio_info', '0.50', '2.50', '8.50', '-5.00', '0.00', '0.00', 'Click and hold to hear what it sounds like when students are in the room.', 1, 24),
(156, 'task_info', '-0.50', '2.50', '-8.50', '0.00', '90.00', '5.00', 'Your lecturer has asked you to complete a task to work out where you need to go next. Click on the task box to get started, then click on each of the boxes to rotate them.', 3, 24),
(157, 's3_link', '9.00', '1.70', '10.00', '0.00', '0.00', '0.00', 'This way to the\\nSecond Floor Foyer', 50, 24),
(158, 'sky', '0.00', '0.00', '0.00', '0.00', '95.00', '0.00', '', 51, 24),
(159, 'audio_file', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', 24, 24),
(160, 'task2_info', '-5.30', '-3.00', '0.50', '0.00', '0.00', '0.00', 'Your next task is to go your lecture, outlined in black on your timetable. Hover over this to view the details (Hint: 02/027 is the location and \'02\' is on the Second Floor).', 3, 9),
(161, 'link_g', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'Ground Floor Foyer', 32, 25),
(162, 'link_1', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'First Floor Foyer', 29, 25),
(163, 'link_2', '4.00', '1.00', '-7.00', '0.00', '0.00', '0.00', 'Second Floor Foyer', 50, 25),
(164, 'sky_1', '0.00', '0.00', '0.00', '0.00', '-107.00', '0.00', '', 70, 25),
(165, 'sky_2', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 71, 25),
(166, 'sky', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 69, 27),
(167, 'l1_linked_video_groundtofirst', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 55, 27),
(168, 'l1_linked_video_groundtosecond', '0.00', '0.00', '0.00', '0.00', '-113.00', '0.00', '', 56, 27),
(169, 'l4_linked_video_firsttoground', '0.00', '0.00', '0.00', '0.00', '-108.00', '0.00', '', 57, 28),
(170, 'l4_linked_video_firsttosecond', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 58, 28),
(171, 'l7_linked_video_secondtofirst', '0.00', '0.00', '0.00', '0.00', '-111.00', '0.00', '', 59, 29),
(172, 'l7_linked_video_secondtoground', '0.00', '0.00', '0.00', '0.00', '-113.00', '0.00', '', 60, 29),
(173, 'g2_linked_video', '0.00', '0.00', '0.00', '0.00', '80.00', '0.00', '', 52, 4),
(174, 'g4_linked_video', '0.00', '0.00', '0.00', '0.00', '20.00', '0.00', '', 53, 5),
(175, 'o2_linked_video', '0.00', '0.00', '0.00', '0.00', '-150.00', '0.00', '', 54, 1),
(209, 'hotspot_info', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Click on these icons to navigate between locations within the tour.', 73, 26);

-- --------------------------------------------------------

--
-- Table structure for table `location_groups`
--

CREATE TABLE `location_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_groups`
--

INSERT INTO `location_groups` (`group_id`, `group_name`) VALUES
(1, 'First Floor'),
(2, 'Second Floor'),
(3, 'Ground Floor'),
(4, 'Other'),
(5, 'Outside');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `student_staff_number` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `student_staff_number`, `email`, `password`, `firstname`, `surname`, `type_id`) VALUES
(1, 11223344, 'admin@qub.ac.uk', '$2y$10$j4y2BxzQKRBtTauGafCYxeSUZgZnTwQbQmQMobhmqb03wPS1UxNe.', 'Admin', 'Account', 1),
(2, 12345678, 'student@qub.ac.uk', 'CSB_124', 'EEECS', 'Student', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `user_type`) VALUES
(1, 'Admin'),
(2, 'Standard User');

-- --------------------------------------------------------

--
-- Table structure for table `website_stats`
--

CREATE TABLE `website_stats` (
  `stats_id` int(11) NOT NULL,
  `stats_ref` varchar(255) NOT NULL,
  `stats_type` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `last_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `website_stats`
--

INSERT INTO `website_stats` (`stats_id`, `stats_ref`, `stats_type`, `count`, `last_updated`) VALUES
(1, 'total_visits', 'Total visits (Index Page)', 1056, '2024-05-17 15:48:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `assets_typeid` (`type_id`);

--
-- Indexes for table `asset_type`
--
ALTER TABLE `asset_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `FK_location_groups` (`group_id`);

--
-- Indexes for table `locations_assets`
--
ALTER TABLE `locations_assets`
  ADD PRIMARY KEY (`entity_id`),
  ADD KEY `FK_assetid` (`asset_id`),
  ADD KEY `FK_locationid` (`location_id`);

--
-- Indexes for table `location_groups`
--
ALTER TABLE `location_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `typeid` (`type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `website_stats`
--
ALTER TABLE `website_stats`
  ADD PRIMARY KEY (`stats_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `asset_type`
--
ALTER TABLE `asset_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `locations_assets`
--
ALTER TABLE `locations_assets`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `location_groups`
--
ALTER TABLE `location_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `website_stats`
--
ALTER TABLE `website_stats`
  MODIFY `stats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_typeid` FOREIGN KEY (`type_id`) REFERENCES `asset_type` (`type_id`);

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `FK_location_groups` FOREIGN KEY (`group_id`) REFERENCES `location_groups` (`group_id`);

--
-- Constraints for table `locations_assets`
--
ALTER TABLE `locations_assets`
  ADD CONSTRAINT `FK_assetid` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`),
  ADD CONSTRAINT `FK_locationid` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_typeid` FOREIGN KEY (`type_id`) REFERENCES `user_type` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
