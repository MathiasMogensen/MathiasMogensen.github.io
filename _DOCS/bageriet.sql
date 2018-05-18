-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 15. 05 2018 kl. 21:01:29
-- Serverversion: 10.1.31-MariaDB
-- PHP-version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bageriet`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `category`
--

INSERT INTO `category` (`id`, `name`, `deleted`) VALUES
(1, 'håndværker', 0),
(2, 'franskbrød', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`) VALUES
(1, 'salt'),
(2, 'mel');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `ingr_prod`
--

CREATE TABLE `ingr_prod` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `measure_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `ingr_prod`
--

INSERT INTO `ingr_prod` (`id`, `product_id`, `ingredient_id`, `measure_id`, `amount`) VALUES
(2, 1, 1, 2, 2),
(5, 6, 1, 1, 13),
(6, 6, 1, 1, 37),
(8, 3, 1, 2, 14);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `measure`
--

CREATE TABLE `measure` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `measure`
--

INSERT INTO `measure` (`id`, `name`) VALUES
(1, 'cl'),
(2, 'tsk'),
(3, 'ml');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `description` text,
  `image` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `description`, `image`, `created_at`, `deleted`) VALUES
(1, 'Test Product 1', 1, 'kdjlaskjdlaskdjlaskjdalskdj', NULL, '2018-05-15 06:44:05', 1),
(2, 'Test Product 2', 1, 'sadasldkjasdjnksajdhaksj', NULL, '2018-05-15 06:44:05', 1),
(3, 'hello', 1, 'you lell', '5afac6b8561571.13727274.jpg', '2018-05-15 11:32:34', 1),
(4, 'lskdj', 1, 'lsakjdlsa', '5afac5d2330b97.97195359.jpg', '2018-05-15 11:34:42', 1),
(5, 'dlkasdlaskdj', 1, 'ldkjasldkj', '5afac6db3b4b56.63185109.jpg', '2018-05-15 11:39:07', 1),
(6, 'adasdlkj', 1, 'ldsajldkj', '5afacbf8b752f7.51420696.jpg', '2018-05-15 11:45:40', 1),
(7, 'lkjdaslkd', 1, 'lkdsaldkj', NULL, '2018-05-15 12:44:30', 1),
(8, 'Noget Brød', 1, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum, voluptates.', '5afb0cbf485287.18407821.png', '2018-05-15 16:37:19', 0),
(9, 'sadasd', 1, 'asdsadas', '5afb1926395310.90948435.png', '2018-05-15 17:30:14', 0),
(10, 'some brød', 2, 'very gud brød yes yes', '5afb1a86563d65.64428118.png', '2018-05-15 17:36:06', 0),
(11, 'lel', 1, 'sadasldkjasdjnksajdhaksj', '5afb1e88208404.23440243.png', '2018-05-15 17:46:38', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(2, 'admin'),
(1, 'user');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `supsended` tinyint(1) NOT NULL DEFAULT '0',
  `salt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `firstname`, `lastname`, `avatar`, `role_id`, `supsended`, `salt`) VALUES
(1, 'admin@admin.dk', '$2y$10$0ee5M0LFrNPaCk30r2WVee28Wka0m/BgZwZEaTDdomPRpl25ZDw.u', 'mathias', 'admin', NULL, 2, 0, '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_session`
--

CREATE TABLE `user_session` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logged_in` tinyint(1) NOT NULL,
  `last_action` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_session`
--

INSERT INTO `user_session` (`session_id`, `user_id`, `logged_in`, `last_action`) VALUES
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(7, 1, 0, 1526373719),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(92, 1, 0, 1526394242),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(0, 1, 0, 1526410759),
(2823342, 1, 0, 1526403482),
(0, 1, 1, 1526410759);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks for tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `ingr_prod`
--
ALTER TABLE `ingr_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `measure_id` (`measure_id`);

--
-- Indeks for tabel `measure`
--
ALTER TABLE `measure`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks for tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks for tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indeks for tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `ingr_prod`
--
ALTER TABLE `ingr_prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tilføj AUTO_INCREMENT i tabel `measure`
--
ALTER TABLE `measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tilføj AUTO_INCREMENT i tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Begrænsninger for tabel `ingr_prod`
--
ALTER TABLE `ingr_prod`
  ADD CONSTRAINT `ingr_prod_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`),
  ADD CONSTRAINT `ingr_prod_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `ingr_prod_ibfk_3` FOREIGN KEY (`measure_id`) REFERENCES `measure` (`id`);

--
-- Begrænsninger for tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Begrænsninger for tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
