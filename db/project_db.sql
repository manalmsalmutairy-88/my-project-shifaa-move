-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `centers_services`
--

CREATE TABLE `centers_services` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `address_link` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `centers_services`
--

INSERT INTO `centers_services` (`id`, `title`, `address_link`, `phone`, `description`, `image_path`) VALUES
(1, 'مركز علاجي المتكامل', 'https://elajicenter.com/', '0505206644', 'الرياض', 'center4.jpg'),
(2, 'رعاية أمين', 'https://www.ameen.care/', '920034027', 'الرياض', 'center3.jpg'),
(3, 'سمارت كير', 'https://smartcare.pw/', '920031686', 'الرياض', 'center2.jpg'),
(4, 'فيزيوثيرابيا', 'https://physiotherabia.com/ar/', '8001000091', 'الرياض, الشرقية, جدة, المدينة المنورة, تبوك', 'center1.jpg'),
(5, 'طريق التداوي', 'https://share.google/uoJAFlArSoICCpKtS', '0501237733', 'عنيزة', 'center5.jpg.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `full_name`, `email`, `subject`, `message`, `created_at`) VALUES
(4, 'test', 'test@gmail.com', 'استفسار', 'هل سيتم توفير المزيد من المقاطع؟', '2026-05-07 16:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `tool_id` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `video_id`, `tool_id`, `added_at`) VALUES
(74, 5, NULL, 1, '2026-05-07 16:00:39'),
(91, 5, NULL, 10, '2026-05-07 22:48:12'),
(94, 5, NULL, 4, '2026-05-07 23:05:08'),
(103, 26, 15, NULL, '2026-05-09 04:07:55'),
(104, 26, 13, NULL, '2026-05-09 04:07:57'),
(105, 26, NULL, 1, '2026-05-09 04:08:04'),
(106, 26, NULL, 12, '2026-05-09 04:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `medical_tools`
--

CREATE TABLE `medical_tools` (
  `id` int(11) NOT NULL,
  `tool_name` varchar(150) NOT NULL,
  `tool_desc` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `purchase_link` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_tools`
--

INSERT INTO `medical_tools` (`id`, `tool_name`, `tool_desc`, `image_url`, `purchase_link`, `created_at`, `category`) VALUES
(1, 'دعامة الإبهام والمعصم', 'توفير الدعم والراحة لمفصل المعصم', 'images/t1.jpeg', 'https://shortlink.uk/1uxHK', '2026-05-06 12:44:05', 'أدوات اليد والمعصم'),
(2, 'شبكة تمارين اليد والأصابع', 'أداة مثالية لتقوية قبضة اليد وتحسين مرونة الأصابع', 'images/t2.jpeg', 'https://shop.tiriaqq.com/ar/dbEOwKj', '2026-05-06 12:44:05', 'أدوات اليد والمعصم'),
(3, 'سبايكر فلكس بار مطاطي', 'تستخدم لتمارين تقوية اليد والذراع', 'images/t3.jpeg', 'https://shop.tiriaqq.com/ar/Yggnbog', '2026-05-06 12:44:05', 'أدوات اليد والمعصم'),
(4, 'لوحة التوازن', 'تستخدم في تمارين التأهيل وتقوية الكاحل', 'images/t4.jpeg', 'https://shop.tiriaqq.com/ar/OqrYAYD', '2026-05-06 12:44:05', 'أدوات التأهيل والتدريب'),
(5, 'ملاءة سحب طبية بمقابض', 'تساعد الفريق الطبي على رفع المريض بأمان', 'images/t5.jpeg', 'https://shortlink.uk/1uxI0', '2026-05-06 12:44:05', 'أدوات التأهيل والتدريب'),
(6, 'ملاءة تسهيل نقل المرضى', 'تستخدم لتسهيل حركة المريض على السرير', 'images/t6.jpeg', 'https://shortlink.uk/1uxId', '2026-05-06 12:44:05', 'أدوات التأهيل والتدريب'),
(7, 'كرسي متحرك كهربائي قابل للطي', 'كرسي خفيف الوزن وسهل التنقل للاستخدام اليومي', 'images/t7.jpeg', 'https://shortlink.uk/1uxIx', '2026-05-06 12:44:05', 'أدوات الحركة والدعم'),
(8, 'عكاز ألومنيوم قابل للطي', 'عكاز متين وعالي التعديل الارتفاع لراحة المستخدم', 'images/t8.jpeg', 'https://shortlink.uk/1pd1C', '2026-05-06 12:44:05', 'أدوات الحركة والدعم'),
(9, 'حامل يد (علاقة كتف)', 'لتثبيت الذراع وتخفيف الوزن عن الكتف بعد الإصابات', 'images/t9.jpeg', 'https://shortlink.uk/1pd1S', '2026-05-06 12:44:05', 'أدوات الحركة والدعم'),
(10, 'دعامة قدم ليلية', 'تستخدم لعلاج التهاب اللفافة الأخمصية وتصحيح وضع القدم', 'images/t10.jpeg', 'https://shortlink.uk/1uxJI', '2026-05-06 12:44:05', 'دعامة الظهر والقدم'),
(11, 'دعامة هوائية للكاحل والقدم', 'توفر ضغطاً وتثبيتاً ممتازاً لإصابات الكاحل الشديدة', 'images/t11.jpeg', 'https://goo.su/f3nzT', '2026-05-06 12:44:05', 'دعامة الظهر والقدم'),
(12, 'دعامة الظهر للتقوس', 'تساعد في تحسين القوام وعلاج تقوس العمود الفقري', 'images/t12.jpeg', 'https://shortlink.uk/1uxfr', '2026-05-06 12:44:05', 'دعامة الظهر والقدم');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(1, 'admin', 'admin_shifaa@test.com', '$2y$12$Ac./.Ot8UhLcw6uTCJCpeupGv1wAn8AHZ89Eu/UWaU0QTb62NPyZq', 'admin', '2026-04-11 16:52:11', ''),
(5, 'm', 'test@gmail.com', '$2y$10$GfKixNVxxAtsZH.caLDHwuqf2gUcFmsfsKDE2vZ.f/zqpJUQbanBO', 'user', '2026-05-07 16:00:06', 'active'),
(6, 'm', 'test2@gmail.com', '$2y$10$zbNnUufP9nksBI/8Cx1EFemi1ChiZS4OuT2fAMpkz43U0UUJVeEA6', 'user', '2026-05-08 01:51:37', 'active'),
(10, 'test', 'test3@gmail.com', '$2y$10$yad.N4THEkmTrpcmHKONy.tfjhaQ3JWPIFMkHpsxUs/unlUD/1tbC', 'user', '2026-05-08 04:12:55', ''),
(26, 'test', 'test4@gmail.com', '$2y$10$zYPEKwIpYf6aSxb5ZlQXPOfTKRgAqprsgAJ4XqEgn3iap0dNxMb8.', 'user', '2026-05-09 04:07:06', '');

-- --------------------------------------------------------

--
-- Table structure for table `videos_content`
--

CREATE TABLE `videos_content` (
  `id` int(11) NOT NULL,
  `video_title` varchar(150) NOT NULL,
  `video_source` varchar(255) NOT NULL,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL,
  `video_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos_content`
--

INSERT INTO `videos_content` (`id`, `video_title`, `video_source`, `video_url`, `video_num`) VALUES
(24, 'تمرين مابعد العمليات الجراحية أوتار الكتف', 'مركز طريق التداوي', 'video_1.mp4', 1),
(25, 'تمرين كبار السن خشونه القدم', 'مركز طريق التداوي', 'video_2.mp4', 2),
(26, 'تمرين كبار السن خشونة الركبة', 'مركز طريق التداوي', 'video_3.mp4', 3),
(27, 'تمرين كبار السن لياقة عامة', 'مركز طريق التداوي', 'video_4.mp4', 4),
(28, 'تمرين كبار السن لياقة عامة', 'مركز طريق التداوي', 'video_5.mp4', 5),
(29, 'تمرين كبار السن لياقة عامة', 'مركز طريق التداوي', 'video_6.mp4', 6),
(30, 'تمرين كبار السن لياقة عامة', 'مركز طريق التداوي', 'video_7.mp4', 7),
(31, ' تمارين مابعد العمليات الجراحية-أوتار الكتف', 'مركز طريق التداوي', 'video_8.mp4', 8),
(32, 'تمرين مابعد العمليات الجراحية-أوتار الكتف', 'مركز طريق التداوي', 'video_9.mp4', 9),
(33, 'تمارين مابعد العمليات الجراحية-تبديل مفصل الركبة', 'مركز طريق التداوي', 'video_10.mp4', 10),
(34, 'تمارين مابعد العمليات-أوتار الكتف', 'مركز طريق التداوي', 'video_11.mp4', 11),
(35, ' تمارين مابعد العمليات الجراحية-تبديل مفصل الركبة', 'مركز طريق التداوي', 'video_12.mp4', 12),
(36, 'تمرين الشدود العضلية: الرقبة', 'مركز طريق التداوي', 'video_13.mp4', 13),
(37, 'تمرين الشدود العضلية :الرقبة', 'مركز طريق التداوي', 'video_14.mp4', 14),
(38, 'تمرين الشدود العضلية: الرقبة', 'مركز طريق التداوي', 'video_15.mp4', 15),
(39, ' تمارين مابعد العمليات الجراحية-تبديل مفصل الركبة', 'مركز طريق التداوي', 'video_16.mp4', 16),
(40, 'تمرين 18 الشدود العضلية أسفل الظهر', 'مركز طريق التداوي', 'video_17.mp4', 17),
(41, 'تمرين الشدود العضلية أسفل الظهر', 'مركز طريق التداوي', 'video_18.mp4', 18),
(42, 'تمرين الشدود العضلية اسفل الظهر', 'مركز طريق التداوي', 'video_19.mp4', 19),
(43, 'تمرين الشدود العضلية الأرجل', 'مركز طريق التداوي', 'video_20.mp4', 20),
(44, 'تمرين الشدود العضلية الأرجل', 'مركز طريق التداوي', 'video_21.mp4', 21),
(45, 'تمرين الشدود العضلية الأرجل', 'مركز طريق التداوي', 'video_22.mp4', 22);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centers_services`
--
ALTER TABLE `centers_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_tools`
--
ALTER TABLE `medical_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos_content`
--
ALTER TABLE `videos_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `centers_services`
--
ALTER TABLE `centers_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `medical_tools`
--
ALTER TABLE `medical_tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `videos_content`
--
ALTER TABLE `videos_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
