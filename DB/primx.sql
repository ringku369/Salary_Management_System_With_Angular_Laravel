-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2021 at 06:52 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primx`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Saving','Current') COLLATE utf8mb4_unicode_ci DEFAULT 'Current',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `branch_id`, `name`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Sonali Bank', 'Saving', 1, '2021-06-28 07:35:58', '2021-06-29 09:00:47'),
(3, 2, 'Pubali bank', 'Saving', 1, '2021-06-28 07:35:58', '2021-06-29 09:00:40'),
(7, 1, 'Rupali bank', 'Current', 1, '2021-06-29 08:58:23', '2021-06-29 08:58:23'),
(8, 4, 'Janata bank', 'Current', 1, '2021-07-02 01:26:56', '2021-07-02 01:26:56'),
(9, 2, 'Brac Bank', 'Current', 1, '2021-07-02 01:41:09', '2021-07-02 01:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scode` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `scode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mirpur', 1, 1, '2021-06-28 07:09:50', '2021-06-29 07:34:54'),
(2, 'Banani', 1, 1, '2021-06-29 07:34:39', '2021-06-29 07:34:39'),
(3, 'Gulshan', 1, 1, '2021-06-29 07:34:46', '2021-06-29 07:34:46'),
(4, 'Mogbazer', 1, 1, '2021-07-02 01:26:01', '2021-07-02 01:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'company id',
  `bank_id` int(11) DEFAULT NULL,
  `debit` decimal(10,0) NOT NULL DEFAULT '0',
  `credit` decimal(10,0) NOT NULL DEFAULT '0',
  `balance` decimal(10,0) NOT NULL DEFAULT '0',
  `remarks` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Deposit,2=Fund Transfer',
  `isuser` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `bank_id`, `debit`, `credit`, `balance`, `remarks`, `status`, `isuser`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 7, '0', '10000', '10000', 'Balance Credited', 1, 0, NULL, '2021-07-02 08:29:58', '2021-07-02 08:29:58'),
(2, 3, 7, '0', '50000', '60000', 'Balance Credited', 1, 0, NULL, '2021-07-02 08:30:05', '2021-07-02 08:30:05'),
(3, 3, 7, '0', '30000', '90000', 'Balance Credited', 1, 0, NULL, '2021-07-02 08:30:11', '2021-07-02 08:30:11'),
(4, 3, 7, '0', '50500', '140500', 'Balance Credited', 1, 0, NULL, '2021-07-02 08:30:21', '2021-07-02 08:30:21'),
(5, 3, 7, '0', '23000', '163500', 'Balance Credited', 1, 0, NULL, '2021-07-02 08:30:29', '2021-07-02 08:30:29'),
(6, 3, 7, '63500', '0', '100000', 'Balance Debited', 2, 0, NULL, '2021-07-02 08:31:01', '2021-07-02 08:31:01'),
(7, 3, 7, '50000', '0', '50000', 'Balance Debited', 2, 0, NULL, '2021-07-02 08:31:17', '2021-07-02 08:31:17'),
(8, 3, 7, '40000', '0', '10000', 'Balance Debited', 2, 0, NULL, '2021-07-02 08:31:35', '2021-07-02 08:31:35'),
(15, 3, 7, '1000', '0', '9000', 'Balance Debited', 2, 0, NULL, '2021-07-02 08:31:35', '2021-07-02 08:31:35'),
(16, 7, 1, '100', '0', '8900', 'Balance Debited', 2, 1, NULL, '2021-07-02 08:51:50', '2021-07-02 08:51:50'),
(17, 7, 1, '100', '0', '8800', 'Balance Debited', 2, 1, NULL, '2021-07-02 08:55:02', '2021-07-02 08:55:02'),
(19, 9, 3, '100', '0', '8700', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:03:35', '2021-07-02 09:03:35'),
(20, 9, 3, '200', '0', '8500', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:03:55', '2021-07-02 09:03:55'),
(21, 9, 3, '300', '0', '8200', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:04:00', '2021-07-02 09:04:00'),
(22, 9, 3, '4000', '0', '4200', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:04:04', '2021-07-02 09:04:04'),
(23, 7, 1, '100', '0', '4100', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:04:15', '2021-07-02 09:04:15'),
(24, 7, 1, '200', '0', '3900', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:04:20', '2021-07-02 09:04:20'),
(25, 11, 3, '100', '0', '3800', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:09:46', '2021-07-02 09:09:46'),
(26, 11, 3, '100', '0', '3700', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:09:49', '2021-07-02 09:09:49'),
(27, 11, 3, '100', '0', '3600', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:09:50', '2021-07-02 09:09:50'),
(28, 11, 3, '100', '0', '3500', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:09:52', '2021-07-02 09:09:52'),
(29, 10, 7, '100', '0', '3400', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:27', '2021-07-02 09:10:27'),
(30, 10, 7, '100', '0', '3300', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:28', '2021-07-02 09:10:28'),
(31, 10, 7, '100', '0', '3200', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:29', '2021-07-02 09:10:29'),
(32, 10, 7, '100', '0', '3100', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:30', '2021-07-02 09:10:30'),
(33, 12, 1, '100', '0', '3000', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:42', '2021-07-02 09:10:42'),
(34, 12, 1, '50', '0', '2950', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:49', '2021-07-02 09:10:49'),
(35, 12, 1, '50', '0', '2900', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:50', '2021-07-02 09:10:50'),
(36, 12, 1, '50', '0', '2850', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:51', '2021-07-02 09:10:51'),
(37, 12, 1, '50', '0', '2800', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:52', '2021-07-02 09:10:52'),
(38, 13, 3, '50', '0', '2750', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:10:59', '2021-07-02 09:10:59'),
(39, 13, 3, '50', '0', '2700', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:00', '2021-07-02 09:11:00'),
(40, 13, 3, '50', '0', '2650', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:01', '2021-07-02 09:11:01'),
(41, 13, 3, '50', '0', '2600', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:02', '2021-07-02 09:11:02'),
(42, 13, 3, '50', '0', '2550', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:03', '2021-07-02 09:11:03'),
(43, 14, 1, '50', '0', '2500', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:23', '2021-07-02 09:11:23'),
(44, 14, 1, '50', '0', '2450', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:24', '2021-07-02 09:11:24'),
(45, 14, 1, '50', '0', '2400', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:25', '2021-07-02 09:11:25'),
(46, 14, 1, '50', '0', '2350', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:26', '2021-07-02 09:11:26'),
(47, 14, 1, '50', '0', '2300', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:27', '2021-07-02 09:11:27'),
(48, 15, 1, '50', '0', '2250', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:34', '2021-07-02 09:11:34'),
(49, 15, 1, '50', '0', '2200', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:35', '2021-07-02 09:11:35'),
(50, 15, 1, '50', '0', '2150', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:36', '2021-07-02 09:11:36'),
(51, 15, 1, '50', '0', '2100', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:37', '2021-07-02 09:11:37'),
(52, 16, 3, '50', '0', '2050', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:44', '2021-07-02 09:11:44'),
(53, 16, 3, '50', '0', '2000', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:45', '2021-07-02 09:11:45'),
(54, 16, 3, '50', '0', '1950', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:46', '2021-07-02 09:11:46'),
(55, 17, 1, '50', '0', '1900', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:53', '2021-07-02 09:11:53'),
(56, 17, 1, '50', '0', '1850', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:54', '2021-07-02 09:11:54'),
(57, 17, 1, '50', '0', '1800', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:55', '2021-07-02 09:11:55'),
(58, 17, 1, '50', '0', '1750', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:11:56', '2021-07-02 09:11:56'),
(59, 18, 8, '50', '0', '1700', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:03', '2021-07-02 09:12:03'),
(60, 18, 8, '50', '0', '1650', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:04', '2021-07-02 09:12:04'),
(61, 18, 8, '50', '0', '1600', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:05', '2021-07-02 09:12:05'),
(62, 18, 8, '50', '0', '1550', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:06', '2021-07-02 09:12:06'),
(63, 19, 8, '50', '0', '1500', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:13', '2021-07-02 09:12:13'),
(64, 19, 8, '50', '0', '1450', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:14', '2021-07-02 09:12:14'),
(65, 19, 8, '50', '0', '1400', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:15', '2021-07-02 09:12:15'),
(66, 19, 8, '50', '0', '1350', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:12:17', '2021-07-02 09:12:17'),
(67, 9, 3, '20', '0', '1330', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:16:04', '2021-07-02 09:16:04'),
(68, 11, 3, '20', '0', '1310', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:17:17', '2021-07-02 09:17:17'),
(69, 3, 7, '0', '10000', '11310', 'Balance Credited', 1, 0, NULL, '2021-07-02 09:34:45', '2021-07-02 09:34:45'),
(70, 13, 3, '100', '0', '11210', 'Balance Debited', 2, 1, NULL, '2021-07-02 09:35:39', '2021-07-02 09:35:39');

--
-- Triggers `deposits`
--
DELIMITER $$
CREATE TRIGGER `after_deposits_insert` AFTER INSERT ON `deposits` FOR EACH ROW BEGIN
    DECLARE rowcount INT;
    IF new.isuser > 0 THEN
        INSERT INTO userfunds(user_id,bank_id,debit,credit,balance,remarks,created_at,updated_at)
        VALUES(new.user_id,new.bank_id,new.credit,new.debit,
            ((select (case when sum(t1.credit) is null then 0 else sum(t1.credit) end) as amount from userfunds as t1 where t1.user_id = new.user_id) + new.debit),'Balance Credited',NOW(),NOW());
    END IF; 

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_20_064106_create_categories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `basic` decimal(10,0) NOT NULL DEFAULT '0',
  `hrent` decimal(10,0) NOT NULL DEFAULT '0',
  `medical` decimal(10,0) NOT NULL DEFAULT '0',
  `salary` decimal(10,0) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `level`, `status`, `basic`, `hrent`, `medical`, `salary`, `created_at`, `updated_at`) VALUES
(1, 'Grade-1', 1, 1, '40000', '8000', '6000', '54000', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(2, 'Grade-2', 2, 1, '35000', '7000', '5250', '47250', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(3, 'Grade-3', 3, 1, '30000', '6000', '4500', '40500', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(4, 'Grade-4', 4, 1, '25000', '5000', '3750', '33750', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(5, 'Grade-5', 5, 1, '20000', '4000', '3000', '27000', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(6, 'Grade-6', 6, 1, '15000', '3000', '2250', '20250', '2021-06-28 07:09:50', '2021-07-02 01:25:08'),
(7, 'Admin', 7, 0, '0', '0', '0', '0', '2021-06-28 07:09:50', '2021-06-28 07:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotline` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `semail` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outdhaka` float NOT NULL DEFAULT '200',
  `indhaka` float NOT NULL DEFAULT '50',
  `serviceindhaka` float NOT NULL DEFAULT '0',
  `msindhaka` float NOT NULL DEFAULT '1000',
  `favicon` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting`, `currency`, `code`, `timezone`, `hotline`, `contact`, `vat`, `semail`, `outdhaka`, `indhaka`, `serviceindhaka`, `msindhaka`, `favicon`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Do', 'BDT', '৳', 'Asia/Dhaka', '8801911501888', '8801911501888', 5, 'nanoitworld@gmail.com', 500, 200, 0, 1000, '1532605359101700124.png', '1532605359134687171.png', '2018-05-29 18:00:00', '2018-09-12 16:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `userfunds`
