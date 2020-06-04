-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 04. Jun 2020 um 17:25
-- Server-Version: 10.1.21-MariaDB-1~jessie
-- PHP-Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `mvc`
--
CREATE DATABASE IF NOT EXISTS `mvc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mvc`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `user_id` int(11) NOT NULL,
                                           `address` text COLLATE utf8_unicode_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address`) VALUES
                                                     (1, 1, 'Hohenstaufengasse 6\r\n1010 Wien\r\nÖsterreich'),
                                                     (2, 2, 'Hohenstaufengasse 8\r\n1010 Wien\r\nÖsterreich'),
                                                     (3, 2, 'Hohenstaufengasse 10\r\n1010 Wien\r\nÖsterreich'),
                                                     (4, 1, 'Musterstraße 42,\r\n1234 Wien');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
                                        `id` int(11) NOT NULL AUTO_INCREMENT,
                                        `crdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'creation date',
                                        `user_id` int(11) NOT NULL,
                                        `products` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Serialization or ordered products',
                                        `delivery_address_id` int(11) NOT NULL,
                                        `invoice_address_id` int(11) NOT NULL,
                                        `payment_id` int(11) NOT NULL,
                                        `status` enum('open','in progress','in delivery','storno','delivered') COLLATE utf8_unicode_ci NOT NULL,
                                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `crdate`, `user_id`, `products`, `delivery_address_id`, `invoice_address_id`, `payment_id`, `status`) VALUES
                                                                                                                                  (1, '2020-05-12 17:20:32', 2, '[\r\n  {\r\n    \"id\": 1,\r\n    \"name\": \"Produkt 1\",\r\n    \"price\": 9.99,\r\n    \"quantity\": 1\r\n  },\r\n  {\r\n    \"id\": 2,\r\n    \"name\": \"Produkt 2\",\r\n    \"price\": 42.00,\r\n    \"quantity\": 2\r\n  },\r\n  {\r\n    \"id\": 3,\r\n    \"name\": \"Produkt 3\",\r\n    \"price\": 10,\r\n    \"quantity\": 3\r\n  }\r\n]', 3, 1, 1, 'in progress'),
                                                                                                                                  (2, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'in progress'),
                                                                                                                                  (3, '2020-05-12 17:20:32', 2, '[]', 1, 1, 1, 'storno'),
                                                                                                                                  (4, '2020-06-02 17:05:54', 1, '[{\"id\":3,\"name\":\"Product #3\",\"description\":\"Product #3 Desc\",\"price\":42,\"stock\":9,\"images\":[\"uploads\\/1589995090_37844315_454803461597516_8815318794768482304_n (1).jpg\",\"uploads\\/1589995431_pimp-rollator.jpg\"],\"quantity\":1},{\"id\":4,\"name\":\"Product #4\",\"description\":\"Product #4 Desc\",\"price\":12.99,\"stock\":10,\"images\":[\"uploads\\/1589996660_pimp-rollator.jpg\"],\"quantity\":1}]', 4, 4, 3, 'open'),
                                                                                                                                  (5, '2020-06-02 17:37:56', 1, '[{\"id\":3,\"name\":\"Product #3\",\"description\":\"Product #3 Desc\",\"price\":42,\"stock\":9,\"images\":[\"uploads\\/1589995090_37844315_454803461597516_8815318794768482304_n (1).jpg\",\"uploads\\/1589995431_pimp-rollator.jpg\"],\"quantity\":2}]', 4, 4, 3, 'open');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                          `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                          `expires` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                          `ccv` int(11) NOT NULL,
                                          `user_id` int(11) NOT NULL,
                                          PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='keine realistische Payments Tabelle!!';

--
-- Daten für Tabelle `payments`
--

INSERT INTO `payments` (`id`, `name`, `number`, `expires`, `ccv`, `user_id`) VALUES
                                                                             (1, 'Mag. Max Mustermann', '123456789', '12-2020', 913, 2),
                                                                             (2, 'Arthur Dent', '41434542', '12-2022', 309, 1),
                                                                             (3, 'Hitchhikers HQ Visa', '76239651042', '12-2022', 309, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
                                          `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                          `description` text COLLATE utf8_unicode_ci,
                                          `price` float NOT NULL,
                                          `stock` int(11) NOT NULL,
                                          `images` text COLLATE utf8_unicode_ci,
                                          PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `images`) VALUES
                                                                                 (3, 'Product #3', 'Product #3 Desc', 42, 9, 'uploads/1589995090_37844315_454803461597516_8815318794768482304_n (1).jpg;uploads/1589995431_pimp-rollator.jpg'),
                                                                                 (4, 'Product #4', 'Product #4 Desc', 12.99, 10, 'uploads/1589996660_pimp-rollator.jpg'),
                                                                                 (5, 'Product #5', 'Product #5 Desc', 10, 5, 'uploads/1590687389_37844315_454803461597516_8815318794768482304_n (1).jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
                                       `id` int(11) NOT NULL AUTO_INCREMENT,
                                       `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                       `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                       `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '= username',
                                       `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Password Hash',
                                       `is_admin` tinyint(1) NOT NULL,
                                       `is_deleted` tinyint(1) DEFAULT NULL,
                                       PRIMARY KEY (`id`),
                                       UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `is_admin`, `is_deleted`) VALUES
                                                                                                   (1, 'Arthur', 'Dent', 'arthur.dent@galaxy.com', '$2y$10$ARj58lJiW3C93Vbfeq7qs.X/UXGIL3w6MCCeCKI0KIXqLjTryGQee', 1, NULL),
                                                                                                   (2, 'Max', 'Mustermann', 'max.mustermann@email.com', '$2y$12$X5x2waADn8m/7y30qj8CrOihPScwmwPo5Fj8VFgaaA9U1iyom5a22', 0, NULL),
                                                                                                   (5, 'Alexander', 'Hofbauer', 'something@email.com', '$2y$10$SyL6F3XDe7KRJq2Nuq0GteXc6gOOlvFlyi9x3yEHM5pMvBGgCSL6K', 0, NULL);
COMMIT;
