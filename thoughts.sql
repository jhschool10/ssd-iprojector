-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2020 at 09:25 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `000820709`
--

-- --------------------------------------------------------

--
-- Table structure for table `thoughts`
--

CREATE TABLE `thoughts` (
  `id` int(11) NOT NULL,
  `current_owner` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `thought_text` text NOT NULL,
  `huzzahs` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thoughts`
--

INSERT INTO `thoughts` (`id`, `current_owner`, `date_created`, `thought_text`, `huzzahs`) VALUES
(1, 10, '2020-11-30 22:36:59', 'do not believe in scissors.', 14),
(2, 10, '2020-11-30 22:37:24', 'am a rhinoceros.', 19),
(3, 4, '2020-12-01 16:44:05', 'resist all forms of coercion!', 3),
(4, 2, '2020-12-01 16:45:13', 'am so smart.', 8),
(5, 6, '2020-12-01 16:48:45', 'am the best', 2),
(6, 9, '2020-12-01 16:49:27', 'am noodles', 13),
(7, 2, '2020-12-01 17:13:18', 'wish I were an Oscar Mayer weiner', 1),
(8, 7, '2020-12-01 18:26:23', 'exist only in my mind', 2),
(9, 2, '2020-12-01 18:26:23', 'voted for a cow', 3),
(10, 7, '2020-12-01 18:26:23', 'express myself well', 7),
(11, 2, '2020-12-01 18:26:23', 'am better than Henry lastnamewithheld', 0),
(12, 2, '2020-12-01 18:26:23', 'wish I were a mermaid', 1),
(13, 7, '2020-12-01 18:26:23', 'am horrendous', 7),
(14, 2, '2020-12-01 18:26:23', 'once went to confession', 1),
(15, 7, '2020-12-01 18:26:23', 'am entirely without conscience', 6),
(16, 10, '2020-12-01 18:26:23', 'am several people at once', 1),
(17, 2, '2020-12-01 18:26:23', 'am secretly a mermaid', 14),
(18, 9, '2020-12-01 18:26:23', 'need to get this wad of hair off my chest', 8),
(19, 2, '2020-12-01 18:26:23', 'am too afraid to love', 8),
(20, 8, '2020-12-01 18:26:23', 'secretly abhor all forms of bravery', 1),
(21, 6, '2020-12-01 18:26:23', 'stole the real Derek\'s identity', 8),
(22, 8, '2020-12-01 18:26:23', 'wish everything were different', 5),
(23, 7, '2020-12-01 18:26:23', 'ate icecream yesterday', 1),
(24, 7, '2020-12-01 18:26:23', 'really think I like being here', 9),
(25, 5, '2020-12-01 18:26:23', 'am fundamentally good', 10),
(26, 4, '2020-12-01 18:26:23', 'am not perfect', 13),
(27, 2, '2020-12-01 18:26:23', 'ate a bug that flew in my mouth', 1),
(28, 9, '2020-12-01 18:30:28', 'want to say horrible things to a giraffe', 1),
(29, 2, '2020-12-01 18:30:28', 'think my niece is a little spoiled', 6),
(30, 6, '2020-12-01 18:30:28', 'was never allowed to climb trees as a child', 0),
(31, 2, '2020-12-01 18:30:28', 'am cold right now', 2),
(32, 2, '2020-12-01 18:30:28', 'enjoy nurturing children', 0),
(33, 2, '2020-12-01 18:30:28', 'want to be a mother', 3),
(34, 5, '2020-12-01 18:30:28', 'dream of one day having a family', 0),
(35, 4, '2020-12-01 18:30:28', 'enjoy being around other people', 1),
(36, 1, '2020-12-01 18:30:28', 'ski about once every 15 years', 6),
(37, 7, '2020-12-01 18:30:28', 'eat yellow snow all the time', 11),
(38, 7, '2020-12-01 18:30:28', 'a chicken', 0),
(39, 2, '2020-12-01 18:30:28', 'once farted in my own food', 0),
(40, 8, '2020-12-01 18:30:28', 'just turned on the fan in my office', 0),
(41, 2, '2020-12-01 18:30:28', 'open windows to smell the breeze', 1),
(42, 2, '2020-12-01 18:30:28', 'am not a fan of the Buffalo Sabres', 8),
(43, 2, '2020-12-01 18:30:28', 'am pretty sure no sane person likes the Montreal Canadiens', 2),
(44, 8, '2020-12-01 18:30:28', 'ate a bug that flew in my mouth', 4),
(45, 2, '2020-12-02 00:01:20', 'wanted six toes on my left foot', 10),
(46, 5, '2020-12-02 01:17:34', 'want to stop coding for the night', 0),
(47, 8, '2020-12-02 21:32:18', 'wish it was dinner', 2),
(48, 10, '2020-12-04 16:33:59', 'would like to be, under the sea, in an octopus&#39; garden, in the shade', 8),
(49, 8, '2020-12-04 16:43:44', 'just called to say I love you', 9),
(50, 2, '2020-12-04 16:44:30', 'am not gonna do that any more', 8),
(51, 2, '2020-12-04 16:45:05', 'am a muffin', 3),
(52, 10, '2020-12-04 16:46:23', 'am just like everybody else', 1),
(77, 9, '2020-12-04 22:39:05', 'am very hungry', 6),
(78, 3, '2020-12-04 22:43:25', 'just wanna have fun', 4),
(79, 2, '2020-12-04 22:44:23', 'am just waiting for the right moment', 0),
(80, 2, '2020-12-04 22:45:37', 'ate a frog', 3),
(81, 5, '2020-12-04 22:46:52', 'didn&#39;t mean it that way!', 3),
(82, 8, '2020-12-04 22:47:59', 'am testing an animation feature', 6),
(83, 2, '2020-12-04 22:50:02', 'really wish this feature were working', 1),
(84, 7, '2020-12-04 23:03:04', 'still feel like a child', 5),
(85, 2, '2020-12-05 01:31:30', 'don&#39;t like where I live', 7),
(86, 7, '2020-12-05 21:08:31', 'will go painting houses', 9),
(87, 9, '2020-12-06 01:06:56', 'am laughing', 0),
(88, 10, '2020-12-06 01:09:16', 'just went to the bathroom', 1),
(89, 2, '2020-12-06 01:29:02', 'am staring', 2),
(90, 2, '2020-12-06 01:30:56', 'am tired', 16),
(91, 8, '2020-12-06 01:31:24', 'am pooped', 0),
(92, 4, '2020-12-06 01:31:54', 'am slammed', 3),
(93, 3, '2020-12-06 01:40:50', 'am very tired', 5),
(94, 2, '2020-12-06 01:43:06', 'am even more tired', 6),
(95, 2, '2020-12-06 01:45:16', 'want to stop programming for tonight', 1),
(96, 4, '2020-12-06 01:47:36', 'can&#39;t stop just yet', 1),
(97, 2, '2020-12-06 01:49:07', 'am angry', 11),
(98, 2, '2020-12-06 01:49:18', 'am done for tonight', 3),
(99, 2, '2020-12-06 19:28:54', 'am more hungry than I was ten minutes ago', 0),
(100, 7, '2020-12-07 00:55:50', 'am worried about my brother', 1),
(101, 10, '2020-12-08 03:04:39', 'am KIRK SEVENTEEN!!!!', 13),
(102, 2, '2020-12-08 05:19:53', 'LOVE COLESLAW', 1),
(103, 6, '2020-12-08 05:20:52', 'embrace all religions', 0),
(104, 2, '2020-12-08 15:46:45', 'wish I was juliana2', 3),
(105, 10, '2020-12-08 15:48:49', 'I wish I was henry555', 0),
(106, 8, '2020-12-08 15:51:18', 'am listening to music', 4),
(107, 2, '2020-12-08 15:52:55', 'am in heaven as I eat this piece of chocolate', 2),
(108, 5, '2020-12-08 15:53:54', 'don&#39;t like being angry', 1),
(109, 2, '2020-12-08 15:56:02', 'don&#39;t like some things about this situation', 3),
(110, 3, '2020-12-08 15:57:57', 'am sharing my THOUGHTS', 0),
(111, 3, '2020-12-08 20:30:09', 'just wanna be free', 0),
(112, 2, '2020-12-10 23:52:07', 'distinctly remember falling asleep right at that moment', 0),
(113, 7, '2020-12-13 22:48:24', 'just want to have fun!', 1),
(114, 8, '2020-12-13 23:50:58', 'thought a new thought', 1),
(115, 2, '2020-12-13 23:53:14', 'wanna think a new thought', 0),
(116, 8, '2020-12-13 23:57:07', 'wanna be a sun!', 0),
(117, 8, '2020-12-13 23:57:37', 'am a star and a moon AT THE SAME TIME', 0),
(118, 5, '2020-12-13 23:58:36', 'believe in flat earth shenanigans', 2),
(119, 2, '2020-12-13 23:58:59', 'have some cake', 0),
(120, 8, '2020-12-13 23:59:48', 'want to register my disagreement', 0),
(121, 5, '2020-12-14 00:01:58', 'am busy right now', 0),
(122, 8, '2020-12-14 00:02:24', 'want to be free', 0),
(123, 8, '2020-12-14 00:03:23', 'ate a pie', 0),
(124, 8, '2020-12-14 00:04:05', 'suppose so', 0),
(125, 5, '2020-12-14 01:24:27', 'am HENRIETTA5&#39;S OTHER PERSONALITY', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `thoughts`
--
ALTER TABLE `thoughts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `current_owner` (`current_owner`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `thoughts`
--
ALTER TABLE `thoughts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `thoughts`
--
ALTER TABLE `thoughts`
  ADD CONSTRAINT `FK_current_owner` FOREIGN KEY (`current_owner`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
