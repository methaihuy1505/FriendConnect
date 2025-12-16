-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql313.infinityfree.com
-- Generation Time: Dec 16, 2025 at 05:42 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `friend_connect`
--
CREATE DATABASE IF NOT EXISTS `friend_connect` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `friend_connect`;

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `creator_id`, `title`, `description`, `created_at`) VALUES
(1, 1, 'Thử thách kiến thức PHP', 'Kiểm tra kiến thức cơ bản về PHP', '2025-12-06 03:23:34'),
(2, 2, 'Thử thách HTML/CSS', 'Câu hỏi về frontend cơ bản', '2025-12-06 03:23:34'),
(4, 4, 'Ai là Goat', 'Chỉ chọn a, hoặc b, hoặc c, hoặc d, chọn cái khác = thiểu năng trí tuệ\r\n', '2025-12-08 14:52:03'),
(7, 4, 'ádasd', 'ádasdadsasđsa', '2025-12-08 18:55:04'),
(8, 7, 'Bạn có phải là gay ?', 'vượt qua thử thách để ko bị gay', '2025-12-09 12:24:52'),
(9, 23, 'banhs', 'keoj', '2025-12-11 06:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `challenge_attempts`
--

CREATE TABLE `challenge_attempts` (
  `id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `attempt_count` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `challenge_attempts`
--

INSERT INTO `challenge_attempts` (`id`, `challenge_id`, `user_id`, `score`, `attempt_count`, `created_at`) VALUES
(1, 1, 2, 2, 1, '2025-12-06 03:26:27'),
(2, 2, 1, 1, 9, '2025-12-06 03:26:27'),
(3, 4, 1, 1, 10, '2025-12-08 20:07:49'),
(4, 7, 1, 1, 2, '2025-12-08 20:16:05'),
(5, 4, 4, 3, 2, '2025-12-09 12:25:07'),
(9, 9, 1, 0, 1, '2025-12-12 21:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followed_id`, `created_at`) VALUES
(2, 2, 1, '2025-12-06 03:27:44'),
(23, 1, 4, '2025-12-08 20:26:39'),
(24, 1, 7, '2025-12-09 11:58:15'),
(27, 4, 4, '2025-12-09 12:25:36'),
(28, 7, 4, '2025-12-09 12:25:38'),
(29, 7, 7, '2025-12-09 12:31:43'),
(32, 4, 6, '2025-12-09 12:34:38'),
(33, 7, 6, '2025-12-09 12:35:27'),
(39, 21, 6, '2025-12-09 22:22:35'),
(54, 1, 6, '2025-12-12 20:43:13'),
(56, 1, 5, '2025-12-12 22:02:43'),
(62, 1, 2, '2025-12-12 22:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `name`) VALUES
(2, 'Âm nhạc'),
(23, 'Ẩm thực quốc tế'),
(22, 'Ẩm thực Việt Nam'),
(19, 'Bơi lội'),
(20, 'Cắm trại'),
(37, 'Chơi nhạc cụ'),
(8, 'Chụp ảnh'),
(1, 'Coding'),
(11, 'Công nghệ'),
(3, 'Du lịch'),
(21, 'Đi bộ đường dài'),
(34, 'Đồ thủ công'),
(6, 'Đọc sách'),
(12, 'Game online'),
(26, 'Học ngoại ngữ'),
(27, 'Khám phá văn hóa'),
(41, 'Khám phá vũ trụ'),
(16, 'Khiêu vũ'),
(40, 'Khoa học'),
(29, 'Khởi nghiệp'),
(13, 'Kinh doanh'),
(36, 'Làm vườn'),
(18, 'Leo núi'),
(38, 'Manga & Anime'),
(9, 'Mỹ thuật'),
(7, 'Nấu ăn'),
(15, 'Nghệ thuật đường phố'),
(4, 'Phim ảnh'),
(31, 'Podcast'),
(24, 'Sưu tầm'),
(39, 'Thảo luận chính trị'),
(5, 'Thể thao'),
(35, 'Thiết kế nội thất'),
(14, 'Thời trang'),
(10, 'Thú cưng'),
(28, 'Tình nguyện'),
(32, 'Trà & Cà phê'),
(25, 'Viết lách'),
(33, 'Xe cộ & tốc độ'),
(30, 'Xem hài kịch'),
(17, 'Yoga & Thiền');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `content`, `is_correct`) VALUES
(5, 3, '<a>', 1),
(6, 3, '<link>', 0),
(95, 28, 'ádasd', 0),
(96, 28, 'sadasd', 1),
(97, 28, 'ádasd', 0),
(98, 28, 'ádasd', 0),
(99, 29, 'ádasd', 0),
(100, 29, 'ádasd', 1),
(101, 29, 'âsdasd', 0),
(102, 29, 'ádasdasd', 0),
(103, 30, 'ádasd', 1),
(104, 30, 'ádasd', 0),
(105, 30, 'ádasd', 0),
(106, 30, 'ádasd', 0),
(107, 31, 'ádasd', 0),
(108, 31, 'ádasd', 0),
(109, 31, 'ádasd', 1),
(110, 31, 'ádasd', 0),
(111, 32, 'Personal Home Page', 1),
(112, 32, 'Private Hosting Platform', 0),
(113, 33, 'echo', 1),
(114, 33, 'print_screen', 0),
(115, 34, 'là lẩu gà bình thuận', 0),
(116, 34, 'lũ gay', 0),
(117, 34, 'Trần Bình', 0),
(118, 34, 'HK', 1),
(135, 39, 'messi', 0),
(136, 39, 'lam vlog', 0),
(137, 39, 'mrbeast', 0),
(138, 39, 'suiiiiiiiiii tạ', 1),
(139, 40, 'suiiiiiiiiii', 1),
(140, 40, 'mp3', 0),
(141, 40, 'lê minh gia mẫn', 0),
(142, 40, 'HK', 0),
(143, 41, 'Myke Tyson', 0),
(144, 41, 'Suiiiiiiiiiiiiiiiiiiiiii tạ', 1),
(145, 41, 'Hulk', 0),
(146, 41, 'Đạt G', 0),
(147, 42, 'Có', 0),
(148, 42, 'Chắc chắn có', 1),
(149, 42, 'Không thể nào không', 0),
(150, 42, 'Cả ba ý trên', 0),
(151, 43, 'banh', 1),
(152, 43, 'keo', 0),
(153, 43, 'keo', 0),
(154, 43, 'banh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `challenge_id`, `content`) VALUES
(3, 2, 'Thẻ nào dùng để tạo hyperlink trong HTML?'),
(28, 7, 'ádasd'),
(29, 7, 'ádasdasd'),
(30, 7, 'ádasdas'),
(31, 7, 'ádasdasd'),
(32, 1, 'PHP viết tắt của từ nào?'),
(33, 1, 'Hàm nào dùng để in ra màn hình trong PHP?'),
(34, 8, 'lgbt là gì'),
(39, 4, 'ai có nút kim cương youtube'),
(40, 4, 'ai tập gym 2h sau khi làm xong chuyện ấy 2p'),
(41, 4, 'Ai có cú thục cùi chỏ mạnh nhất thế giới?'),
(42, 4, 'Dương có đẹp trai không ?'),
(43, 9, 'banhs hay keoj');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('man','woman','other') DEFAULT 'other',
  `orientation` enum('straight','gay','lesbian','bisexual','other') DEFAULT 'other',
  `interested_in` enum('man','woman','everyone') DEFAULT 'everyone',
  `relationship_intent` enum('friends','serious','unsure') DEFAULT 'unsure',
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `birth_date`, `gender`, `orientation`, `interested_in`, `relationship_intent`, `avatar_url`, `created_at`, `role`) VALUES
(1, 'ADuck', 'ADuck@example.com', '$2y$10$wGdnG1xerkhc3HRKfsVMpereDOwjVe6CqnLIE7MNaVqoKxSp8UCYS', '2004-05-20', 'man', 'straight', 'everyone', 'friends', '1765183528_aDuck.png', '2025-12-06 03:21:31', 'admin'),
(2, 'Lann', 'lan@example.com', '$2y$10$z7URxCfVx1tCqWUXXW07/.T5vlTE1bdtloqQ7dEsNudPm.03HBN.y', '1997-08-15', 'woman', 'straight', 'man', 'serious', 'lan.png', '2025-12-06 03:21:31', 'user'),
(4, 'duoz', 'duoz@example.com', '$2y$10$CTDifKHKud80WKSoYGchIOjKSOVF3d9UOztHx5OWUk3t1jwG1hodm', '2001-11-13', 'man', 'straight', 'woman', 'serious', '1765156474_image_13-hinh-nen-powerpoint-ve-dang-cong-san-viet-nam.jpg', '2025-12-08 01:14:34', 'user'),
(5, 'BeDau', 'bedau@example.com', '$2y$10$nDxyxyU0w0okk.ehnwYdtO64/Iupyjoug3SFHEBONgRulXzMMflaK', '2004-09-14', 'other', 'bisexual', 'everyone', 'unsure', '1765156907_bedau.jpg', '2025-12-08 01:21:47', 'admin'),
(6, 'Faker', 'faker@example.com', '$2y$10$MQAWM5pJ.sDEj8o5oEoKOuXdpzebltoEYcRlLkGzdAEAVt0ORKRd6', '1990-09-14', 'man', 'straight', 'woman', 'unsure', '1765157172_faker.jpg', '2025-12-08 01:26:12', 'user'),
(7, 'Aben', 'aben@example.com', '$2y$10$3MAliXy/gj7YkXaTM.7fFOIF1ZAXfHSx3rce3U/47pBhs/X.Ap5aC', '2004-09-14', 'man', 'straight', 'woman', 'unsure', '1765157274_aben.jpg', '2025-12-08 01:27:54', 'user'),
(21, 'Sơn Tùng MTP', 'tung@gmail.com', '$2y$10$D8IfQU0qh27ID5UObziCluGxK53aUfb/gYiC355cej.OV5pySZbGW', '1995-11-23', 'man', 'straight', 'woman', 'friends', '1765318872_sontung.jpg', '2025-12-09 22:21:12', 'user'),
(23, 'windows', 'win@gmail.com', '$2y$10$/NbfmN5MpC4DnwfO3DsUd..2CAd2bkooRnlREhEQGwP5/lwbpWFoS', '2021-01-02', 'other', 'other', 'man', 'serious', '1765434641_Windows 11 Wallpaper 1.jpg', '2025-12-11 06:30:41', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

CREATE TABLE `user_interests` (
  `user_id` int(11) NOT NULL,
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_interests`
--

INSERT INTO `user_interests` (`user_id`, `interest_id`) VALUES
(7, 1),
(7, 2),
(21, 2),
(2, 3),
(21, 6),
(21, 8),
(7, 11),
(7, 12),
(21, 14),
(1, 21),
(1, 23),
(23, 23),
(1, 26),
(1, 27),
(7, 28),
(7, 33),
(21, 37),
(7, 38),
(7, 39),
(1, 41);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge_id` (`challenge_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`user_id`,`interest_id`),
  ADD KEY `interest_id` (`interest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `challenge_attempts`
--
ALTER TABLE `challenge_attempts`
  ADD CONSTRAINT `challenge_attempts_ibfk_1` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenge_attempts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_interests_ibfk_2` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