--

CREATE TABLE `userfunds` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'employee id',
  `bank_id` int(11) DEFAULT NULL,
  `debit` decimal(10,0) NOT NULL DEFAULT '0',
  `credit` decimal(10,0) NOT NULL DEFAULT '0',
  `balance` decimal(10,0) NOT NULL DEFAULT '0',
  `remarks` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Deposit,2=Fund Transfer',
  `isuser` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userfunds`
--

INSERT INTO `userfunds` (`id`, `user_id`, `bank_id`, `debit`, `credit`, `balance`, `remarks`, `status`, `isuser`, `name`, `created_at`, `updated_at`) VALUES
(1, 7, 1, '0', '100', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(2, 7, 1, '0', '100', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(3, 9, 3, '0', '100', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(4, 9, 3, '0', '200', '300', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(5, 9, 3, '0', '300', '600', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(6, 9, 3, '0', '4000', '4600', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(7, 7, 1, '0', '100', '300', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(8, 7, 1, '0', '200', '500', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:08:24', '2021-07-02 15:08:24'),
(9, 11, 3, '0', '100', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:09:46', '2021-07-02 15:09:46'),
(10, 11, 3, '0', '100', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:09:49', '2021-07-02 15:09:49'),
(11, 11, 3, '0', '100', '300', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:09:50', '2021-07-02 15:09:50'),
(12, 11, 3, '0', '100', '400', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:09:52', '2021-07-02 15:09:52'),
(13, 10, 7, '0', '100', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:27', '2021-07-02 15:10:27'),
(14, 10, 7, '0', '100', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:28', '2021-07-02 15:10:28'),
(15, 10, 7, '0', '100', '300', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:29', '2021-07-02 15:10:29'),
(16, 10, 7, '0', '100', '400', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:30', '2021-07-02 15:10:30'),
(17, 12, 1, '0', '100', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:42', '2021-07-02 15:10:42'),
(18, 12, 1, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:49', '2021-07-02 15:10:49'),
(19, 12, 1, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:50', '2021-07-02 15:10:50'),
(20, 12, 1, '0', '50', '250', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:51', '2021-07-02 15:10:51'),
(21, 12, 1, '0', '50', '300', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:52', '2021-07-02 15:10:52'),
(22, 13, 3, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:10:59', '2021-07-02 15:10:59'),
(23, 13, 3, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:00', '2021-07-02 15:11:00'),
(24, 13, 3, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:01', '2021-07-02 15:11:01'),
(25, 13, 3, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:02', '2021-07-02 15:11:02'),
(26, 13, 3, '0', '50', '250', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:03', '2021-07-02 15:11:03'),
(27, 14, 1, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:23', '2021-07-02 15:11:23'),
(28, 14, 1, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:24', '2021-07-02 15:11:24'),
(29, 14, 1, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:25', '2021-07-02 15:11:25'),
(30, 14, 1, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:26', '2021-07-02 15:11:26'),
(31, 14, 1, '0', '50', '250', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:27', '2021-07-02 15:11:27'),
(32, 15, 1, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:34', '2021-07-02 15:11:34'),
(33, 15, 1, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:35', '2021-07-02 15:11:35'),
(34, 15, 1, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:36', '2021-07-02 15:11:36'),
(35, 15, 1, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:37', '2021-07-02 15:11:37'),
(36, 16, 3, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:44', '2021-07-02 15:11:44'),
(37, 16, 3, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:45', '2021-07-02 15:11:45'),
(38, 16, 3, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:46', '2021-07-02 15:11:46'),
(39, 17, 1, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:53', '2021-07-02 15:11:53'),
(40, 17, 1, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:54', '2021-07-02 15:11:54'),
(41, 17, 1, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:55', '2021-07-02 15:11:55'),
(42, 17, 1, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:11:56', '2021-07-02 15:11:56'),
(43, 18, 8, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:03', '2021-07-02 15:12:03'),
(44, 18, 8, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:04', '2021-07-02 15:12:04'),
(45, 18, 8, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:05', '2021-07-02 15:12:05'),
(46, 18, 8, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:06', '2021-07-02 15:12:06'),
(47, 19, 8, '0', '50', '50', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:13', '2021-07-02 15:12:13'),
(48, 19, 8, '0', '50', '100', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:14', '2021-07-02 15:12:14'),
(49, 19, 8, '0', '50', '150', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:15', '2021-07-02 15:12:15'),
(50, 19, 8, '0', '50', '200', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:12:17', '2021-07-02 15:12:17'),
(51, 9, 3, '0', '20', '4620', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:16:04', '2021-07-02 15:16:04'),
(52, 11, 3, '0', '20', '420', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:17:17', '2021-07-02 15:17:17'),
(53, 13, 3, '0', '100', '350', 'Balance Credited', 1, 1, NULL, '2021-07-02 15:35:39', '2021-07-02 15:35:39');

--
-- Triggers `userfunds`
--
DELIMITER $$
CREATE TRIGGER `after_userfunds_insert` AFTER INSERT ON `userfunds` FOR EACH ROW BEGIN
    DECLARE rowcount INT;
    update users set balance = new.balance where id = new.user_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2020',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '100' COMMENT '1000=Super Admin, 500=Admin, 100=User',
  `role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User' COMMENT '1000=Super Admin, 500=Admin, 100=User',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `_lft` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `_rgt` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `refer_id` bigint(20) DEFAULT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=Head, 1=Left, 2=Right',
  `isposition` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `ismatch` tinyint(4) NOT NULL DEFAULT '0',
  `gencount` int(11) NOT NULL DEFAULT '0',
  `verifycode` int(11) DEFAULT NULL,
  `district` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bmcount` int(11) NOT NULL DEFAULT '0',
  `rank_id` int(11) NOT NULL DEFAULT '1',
  `bank_id` int(11) NOT NULL DEFAULT '1',
  `acno` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '123123',
  `type` enum('Saving','Current') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Current',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `contact`, `balance`, `email_verified_at`, `password`, `remember_token`, `level`, `role`, `status`, `active`, `_lft`, `_rgt`, `parent_id`, `refer_id`, `position`, `isposition`, `ismatch`, `gencount`, `verifycode`, `district`, `address`, `profession`, `gender`, `bmcount`, `rank_id`, `bank_id`, `acno`, `type`, `created_at`, `updated_at`) VALUES
(1, '10000', 'Vizz BD', 'ringku369@gmail.com', '01712616057', 10007.5, NULL, '$2y$10$wwpIn1INiHqGurESsMMTGOjDjzb4beQKq/tk3COT79NQLMkq80uKC', '$2y$10$RNXT6oJ74YOnD3u47gQ/jOsZHCO7QXuhd969g1AfP.sYHxfx167HW', 1000, 'Superadmin', 1, 1, 1, 196, NULL, NULL, 0, 'N', 1, 0, NULL, NULL, NULL, NULL, 'Male', 1, 7, 1, '10000', 'Current', '2021-02-21 04:26:06', '2021-04-07 05:00:14'),
(2, '15000', 'Vizz BD', 'vizzclub786@gmail.com', '01758406100', 8650, NULL, '$2y$10$wwpIn1INiHqGurESsMMTGOjDjzb4beQKq/tk3COT79NQLMkq80uKC', '$2y$10$gGAWXd7lrJyD13gv/rCTke9Lvt7nY8sPT6SnwEwkYn/JIb/.lUvK6', 500, 'Admin', 1, 1, 136, 153, 1, 1, 1, 'L', 1, 0, NULL, 'CHP', 'World', 'Business', 'Male', 8, 7, 1, '15000', 'Current', '2021-02-21 09:54:34', '2021-07-01 23:54:25'),
(3, '20000', 'Md. Sanaullah', 'linkbrt@gmail.com', '01712616057', 11210, NULL, '$2y$10$IBCE5ftxay498AJnVKA1sOE7DYbSQa1DsallCwBI.J22qkfeKYyIS', '$2y$10$ef3JkGZRlBcdXKk183yzO.JQPgrXdbJfKHJMaqGOVJW2kxK.jo9Jm', 500, 'Admin', 1, 1, 154, 195, 1, 1, 2, 'R', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Software Engineer', 'Male', 0, 7, 7, '20000', 'Current', '2021-02-21 09:54:52', '2021-07-02 09:35:39'),
(7, '20001', 'Employee - 1', 'employee1@gmail.com', '01758406100', 500, NULL, '$2y$10$15A3/KhEiORGH5DuiC5WQeZy.W5d1O5U.HvMb7ic9Z1wJocIwcIFy', '$2y$10$CE7fKvgKTQKffJUgk0Ffd.TvSRuDbNuWDi3AoRcGf95OKEXUprWeG', 100, 'User', 1, 1, 169, 170, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Software Engineer', 'Male', 0, 1, 1, '40002', 'Current', '2021-06-30 00:36:07', '2021-07-02 08:51:50'),
(9, '20002', 'Employee - 2', 'employee2@gmail.com', '01712616057', 4620, NULL, '$2y$10$FlFE0SMvS4b6ofIn39YCrObhIxFu9hy7nY0OlzxlKSmN/DUgLuylC', '$2y$10$Tr3pl1iln9Ulzlc0UMjD7ue9qUg8CV0.UcljKW3xoMBkRco9NZyoK', 100, 'User', 1, 1, 173, 174, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Business', 'Male', 0, 2, 3, '40004', 'Current', '2021-06-30 00:45:47', '2021-07-02 02:48:34'),
(10, '20003', 'Employee - 3', 'employee3@gmail.com', '01712616057', 400, NULL, '$2y$10$q2x9aevRow7he21R0V0S9.nnT75z9a6XnPLyIFXr3sLeHkkyfc9Dq', '$2y$10$AZoz.ss99WrvycvN60tCceigr1lRkVCiCpBafxdBsZobtsCFXo0SO', 100, 'User', 1, 1, 175, 176, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Business', 'Male', 0, 3, 7, '40006', 'Current', '2021-06-30 00:48:28', '2021-07-02 02:51:07'),
(11, '20004', 'Employee - 4', 'employee4@gmail.com', '01712616057', 420, NULL, '$2y$10$EXLuG8aRzumFMHgFHrMQ3eSgCQPpeeoo69djuPIwTGjtf.mZtaK1S', '$2y$10$fusHqWVpGtKZiwov2nApGemfCBJI.2QzBPSB77OjpRjRK2xtOWuwG', 100, 'User', 1, 1, 177, 178, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Software Engineer', 'Male', 0, 3, 3, '40008', 'Current', '2021-06-30 00:49:27', '2021-06-30 00:49:27'),
(12, '20005', 'Employee - 5', 'employee5@gmail.com', '01712616057', 300, NULL, '$2y$10$MW8Dd8NqZ72BlT5QqEtNaOYeSsyP2lpbItVekrEWfnEIzHMrUPdqW', '$2y$10$9n6EfE4uk1POiKuK6JRdIeVRk/7h7TXGkWNtaSd.vlijrFACg839.', 100, 'User', 1, 1, 179, 180, 3, NULL, 1, 'L', 0, 0, NULL, 'Chapai', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 4, 1, '40010', 'Current', '2021-06-30 00:51:23', '2021-07-02 02:51:46'),
(13, '20006', 'Employee - 6', 'employee6@gmail.com', '01712616057', 350, NULL, '$2y$10$aXlXAoXiymywNIKOUjtgf.AqQ0kJ16QMQtUGVbtacUtp1FajXWVse', '$2y$10$yZ18c86uvcD/282R9TmE9eX7YxILQCMAeCLInHFZuqgOEQAcHWquO', 100, 'User', 1, 1, 181, 182, 3, NULL, 1, 'L', 0, 0, NULL, 'Chapai', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 4, 3, '40012', 'Current', '2021-06-30 00:52:15', '2021-07-02 02:52:45'),
(14, '20007', 'Employee - 7', 'employee7@gmail.com', '01712616057', 250, NULL, '$2y$10$io0y/YVgIZywm2VthhwGw.RdEpM1abLCAe2HWdLbKIWkEjtjv2DKy', '$2y$10$/vefBjMTc71zxbj8BoRypOrzgp7dfPSyRBSwtO1pLBLxAl9n.OR2W', 100, 'User', 1, 1, 183, 184, 3, NULL, 1, 'L', 0, 0, NULL, 'Chapai', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 5, 1, '40014', 'Current', '2021-06-30 00:53:06', '2021-06-30 00:53:06'),
(15, '20008', 'Employee - 8', 'employee8@gmail.com', '01712616057', 200, NULL, '$2y$10$3gutOreAGc56QscYJXo0ceHwtwURkO6flbIebVilhwOQa0UtAi4.C', '$2y$10$xxgglBxTz.USJuiJqpuJn.WMR4VUgZLoG9wK4qxsJJeRsFaRHZqIW', 100, 'User', 1, 1, 185, 186, 3, NULL, 1, 'L', 0, 0, NULL, 'Chapai', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 5, 1, '40016', 'Current', '2021-06-30 00:54:01', '2021-07-02 02:53:21'),
(16, '20009', 'Employee - 9', 'employee9@gmail.com', '01712616057', 150, NULL, '$2y$10$RsYqXYKjFepu50PHPI87zOgZYzCPjJZrwzKg.u6kHZgT/Pa9zr5f6', '$2y$10$bBRSW5WyRr.JWV.53TSiIe0YuiPlcIcx/BR9Fb4wwZi9hmA4mz/j6', 100, 'User', 1, 1, 187, 188, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 6, 3, '40018', 'Current', '2021-06-30 00:56:35', '2021-07-02 02:53:52'),
(17, '20010', 'Employee - 10', 'employee10@gmail.com', '01712616057', 200, NULL, '$2y$10$MbrT81ySlDvuGvOUEjFO8.FEeROuHV/3FeRE9TrywEvGRLsWazB/m', '$2y$10$7iVxkmFU.2udZqC.5oOpXujQH77dyh6z6kqyi6VoLr8z1mdVu5wey', 100, 'User', 1, 1, 189, 190, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Software Engineer', 'Male', 0, 6, 1, '40020', 'Saving', '2021-06-30 00:58:43', '2021-07-02 01:39:05'),
(18, '20011', 'Employee - 11', 'employee11@gmail.com', '01712616057', 200, NULL, '$2y$10$KiDCZOcSuDOaxlC6L44Abeb.cJii5XbNzR8i7F4rs5HTQJHID3ST.', '$2y$10$s0zV1fWgjH0QAx/LtCsS1.GG8o46Jk9xFGvmvCp0DQ0kcGa./vNY2', 100, 'User', 1, 1, 191, 192, 3, NULL, 1, 'L', 0, 0, NULL, 'Chapai', 'Gulbaj, Chapainawabgonj', 'Software Engineer', 'Male', 0, 1, 8, '40022', 'Saving', '2021-07-02 01:40:10', '2021-07-02 02:54:21'),
(19, '20012', 'Employee - 12', 'employee12@gmail.com', '01712616057', 200, NULL, '$2y$10$GNuR6w0pNMQ8gpjpJrHSrOkledXfJpmbHsbIZaAjDrDZ5C08l1WTO', '$2y$10$MwY94AL9xa9STE7USqsQ7eOlh43UDnT9n5JqIjmiGQ9o4l7WWsiKK', 100, 'User', 1, 1, 193, 194, 3, NULL, 1, 'L', 0, 0, NULL, 'Rajshahi', 'Vhatapara, Rajshahi', 'Software Engineer', 'Male', 0, 4, 8, '40024', 'Saving', '2021-07-02 08:02:29', '2021-07-02 08:09:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userfunds`
--
ALTER TABLE `userfunds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userfunds`
--
ALTER TABLE `userfunds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
