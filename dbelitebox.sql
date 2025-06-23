-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 04:41 PM
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
-- Database: `dbelitebox`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `is_active`, `created_at`) VALUES
(1, 1, 0, '2025-06-15 04:12:50'),
(2, 1, 0, '2025-06-16 01:26:28'),
(3, 1, 0, '2025-06-16 01:43:33'),
(4, 1, 0, '2025-06-16 02:09:48'),
(5, 1, 0, '2025-06-16 09:16:16'),
(6, 1, 0, '2025-06-16 10:16:51'),
(7, 1, 0, '2025-06-16 10:17:52'),
(8, 1, 1, '2025-06-16 10:47:17'),
(9, 9, 0, '2025-06-16 12:56:09'),
(10, 9, 0, '2025-06-16 13:07:46'),
(11, 9, 0, '2025-06-17 14:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 100),
(3, 3, 1, 100),
(5, 5, 1, 200),
(6, 5, 2, 100),
(7, 6, 1, 200),
(8, 7, 3, 100),
(10, 9, 1, 200),
(11, 10, 3, 200),
(12, 11, 6, 300);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `status` enum('pending','diproses','dikirim','selesai','dibatalkan') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating_penjualan` int(1) DEFAULT NULL,
  `rating_pengiriman` int(1) DEFAULT NULL,
  `komentar_rating` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `status`, `created_at`, `rating_penjualan`, `rating_pengiriman`, `komentar_rating`) VALUES
(1, 1, 1, 'diproses', '2025-06-15 04:35:36', NULL, NULL, NULL),
(2, 1, 2, 'diproses', '2025-06-16 01:36:27', NULL, NULL, NULL),
(3, 1, 3, 'diproses', '2025-06-16 01:43:46', NULL, NULL, NULL),
(4, 1, 4, 'diproses', '2025-06-16 02:11:10', NULL, NULL, NULL),
(5, 1, 5, 'dikirim', '2025-06-16 10:10:30', NULL, NULL, NULL),
(6, 1, 6, 'dikirim', '2025-06-16 10:17:03', NULL, NULL, NULL),
(7, 1, 7, 'dikirim', '2025-06-16 10:17:57', NULL, NULL, NULL),
(8, 9, 9, 'selesai', '2025-06-16 12:56:20', 5, 5, 'keren banget'),
(9, 9, 10, 'selesai', '2025-06-16 13:07:51', 5, 5, 'keren'),
(10, 9, 11, 'selesai', '2025-06-17 14:18:31', 5, 5, 'Produk sesuai ekspetasi, bahannya kuat dan tahan hantaman meteor');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 100, 999.00),
(2, 3, 1, 100, 500.00),
(3, 5, 1, 200, 500.00),
(4, 5, 2, 100, 1000.00),
(5, 6, 1, 200, 500.00),
(6, 7, 3, 100, 2000.00),
(7, 8, 1, 200, 500.00),
(8, 9, 3, 200, 2000.00),
(9, 10, 6, 300, 2000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `width_mm` int(11) DEFAULT NULL,
  `height_mm` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `width_mm`, `height_mm`, `price`, `type_id`, `image_url`) VALUES
(1, 'Sachet/3 Side Seal – Metallized MET 100 – 60 x 90 mm', 60, 90, 500.00, 1, 'produk1.png'),
(2, 'Sachet/3 Side Seal – Metallized MET 100 – 80 x 120 mm', 80, 120, 1000.00, 1, 'produk1.png'),
(3, 'Sachet/3 Side Seal – Metallized MET 100 – 100 x 120 mm', 100, 120, 2000.00, 1, 'produk1.png'),
(4, 'Sachet/3 Side Seal – Frozen/Vacuum Pack Nylon 100 – 150 x 250 mm\r\n', 150, 250, 4000.00, 2, 'produk2.png'),
(5, 'Sachet/3 Side Seal – Frozen/Vacuum Pack Nylon 100 – 200 x 300 mm', 200, 300, 5000.00, 2, 'produk2.png'),
(6, 'Sachet/3 Side Seal – Super Aluminium 100 – 80 x 120 mm', 80, 120, 2000.00, 3, 'produk3.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`) VALUES
(1, 's3 Metalized'),
(2, 's3 Nylon'),
(3, 's3 Alumunium');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, 'user@example.com', '6ad14ba9986e3615423dfca256d04e3f', 'user'),
(4, 'rizalibrah2019@gmail.com', '9b3205ddd8a4e0b879d15b6f1ac36c2b', 'user'),
(5, 'rizalibrah2018@gmail.com', '1ba380abcf4cab6a8e599dbd31dec457', 'user'),
(8, 'sayaadmin@srius.com', '1ba380abcf4cab6a8e599dbd31dec457', 'admin'),
(9, 'rizalibrah123@gmail.com', '$2y$10$zqD4aXEcHNPlyB5f6seeTOKrdC/AJjD8SZtfITPLdjuvxOWO6w49m', 'user'),
(10, 'akuadmin@srius2.com', '$2y$10$Qpc3wwuHCJPC2fk.CBvgLeRZRKchtfMkCSCDGaUBBKggXiy9ngNf2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `product_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
