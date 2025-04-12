-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 12, 2025 lúc 07:04 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `examstest`
--

CREATE TABLE `examstest` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `exam_link` varchar(500) NOT NULL,
  `image_path` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `examstest`
--

INSERT INTO `examstest` (`id`, `title`, `description`, `exam_link`, `image_path`, `created_at`, `start_time`, `end_time`, `created_by`) VALUES
(18, 'bài thi đoàn test 2', 'test', 'https://docs.google.com/forms/d/e/1FAIpQLScZfJ4GZziT3zggdNtWTRZZQZLnxQV7P5bXkK1898qHFfOZhQ/formResponse', 'uploads/doanthanhnien.png', '2025-03-31 08:17:49', '2025-03-30 00:12:00', '2025-04-26 00:12:00', NULL),
(19, 'bài thi đoàn test 3', 'test', 'https://docs.google.com/forms/d/e/1FAIpQLScZfJ4GZziT3zggdNtWTRZZQZLnxQV7P5bXkK1898qHFfOZhQ/formResponse', 'uploads/doanthanhnien.png', '2025-03-31 08:18:45', '2025-03-29 00:12:00', '2025-04-17 00:12:00', NULL),
(20, 'bài thi đoàn test 5', 'aaaaaa', 'https://docs.google.com/forms/d/e/1FAIpQLScZfJ4GZziT3zggdNtWTRZZQZLnxQV7P5bXkK1898qHFfOZhQ/formResponse', 'uploads/1743409164_doanthanhnien.png', '2025-03-31 08:19:24', '2025-03-22 15:19:00', '2025-04-19 15:19:00', NULL),
(23, 'test đoàn', 'test', 'https://docs.google.com/forms/d/e/1FAIpQLScZfJ4GZziT3zggdNtWTRZZQZLnxQV7P5bXkK1898qHFfOZhQ/formResponse', 'uploads/1744063912_doanthanhnien.png', '2025-04-07 22:11:52', '2025-04-07 05:11:00', '2025-04-25 05:11:00', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_attempts`
--

INSERT INTO `exam_attempts` (`id`, `student_id`, `exam_id`, `start_time`, `image_path`, `image_id`) VALUES
(29, 40, 18, '2025-04-06 19:56:14', NULL, 39),
(30, 41, 20, '2025-04-06 22:15:50', NULL, 40),
(31, 30, 19, '2025-04-07 23:19:39', NULL, 55),
(32, 30, 20, '2025-04-07 23:22:24', NULL, 56),
(34, 30, 18, '2025-04-08 05:35:14', NULL, 54),
(35, 45, 20, '2025-04-08 08:10:26', NULL, NULL),
(36, 30, 23, '2025-04-08 13:42:29', NULL, 57);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_history`
--

CREATE TABLE `exam_history` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `examtest_id` int(11) NOT NULL,
  `exam_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `student_id`, `image`, `image_path`) VALUES
(23, 30, '', 'uploads/tải xuống (1).jpg'),
(25, 30, '', 'uploads/tải xuống (1).jpg'),
(28, 40, '', 'uploads/avatar-buon-21.jpg'),
(29, 40, '', 'uploads/avatar-buon-21.jpg'),
(30, 40, '', 'uploads/1743951942_200-anh-lam-slide-powerpoint-cuc-dep-chuyen-nghiep-khong (125)-800x500.jpg'),
(31, 41, '', 'uploads/Oracle 12.png'),
(32, 41, '', 'uploads/Oracle 12.png'),
(33, 41, '', 'uploads/Oracle 12.png'),
(34, 41, '', 'uploads/z4733268971139_85f6e14502a7a650a482c36a0da27d68.jpg'),
(35, 41, '', 'uploads/z4733268971139_85f6e14502a7a650a482c36a0da27d68.jpg'),
(36, 41, '', 'uploads/Oracle 12.png'),
(37, 41, '', 'uploads/z4733268971139_85f6e14502a7a650a482c36a0da27d68.jpg'),
(38, 40, '', 'uploads/avatar-buon-21.jpg'),
(39, 40, '', 'uploads/avatar-buon-21.jpg'),
(40, 41, '', 'uploads/avatar-buon-21.jpg'),
(41, 30, '', 'uploads/doanthanhnien.png'),
(42, 30, '', 'uploads/doanthanhnien.png'),
(43, 30, '', 'uploads/doanthanhnien.png'),
(44, 30, '', 'uploads/pngtree-40-speed-limit-sign-limitation-speed-black-photo-picture-image_5697930.jpg'),
(45, 30, '', 'uploads/doanthanhnien.png'),
(46, 30, '', 'uploads/doanthanhnien.png'),
(47, 30, '', 'uploads/doanthanhnien.png'),
(48, 30, '', 'uploads/pngtree-40-speed-limit-sign-limitation-speed-black-photo-picture-image_5697930.jpg'),
(49, 30, '', 'uploads/doanthanhnien.png'),
(50, 30, '', 'uploads/z6484281086431_01df2777e8e1a9a1594010ddbcc41585.jpg'),
(51, 30, '', 'uploads/z6484281086431_01df2777e8e1a9a1594010ddbcc41585.jpg'),
(52, 30, '', 'uploads/z6484281086431_01df2777e8e1a9a1594010ddbcc41585.jpg'),
(53, 30, '', 'uploads/z6484281086431_01df2777e8e1a9a1594010ddbcc41585.jpg'),
(54, 30, '', 'uploads/Screenshot 2025-03-25 130816.png'),
(55, 30, '', 'uploads/Screenshot 2025-03-25 130816.png'),
(56, 30, '', 'uploads/Screenshot 2025-03-25 130816.png'),
(57, 30, '', 'uploads/Screenshot 2025-03-25 130816.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa`
--

CREATE TABLE `khoa` (
  `id` int(11) NOT NULL,
  `ten_khoa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoa`
--

INSERT INTO `khoa` (`id`, `ten_khoa`) VALUES
(1, 'Công nghệ thông tin'),
(2, 'Kinh tế'),
(3, 'Kỹ thuật'),
(5, 'Ngoại ngữ'),
(4, 'Văn học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `link_clicks`
--

CREATE TABLE `link_clicks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `examtest_id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `id` int(11) NOT NULL,
  `ten_lop` varchar(255) NOT NULL,
  `khoa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`id`, `ten_lop`, `khoa_id`) VALUES
(1, 'CNTT1', 1),
(2, 'CNTT2', 1),
(3, 'KT1', 2),
(4, 'KYTH1', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien_lop`
--

CREATE TABLE `sinhvien_lop` (
  `id` int(11) NOT NULL,
  `sinhvien_id` int(11) DEFAULT NULL,
  `lop_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `khoa_id` int(11) NOT NULL,
  `lop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `khoa_id`, `lop_id`) VALUES
(30, 'Nguyễn Hữu Kim', 'anhanh@gmail.com', '123456', 1, 1),
(40, 'Nguyễn Van A', 'kimkim@gmail.com', '111', 1, 2),
(41, 'Nguyễn Hữu anh', 'anhanhanh@gmail.com', '123456', 2, 3),
(45, 'anhhhkimmm', 'testo1@gmail.com', '123456', 2, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `password`) VALUES
(2, 'Trần Thị B', 'giangvien01@gmail.com', 'password123');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `examstest`
--
ALTER TABLE `examstest`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `exam_history`
--
ALTER TABLE `exam_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `examtest_id` (`examtest_id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `examstest`
--
ALTER TABLE `examstest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `exam_history`
--
ALTER TABLE `exam_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD CONSTRAINT `exam_attempts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_attempts_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `examstest` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_history`
--
ALTER TABLE `exam_history`
  ADD CONSTRAINT `exam_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_history_ibfk_2` FOREIGN KEY (`examtest_id`) REFERENCES `examstest` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
