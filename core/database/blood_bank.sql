-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 05:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `phone`, `email`, `website`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Joty Biswas', '+8801403107510', 'jotybiswas0199@gmail.com', 'https://www.akcc.gov.bd/', 'profile/vlQ1leum3YDC8S78UwW5RBlkNi6xQjVGsA13JCwk.jpg', '2026-03-02 11:07:11', '2026-03-03 03:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_01_094305_create_accounts_table', 1),
(5, '2026_03_01_140515_create_contacts_table', 1),
(6, '2026_03_02_114111_create_profiles_table', 1),
(7, '2026_03_03_154141_create_profiles_table', 2),
(8, '2026_03_03_155057_create_profiles_table', 3),
(9, '2026_03_03_155242_make_division_nullable_in_profiles_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `blood` varchar(5) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `division` varchar(100) NOT NULL,
  `last_donated` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `name`, `blood`, `number`, `division`, `last_donated`, `created_at`, `updated_at`) VALUES
(5, NULL, 'Md. Masum Billah', 'O+', '01819-758720', 'Dhaka', '2026-03-03', '2026-03-02 12:40:02', '2026-03-03 09:09:04'),
(6, NULL, 'Shishir Sarkar', 'O+', '01946-819226', 'Khulna', '2026-03-03', '2026-03-02 12:40:24', '2026-03-03 09:15:47'),
(7, NULL, 'Sadman Sakib Siam', 'O+', '01818-896-045', 'Khulna', '2026-03-03', '2026-03-02 12:40:47', '2026-03-03 09:15:40'),
(8, NULL, 'Rahat Jubayer', 'O+', '01408-320845', 'Dhaka', '2026-03-03', '2026-03-02 12:41:12', '2026-03-03 09:15:34'),
(9, NULL, 'Shefatullah', 'O+', '01763-631-688', 'Chattogram', '2026-03-04', '2026-03-02 12:42:19', '2026-03-03 09:15:28'),
(10, NULL, 'Sabbir Sayan', 'O+', '01790-805-900', 'Chattogram', '2026-03-02', '2026-03-02 12:43:05', '2026-03-03 09:15:22'),
(11, NULL, 'Tahmid Hasan Tamim', 'O+', '01908-079-197', 'Dhaka', '2026-03-03', '2026-03-02 12:43:25', '2026-03-03 09:15:15'),
(12, NULL, 'Md. Rakibul Islam', 'O+', '01806-828-790', 'Khulna', '2026-02-03', '2026-03-02 12:44:09', '2026-03-03 09:15:09'),
(13, NULL, 'Md. Al-Amin', 'O+', '01568-575-881', 'Khulna', '2026-01-03', '2026-03-02 12:44:57', '2026-03-03 09:15:02'),
(14, NULL, 'Md. Imran Hosen', 'O+', '01808-705-270', 'Dhaka', '2026-01-16', '2026-03-02 12:45:15', '2026-03-03 09:14:56'),
(15, NULL, 'Rabi', 'O+', '01911-119-675', 'Chattogram', '2025-11-19', '2026-03-02 12:45:37', '2026-03-03 09:14:48'),
(16, NULL, 'Arif', 'O+', '01910-686-656', 'Chattogram', '2025-11-21', '2026-03-02 12:45:59', '2026-03-03 09:14:41'),
(17, NULL, 'Hasan', 'O+', '01808-978-112', 'Chattogram', '2025-11-21', '2026-03-02 12:46:21', '2026-03-03 09:14:35'),
(18, NULL, 'Tamim', 'O+', '01638-191-286', 'Dhaka', '2025-12-19', '2026-03-02 12:46:42', '2026-03-03 09:14:28'),
(19, NULL, 'Nahim', 'O+', '01885-671-650', 'Dhaka', '2025-11-26', '2026-03-02 12:47:04', '2026-03-03 09:14:23'),
(20, NULL, 'Shekh R.J Hasan', 'AB+', '01563-350-581', 'Khulna', '2025-11-21', '2026-03-02 12:49:36', '2026-03-03 09:12:41'),
(21, NULL, 'Akash Howlader', 'AB+', '01981-379-113', 'Dhaka', '2025-10-23', '2026-03-02 12:50:00', '2026-03-03 09:12:34'),
(22, NULL, 'Sharif Hossain', 'AB+', '01808-481-391', 'Chattogram', '2025-11-21', '2026-03-02 12:50:21', '2026-03-03 09:12:29'),
(23, NULL, 'Rakib Kumar', 'AB+', '01919-419-691', 'Khulna', '2025-11-28', '2026-03-02 12:50:41', '2026-03-03 09:11:29'),
(24, NULL, 'Alamin Khan', 'AB+', '01880-586-889', 'Khulna', '2025-10-24', '2026-03-02 12:51:07', '2026-03-03 09:11:23'),
(25, NULL, 'Sabir Hosen', 'AB+', '01980-003-848', 'Chattogram', '2025-09-19', '2026-03-02 12:51:26', '2026-03-03 09:11:05'),
(26, NULL, 'Emran', 'AB+', '01511-386-122', 'Chattogram', '2025-11-07', '2026-03-02 12:51:48', '2026-03-03 09:10:58'),
(27, NULL, 'Kamal', 'AB+', '01723-898-551', 'Dhaka', '2025-08-08', '2026-03-02 12:52:16', '2026-03-03 09:10:52'),
(28, NULL, 'Alamin Islam', 'AB+', '01920-691-203', 'Dhaka', '2025-11-14', '2026-03-02 12:52:37', '2026-03-03 09:10:47'),
(29, NULL, 'Sourav Poddar', 'AB+', '01630-565-622', 'Khulna', '2025-09-25', '2026-03-02 12:52:59', '2026-03-03 09:10:41'),
(30, NULL, 'Murad', 'AB+', '01903-819-105', 'Khulna', '2026-02-13', '2026-03-02 12:55:02', '2026-03-03 09:10:34'),
(31, NULL, 'Jaber', 'B+', '01920-789-226', 'Khulna', '2026-01-02', '2026-03-02 12:59:48', '2026-03-03 09:10:27'),
(32, NULL, 'Rajib Saha', 'B+', '01910-689-033', 'Khulna', '2026-01-16', '2026-03-02 13:00:09', '2026-03-03 09:10:22'),
(33, NULL, 'Foysal Sohel', 'B+', '01303-789-492', 'Dhaka', '2025-10-22', '2026-03-02 13:00:31', '2026-03-03 09:10:12'),
(34, NULL, 'Siyam Islam', 'B+', '01619-782-994', 'Khulna', '2025-11-14', '2026-03-02 13:00:50', '2026-03-03 09:09:30'),
(35, NULL, 'Soni Hawlader', 'B+', '01882-824-978', 'Chattogram', '2025-11-21', '2026-03-02 13:01:09', '2026-03-03 09:09:20'),
(36, NULL, 'Sadik Al Hasan Sani', 'B+', '01825-195-908', 'Dhaka', '2025-11-14', '2026-03-02 13:01:34', '2026-03-03 09:09:14'),
(37, NULL, 'Prodipto Paul', 'B+', '01860-903-088', 'Dhaka', '2025-11-21', '2026-03-02 13:02:07', '2026-03-03 09:09:10'),
(38, NULL, 'Titu Ghosh', 'B+', '01779-290-848', 'Chattogram', '2026-01-24', '2026-03-02 13:02:37', '2026-03-03 09:08:57'),
(39, NULL, 'Anas Rahman', 'B+', '01498-036-026', 'Dhaka', '2025-11-21', '2026-03-02 13:02:56', '2026-03-03 09:08:51'),
(40, NULL, 'Riyad Hasan (Shanto)', 'B+', '01874-925-705', 'Dhaka', '2025-12-26', '2026-03-02 13:03:19', '2026-03-03 09:08:45'),
(41, NULL, 'Suhag Alor Tuhin', 'B+', '01948-874-999', 'Khulna', '2025-12-11', '2026-03-02 13:03:44', '2026-03-03 09:08:40'),
(42, NULL, 'Md. Arafat', 'B+', '01301-651-505', 'Khulna', '2025-12-26', '2026-03-02 13:04:14', '2026-03-03 09:08:34'),
(43, NULL, 'Tushar', 'B+', '01967-500-886', 'Khulna', '2025-11-20', '2026-03-02 13:04:33', '2026-03-03 09:08:28'),
(44, NULL, 'Ariful', 'B+', '01901-692-842', 'Dhaka', '2025-12-26', '2026-03-02 13:04:55', '2026-03-03 09:08:22'),
(45, NULL, 'Siam', 'B+', '01923-032-978', 'Chattogram', '2026-03-03', '2026-03-02 13:05:14', '2026-03-03 09:08:17'),
(46, NULL, 'Jisan', 'B+', '01880-712-200', 'Chattogram', '2026-03-02', '2026-03-02 13:05:33', '2026-03-03 09:08:11'),
(47, NULL, 'Zubayer Islam', 'B+', '01503-195-690', 'Dhaka', '2026-01-02', '2026-03-02 13:05:54', '2026-03-03 09:08:02'),
(48, NULL, 'Aluddin Hossain Noyon', 'A+', '01909-822-848', 'Khulna', '2026-01-15', '2026-03-02 13:07:36', '2026-03-03 09:07:58'),
(49, NULL, 'Sagar Sarkar Sumon', 'A+', '01919-031-816', 'Khulna', '2025-11-20', '2026-03-02 13:08:04', '2026-03-03 09:07:52'),
(50, NULL, 'Md. Rakib', 'A+', '01910-084-589', 'Khulna', '2026-01-23', '2026-03-02 13:08:24', '2026-03-03 09:07:46'),
(51, NULL, 'Muhammad Jakir Rahman', 'A+', '01880-444-076', 'Dhaka', '2025-11-14', '2026-03-02 13:08:43', '2026-03-03 09:07:40'),
(52, NULL, 'Sourav Das', 'A+', '01876-630-845', 'Dhaka', '2025-11-14', '2026-03-02 13:09:00', '2026-03-03 09:07:37'),
(53, NULL, 'Ananya Akhi Barsha', 'A+', '01912-259-430', 'Chattogram', '2025-11-28', '2026-03-02 13:09:30', '2026-03-03 09:07:32'),
(54, NULL, 'Debabrata Dutta', 'A+', '01786-626-088', 'Dhaka', '2025-12-19', '2026-03-02 13:09:51', '2026-03-03 09:07:27'),
(55, NULL, 'Imran', 'A+', '01910-612-250', 'Khulna', '2025-10-24', '2026-03-02 13:10:13', '2026-03-03 09:07:23'),
(56, NULL, 'Chonchol', 'A+', '01396-680-107', 'Khulna', '2025-11-06', '2026-03-02 13:10:35', '2026-03-03 09:07:14'),
(57, NULL, 'Naim Hasan', 'A+', '01636-588-848', 'Dhaka', '2026-01-24', '2026-03-02 13:10:55', '2026-03-03 09:01:24'),
(58, 1, 'Joty Biswas', 'B+', '01403107510', 'Khulna', NULL, '2026-03-02 13:26:09', '2026-03-03 09:06:59'),
(59, NULL, 'Kanta Biswas', 'B+', '01803105410', 'Khulna', '2025-04-03', '2026-03-03 09:12:06', '2026-03-03 09:12:06'),
(60, 2, 'Masum', NULL, NULL, 'Dhaka', NULL, '2026-03-03 09:33:07', '2026-03-03 09:33:07'),
(61, 4, 'Sabbir Hossain', NULL, NULL, '', NULL, '2026-03-03 09:57:30', '2026-03-03 09:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0eqzQPvLi6WwcGXleBb5XZPlunc2glVF97n4dzF1', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieHdCem45NVN0UllFWm1GTkh1d3JreVVwdUV1SkRBQ3JNQ1FWcjJxSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3QvZG9ub3JfbGlzdC9CKyI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1772554123);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_admin`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Joty Biswas', 'jotybiswas0199@gmail.com', NULL, 1, '$2y$12$iSpI8/uAw2gGCkw/t9ZFjOM6LjjBjHJRx9GFXshqwm1jbDgU4UNxe', NULL, '2026-03-02 11:06:42', '2026-03-02 11:06:42'),
(2, 'Masum', 'Masum018@gmail.com', NULL, 0, '$2y$12$K3.BY.XhqrO.O3lCmW73eOCOTbCU3wMk1gjk96eq8Dx/PyS8mn116', NULL, '2026-03-02 11:13:27', '2026-03-02 11:13:27'),
(3, 'Rahad Jubayer', 'rjjubayer@gmail.com', NULL, 0, '$2y$12$IF81Z8R8JwNYjUci68hZHuXCD6.UulQ1w6cC3E2bg191HMqsfYhUu', NULL, '2026-03-02 11:35:37', '2026-03-02 11:35:37'),
(4, 'Sabbir Hossain', 'sabbir019@gmail.com', NULL, 0, '$2y$12$heOZN2QW9NlF56xWZHdaUO1lUUpAQfU2AAg6H4tIG3sWwsYZ.XNoa', NULL, '2026-03-03 09:37:22', '2026-03-03 09:37:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
