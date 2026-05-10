-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2026 at 09:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rora_luxe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'SuperAdmin', 'admin@roraluxe.com', '$2y$10$QO0R1D.eC/.1Y2sY1K/E.OU/t4gqG5n9pP9Z2qW9lB.J9O8V.1kHq', '2026-05-08 18:58:48'),
(2, 'SuperAdmin', '2022-1-60-038@std.ewubd.edu', '$2b$10$RsJMj0YaE7.ldi.byBxKQOoqvAdNCYSTWivVLK4BNMNDdNW/NfCAy', '2026-05-08 19:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Bags', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `category_id`, `subcategory_id`, `image`, `created_at`) VALUES
(1, 'Ladies Bag', 'এক্সক্লুসিভ লেডিস ব্যাগ – সেল পোস্ট RORA Luxe-এর সঙ্গে স্টাইলের নতুন অভিজ্ঞতা ✨ আপনার স্টাইলকে আরও প্রিমিয়াম করার জন্য আমাদের এক্সক্লুসিভ লেডিস হ্যান্ডব্যাগ – যেটা শুধু ফ্যাশন নয়, গুণগত মান ও প্র্যাকটিক্যালিটি নিয়েও তৈরি। 💎 বৈশিষ্ট্য: অরিজিনাল প্রিমিয়াম লেদার – নরম, টেকসই, এবং লাক্সারি ফিল প্রিমিয়াম এক্সেসরিজ – জিপার, চেইন, হার্ডওয়্যার সর্বোচ্চ মানের ব্যাক জিপার পকেট & কয়েন পকেট – দৈনন্দিন ব্যবহারের জন্য সুবিধাজনক ২ বছরের ওয়ারেন্টি – রঙ ও এক্সেসরিজে, মানের নিশ্চয়তা ফ্রন্ট ও সাইড ডিটেইল স্টিচিং – প্রতিটি সেলাইতে এলিগেন্স ৪টি স্টানিং কালার – Black, Brown, Cream, Pink 🚚 ফ্রি ডেলিভারি – সারাদেশে       🅻🅸🅼🅸🆃🅴🅳 🅴🅳🅸🆃🅸🅾🅽 💃 কেন এই ব্যাগ আপনার জন্য: অফিস, আউটিং বা লাক্সারি ocasiion-এ পারফেক্ট স্টাইলের সঙ্গে স্বাচ্ছন্দ্য ও আত্মবিশ্বাস বহন লিমিটেড এডিশন – আলাদা হোন, ভিড়ের পেছনে চলবেন না 📩 অর্ডার করতে ইনবক্স করুন – RORA Luxe এ ফাস্ট ডেলিভারির জন্য!', 0.00, 1, NULL, '1778267314_69fe34b2d4fb2.jpg', '2026-05-08 19:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'Iqbal Hossain Safy', '2022-1-60-038@std.ewubd.edu', '$2y$10$T6vDZHkXYfD7DPTjAAkWPuw/F8Q5UgNp9o/njZ4bv60.v4K4qZa5a', '2026-05-08 19:01:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
