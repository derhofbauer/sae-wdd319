-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 20. Mai 2020 um 17:24
-- Server-Version: 10.4.12-MariaDB-1:10.4.12+maria~bionic
-- PHP-Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mvc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address`) VALUES
(1, 2, 'Hohenstaufengasse 6\r\n1010 Wien\r\nÖsterreich'),
(2, 2, 'Hohenstaufengasse 8\r\n1010 Wien\r\nÖsterreich'),
(3, 2, 'Hohenstaufengasse 10\r\n1010 Wien\r\nÖsterreich');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
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
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `crdate`, `user_id`, `products`, `delivery_address_id`, `invoice_address_id`, `payment_id`, `status`) VALUES
(1, '2020-05-12 17:20:32', 2, '[\r\n  {\r\n    \"id\": 1,\r\n    \"name\": \"Produkt 1\",\r\n    \"price\": 9.99,\r\n    \"quantity\": 1\r\n  },\r\n  {\r\n    \"id\": 2,\r\n    \"name\": \"Produkt 2\",\r\n    \"price\": 42.00,\r\n    \"quantity\": 2\r\n  },\r\n  {\r\n    \"id\": 3,\r\n    \"name\": \"Produkt 3\",\r\n    \"price\": 10,\r\n    \"quantity\": 3\r\n  }\r\n]', 3, 1, 1, 'in progress'),
(2, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'in progress'),
(3, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'storno');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payments`
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
-- Daten für Tabelle `payments`
--

INSERT INTO `payments` (`id`, `name`, `number`, `expires`, `ccv`, `user_id`) VALUES
(1, 'Mag. Max Mustermann', 123456789, '12-2020', 913, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `images` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `images`) VALUES
(3, 'Product #3', 'Product #3 Desc', 42, 10, 'uploads/1589995090_37844315_454803461597516_8815318794768482304_n (1).jpg;uploads/1589995431_pimp-rollator.jpg'),
(4, 'Product  #4', 'Product #4 Desc', 12.99, 10, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
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
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `is_admin`) VALUES
(1, 'Arthur', 'Dent', 'arthur.dent@galaxy.com', '$2y$12$OGHFyvBCtXl5fK6mnbo9Z.GHDSSnrSVcdfsnuSRdqOy5AE0TLRggK', 1),
(2, 'Max', 'Mustermann', 'max.mustermann@email.com', '$2y$12$X5x2waADn8m/7y30qj8CrOihPScwmwPo5Fj8VFgaaA9U1iyom5a22', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
