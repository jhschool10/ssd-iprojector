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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `date_created`, `last_login`, `email_address`, `first_name`, `last_name`, `age`) VALUES
(1, 'admin', '$2y$10$7h2UJBGLkixEjW.121y9D.t0lhLgNZT92j6T4BsO6lmpR/GYsdG1u', '2020-11-30 22:35:22', '2020-12-12 02:20:43', NULL, NULL, NULL, 100),
(2, 'joseph', '$2y$10$7h2UJBGLkixEjW.121y9D.t0lhLgNZT92j6T4BsO6lmpR/GYsdG1u', '2020-11-30 22:35:52', '2020-12-13 22:35:14', NULL, NULL, NULL, 32),
(3, 'michael32', '$2y$10$vqjWBDaryEqXW0j7x/ks0.r4kWJysEFOAI.JkBmszX9EIHyfUeL4O', '2020-12-01 18:00:50', NULL, NULL, NULL, NULL, 20),
(4, 'steve32', '$2y$10$vqjWBDaryEqXW0j7x/ks0.r4kWJysEFOAI.JkBmszX9EIHyfUeL4O', '2020-12-01 18:00:50', NULL, NULL, NULL, NULL, 20),
(5, 'juliana2', '$2y$10$XIKw1BBaD2p5rnmZHkjLTu7H5.9lUCALhYuqfNGMQj2Me.vqF7Iv2', '2020-12-01 18:00:50', '2020-12-13 18:33:40', 'juliana@thislibrary.info', 'Juliana', 'Habibi', 34),
(6, 'henry555', '$2y$10$lhQV372rOUYrKeRuzC8VbeEtBFVfY4Z9Zc24EVd7ebPVq1j6NdYxa', '2020-12-01 18:00:50', '2020-12-12 21:32:36', 'henry@666.ca', 'Sixsixsix', 'Fivefivefive', 42),
(7, 'kirk17', '$2y$10$RcC9W7LQraD2JS4vhgnkBegGqwDMETiSXAU23OWD9sCACguH1.xV2', '2020-12-01 18:00:50', '2020-12-13 22:37:43', 'whatever@heather.com', 'Kirk', 'Patrick', 101),
(8, 'henrietta5', '$2y$10$Koy.z54jFrGELeSGbNLin.vGmEgZb0FTPGGkRJKt2h1FJVkNiOpwu', '2020-12-01 18:00:50', '2020-12-13 22:53:14', 'myemail@myemail.com', 'Henrietta', 'Malelover', 23),
(9, 'heather6', '$2y$10$vqjWBDaryEqXW0j7x/ks0.r4kWJysEFOAI.JkBmszX9EIHyfUeL4O', '2020-12-01 18:00:50', NULL, NULL, NULL, NULL, 20),
(10, 'consolata', '$2y$10$vqjWBDaryEqXW0j7x/ks0.r4kWJysEFOAI.JkBmszX9EIHyfUeL4O', '2020-12-01 18:00:50', NULL, NULL, NULL, NULL, 20),
(11, 'ghghghghg', '$2y$10$K9mNktr9wVCnrZJVcSABQ.cAwkukE4mCi..wc3royUb82HoYD/15.', '2020-12-04 15:19:22', NULL, '', '', '', 14),
(26, 'rebekkah', '$2y$10$K9mNktr9wVCnrZJVcSABQ.cAwkukE4mCi..wc3royUb82HoYD/15.', '2020-12-04 15:37:16', NULL, '', '', '', 22),
(31, 'otherjoseph', '$2y$10$60OpJMeCezpyRZ/xf.omauJ9ikU5nmZB9ActkyUBbS/mhc7d8Vs/u', '2020-12-08 20:42:17', NULL, 'thing@thing.com', 'Joseph', 'Haley', 22),
(37, 'username', '$2y$10$4LC1qveAYOZts1S5JvexsuO8ohAiBqaiSxayuI5qhg3elRI4Ni2t6', '2020-12-11 18:17:44', '2020-12-11 18:18:00', '', '', '', 15),
(38, 'markhaley', '$2y$10$.404wu83jZCqH8k1D1A8eOzrDWVSIIRxN0Qngw95vs21QIczGFTXy', '2020-12-12 01:27:04', '2020-12-12 01:28:15', '', '', '', 15),
(39, 'testing', '$2y$10$VFzAVHaZ1e4b7ptKzCSFN.PORFPUEdqSGmKPu7OueG9WF7kFKpHga', '2020-12-12 18:40:19', NULL, '', '', '', 15),
(41, 'jphaley', '$2y$10$LutVR5WzYU22OnqcxxM08u9HPp4dDse6wAEoWd1Jav4oc2jwJjgoG', '2020-12-13 20:34:53', '2020-12-13 20:35:00', 'email@whatever.info', 'Joseph', 'Haley', 13),
(42, 'whatever', '$2y$10$G9uEWmMrujK.CUxPsZ9Ifu9UgOpk5qbLns6zXkVZ4gMrAPUJiKMTq', '2020-12-13 20:36:56', NULL, '', 'Henry', '', 133);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `USERNAME` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
