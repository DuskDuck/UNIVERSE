-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 02, 2023 lúc 04:59 PM
-- Phiên bản máy phục vụ: 10.4.25-MariaDB
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `social`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `channel`
--

CREATE TABLE `channel` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `group_img` varchar(255) NOT NULL,
  `voice_channel` text NOT NULL,
  `text_channel` text NOT NULL,
  `invite_code` int(11) NOT NULL,
  `admin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `channel`
--

INSERT INTO `channel` (`id`, `name`, `group_img`, `voice_channel`, `text_channel`, `invite_code`, `admin`) VALUES
(1, 'Web Hust Group 03', 'asset/images/profile_pic/default/BrownDwarf.png', 'Voice Room,Meeting,ok ko', 'General Chat,Front-end Team,Back-end Team,Da Hell is this,Wut', 6969, 'dai_ca'),
(2, 'Test channel', 'asset/images/profile_pic/default/Circle.png', 'Test channel #1,Test channel #2', 'General Chat,Test channel #1,Test channel #2', 9999, ''),
(18, 'Dusk Duck Planet', 'asset/images/uploads/Insomnia - Copy.jpg', 'Voice Room', 'General Chat', 789664, 'dai_ca'),
(19, 'Test Planet', 'asset/images/uploads/HAN_MAP-01.png', 'Voice Room', 'General Chat,BE group', 932115, 'test_user01'),
(20, 'Kenh Moi', 'asset/images/uploads/HAN_MAP-01.png', 'Voice Room,ok', 'General Chat,Cho Duan', 450480, 'test_user01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(1, 'hello', 'duc_nguyen_1', 'duc_nguyen_1', '2022-12-28 23:20:52', 'no', 100),
(2, 'hello again', 'duc_nguyen_1', 'adam_warlock', '2022-12-28 23:21:19', 'no', 104),
(3, 'hello', 'duc_nguyen_1', 'ceo_Đức', '2022-12-28 23:26:24', 'no', 99);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(62, 'ceo_Duc', 128),
(63, 'test_user01', 15),
(64, 'test_user01', 14),
(66, 'dai_ca', 16),
(67, 'test_user01', 16),
(68, 'dai_ca', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `from_channel` text NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `from_channel`, `group_id`) VALUES
(35, 'ok ', 'dai_ca', 'none', '2023-02-28 17:41:37', 'no', 'no', 0, 'General Chat', 1),
(36, 'hello', 'dai_ca', 'none', '2023-02-28 17:42:27', 'no', 'no', 0, 'Front-end Team', 1),
(37, 'ok ko', 'dai_ca', 'none', '2023-02-28 17:45:40', 'no', 'no', 0, 'General Chat', 1),
(38, 'alo', 'dai_ca', 'none', '2023-02-28 17:45:47', 'no', 'no', 0, 'Front-end Team', 1),
(39, 'hello', 'dai_ca', 'none', '2023-02-28 17:45:59', 'no', 'no', 0, 'Front-end Team', 1),
(40, 'ok', 'dai_ca', 'none', '2023-02-28 17:46:53', 'no', 'no', 0, 'General Chat', 1),
(41, 'no tok', 'dai_ca', 'none', '2023-02-28 17:46:59', 'no', 'no', 0, 'General Chat', 1),
(42, 'ok', 'dai_ca', 'none', '2023-02-28 17:49:35', 'no', 'no', 0, 'General Chat', 1),
(43, 'ok', 'dai_ca', 'none', '2023-02-28 17:50:12', 'no', 'no', 0, 'General Chat', 1),
(44, 'ok', 'dai_ca', 'none', '2023-02-28 17:50:12', 'no', 'no', 0, 'General Chat', 1),
(45, 'again', 'dai_ca', 'none', '2023-02-28 17:51:55', 'no', 'no', 0, 'General Chat', 1),
(46, 'co ve ok r', 'dai_ca', 'none', '2023-02-28 17:52:02', 'no', 'no', 0, 'General Chat', 1),
(47, 'ok', 'dai_ca', 'none', '2023-02-28 17:54:12', 'no', 'no', 0, 'Front-end Team', 1),
(48, 'ok', 'dai_ca', 'none', '2023-02-28 17:55:06', 'no', 'no', 0, 'Front-end Team', 1),
(49, 'xin chao', 'dai_ca', 'none', '2023-02-28 17:56:01', 'no', 'no', 0, 'Back-end Team', 1),
(50, 'hello', 'test_user01', 'none', '2023-02-28 17:56:17', 'no', 'no', 0, 'Back-end Team', 1),
(51, 'ok ko', 'dai_ca', 'none', '2023-02-28 17:59:32', 'no', 'no', 0, 'Back-end Team', 1),
(52, 'ok', 'test_user01', 'none', '2023-02-28 17:59:40', 'no', 'no', 0, 'Back-end Team', 1),
(53, 'hello again', 'test_user01', 'none', '2023-02-28 17:59:47', 'no', 'no', 0, 'Front-end Team', 1),
(54, 'ok ko k', 'dai_ca', 'none', '2023-02-28 19:20:36', 'no', 'no', 0, 'General Chat', 1),
(55, 'ok r', 'dai_ca', 'none', '2023-02-28 19:20:55', 'no', 'no', 0, 'Front-end Team', 1),
(56, 'again', 'dai_ca', 'none', '2023-02-28 19:20:59', 'no', 'no', 0, 'Front-end Team', 1),
(57, 'hello', 'test_user01', 'none', '2023-03-01 19:43:58', 'no', 'no', 0, 'General Chat', 1),
(58, 'hi bud', 'dai_ca', 'none', '2023-03-01 19:44:12', 'no', 'no', 0, 'General Chat', 1),
(59, 'oh hi', 'test_user01', 'none', '2023-03-01 19:44:28', 'no', 'no', 0, 'General Chat', 1),
(60, 'how things  ', 'test_user01', 'none', '2023-03-01 19:44:37', 'no', 'no', 0, 'General Chat', 1),
(61, 'going well i guess', 'dai_ca', 'none', '2023-03-01 19:44:47', 'no', 'no', 0, 'General Chat', 1),
(62, 'cool! cool!', 'test_user01', 'none', '2023-03-01 19:45:01', 'no', 'no', 0, 'General Chat', 1),
(63, 'hello', 'dai_ca', 'none', '2023-03-02 20:43:35', 'no', 'no', 0, 'Wut', 1),
(64, 'hello', 'test_user01', 'none', '2023-03-02 22:01:23', 'no', 'no', 0, 'General Chat', 1),
(65, 'hello', 'test_user01', 'none', '2023-03-02 22:05:46', 'no', 'no', 0, 'General Chat', 1),
(66, 'Hi', 'super_admin', 'none', '2023-03-02 22:06:19', 'no', 'no', 0, 'General Chat', 1),
(67, 'Ha noi', 'test_user01', 'none', '2023-03-02 22:09:17', 'no', 'no', 0, 'Da Hell is this', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `users_close` varchar(3) NOT NULL,
  `friend_array` text NOT NULL,
  `group_id` text NOT NULL,
  `online` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `users_close`, `friend_array`, `group_id`, `online`) VALUES
(17, 'Test', 'User01', 'test_user01', 'Tester1@gmail.com', '050b4c9f2a7a86a78d25ba1cc5b0a752', '2022-11-06', 'asset/images/profile_pic/default/DefaultUser.png', 28, 4, 'no', ',', '1,2,19,20', 0),
(24, 'Dai', 'Ca', 'dai_ca', 'Nhuduc12754@gmail.com', '050b4c9f2a7a86a78d25ba1cc5b0a752', '2023-01-01', 'asset/images/profile_pic/default/DefaultUser.png', 35, 0, 'no', ',', '1,18,2', 1),
(25, 'Duan', 'Cong', 'duan_cong', 'Congduan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2023-02-12', 'asset/images/profile_pic/default/DefaultUser.png', 0, 0, 'no', ',', '1', 1),
(27, 'Super', 'Admin', 'super_admin', 'Superadmin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2023-03-02', 'asset/images/profile_pic/default/DefaultUser.png', 1, 0, 'no', ',', '1', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `channel`
--
ALTER TABLE `channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
