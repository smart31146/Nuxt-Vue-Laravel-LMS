-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2023 年 11 月 07 日 16:07
-- サーバのバージョン： 10.5.17-MariaDB-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xs963349_lms`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(6) unsigned NOT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_type` int(1) unsigned NOT NULL DEFAULT 1,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'A',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(6) unsigned NOT NULL,
  `category_slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_level` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(6) unsigned DEFAULT NULL,
  `category_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'A',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `certificate_id` int(8) unsigned NOT NULL,
  `user_id` int(6) unsigned NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `certified_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `curriculums`
--

DROP TABLE IF EXISTS `curriculums`;
CREATE TABLE IF NOT EXISTS `curriculums` (
  `curriculum_id` int(6) unsigned NOT NULL,
  `curriculum_slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curriculum_name_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curriculum_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curriculum_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(6) unsigned NOT NULL,
  `curriculum_type` int(1) unsigned NOT NULL,
  `authority_ranks` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curriculum_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movie_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` int(1) NOT NULL,
  `release_type` int(1) unsigned NOT NULL,
  `released_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `released_date_count` int(3) unsigned DEFAULT 0,
  `released_time` time DEFAULT NULL,
  `closed_date_count` int(3) unsigned DEFAULT 0,
  `closed_time` time DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'A',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `ID` bigint(16) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `tokenable_id` int(8) unsigned NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `taking_curriculums`
--

DROP TABLE IF EXISTS `taking_curriculums`;
CREATE TABLE IF NOT EXISTS `taking_curriculums` (
  `taking_curriculum_id` int(8) unsigned NOT NULL,
  `user_id` int(6) unsigned NOT NULL,
  `curriculum_slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taking_curriculum_second` int(8) unsigned NOT NULL,
  `total_curriculum_second` int(8) unsigned NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(6) unsigned NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sei` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mei` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sei_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mei_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefecture` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_01` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_02` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_rank` int(2) unsigned NOT NULL DEFAULT 1,
  `user_type` int(1) unsigned NOT NULL DEFAULT 2,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'A',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email_status` (`admin_email`,`status`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_slug` (`category_slug`,`status`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `category_level` (`category_level`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `curriculums`
--
ALTER TABLE `curriculums`
  ADD PRIMARY KEY (`curriculum_id`),
  ADD UNIQUE KEY `curriculum_slug` (`curriculum_slug`,`status`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `curriculum_type` (`curriculum_type`),
  ADD KEY `release_type` (`release_type`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `tokenable_id` (`tokenable_id`);

--
-- Indexes for table `taking_curriculums`
--
ALTER TABLE `taking_curriculums`
  ADD PRIMARY KEY (`taking_curriculum_id`),
  ADD UNIQUE KEY `curriculum_slug` (`user_id`,`curriculum_slug`,`content_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email_status` (`user_email`,`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_id` int(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculums`
--
ALTER TABLE `curriculums`
  MODIFY `curriculum_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `ID` bigint(16) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `taking_curriculums`
--
ALTER TABLE `taking_curriculums`
  MODIFY `taking_curriculum_id` int(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(6) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
