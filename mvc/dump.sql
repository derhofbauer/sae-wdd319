-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 18, 2020 at 06:53 PM
-- Server version: 10.4.12-MariaDB-1:10.4.12+maria~bionic
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address`) VALUES
(1, 2, 'Hohenstaufengasse 6\r\n1010 Wien\r\nÖsterreich'),
(2, 2, 'Hohenstaufengasse 8\r\n1010 Wien\r\nÖsterreich'),
(3, 2, 'Hohenstaufengasse 10\r\n1010 Wien\r\nÖsterreich');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'creation date',
  `user_id` int(11) NOT NULL,
  `products` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Serialization or ordered products',
  `delivery_address_id` int(11) NOT NULL,
  `invoice_address_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` enum('open','in progress','in delivery','storno','delivered') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `crdate`, `user_id`, `products`, `delivery_address_id`, `invoice_address_id`, `payment_id`, `status`) VALUES
(1, '2020-05-12 17:20:32', 2, '[\r\n  {\r\n    \"id\": 1,\r\n    \"name\": \"Produkt 1\",\r\n    \"price\": 9.99,\r\n    \"quantity\": 1\r\n  },\r\n  {\r\n    \"id\": 2,\r\n    \"name\": \"Produkt 2\",\r\n    \"price\": 42.00,\r\n    \"quantity\": 2\r\n  },\r\n  {\r\n    \"id\": 3,\r\n    \"name\": \"Produkt 3\",\r\n    \"price\": 10,\r\n    \"quantity\": 3\r\n  }\r\n]', 3, 1, 1, 'in progress'),
(2, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'in progress'),
(3, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'storno');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  `expires` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ccv` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='keine realistische Payments Tabelle!!';

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `number`, `expires`, `ccv`, `user_id`) VALUES
(1, 'Mag. Max Mustermann', 123456789, '12-2020', 913, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `images` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `images`) VALUES
(3, 'Product 1', 'Product 1 Desc', 42, 10, NULL),
(4, 'Product 2', 'Product 2 Desc', 9.99, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '= username',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Password Hash',
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `is_admin`) VALUES
(1, 'Arthur', 'Dent', 'arthur.dent@galaxy.com', '$2y$12$OGHFyvBCtXl5fK6mnbo9Z.GHDSSnrSVcdfsnuSRdqOy5AE0TLRggK', 1),
(2, 'Max', 'Mustermann', 'max.mustermann@email.com', '$2y$12$X5x2waADn8m/7y30qj8CrOihPScwmwPo5Fj8VFgaaA9U1iyom5a22', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
