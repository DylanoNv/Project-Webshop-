-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 09 apr 2026 om 14:22
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age_rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `age_rating`) VALUES
(1, 'actie', 1),
(2, 'shooters', 16),
(3, 'avontuur', 7),
(4, 'rpg', 12),
(5, 'Horror', 18);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `consoles`
--

CREATE TABLE `consoles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `consoles`
--

INSERT INTO `consoles` (`id`, `name`) VALUES
(1, 'Playstation'),
(2, 'PC'),
(3, 'Xbox'),
(4, 'Nintendo');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `console_id` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `aanbevolen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `console_id`, `foto`, `categorie_id`, `stock`, `aanbevolen`) VALUES
(2, 'Call of Duty: Black Ops 6', 80.00, 3, 'call_of_duty_bo6.jpg', 1, 10, 0),
(4, 'Call of Duty: Warzone', 20.00, 3, 'call_of_duty_warzone.jpg', 1, 10, 0),
(5, 'Farcry', 50.00, 2, 'Farcry.jpg', 1, 10, 1),
(6, 'R.E.P.O', 19.00, 2, 'repo.jpg', 5, 10, 0),
(7, 'Peak', 19.00, 2, 'peak.jpg', 3, 10, 0),
(8, 'Project Zomboid', 30.00, 2, 'project_zomboid.jpg', 5, 10, 0),
(9, 'MarioKartWorld', 60.00, 4, 'MarioKartWorldjpg.jpg', 3, 10, 0),
(10, 'mario_odyssey', 60.00, 4, 'mario_odysseyjpg.jpg', 3, 10, 0),
(12, 'god of war ragnerok', 60.00, 1, 'god-of-war-ragnarok-2.webp', 3, 10, 0),
(13, 'astrobots', 60.00, 1, 'astrobots.jpg', 3, 10, 0),
(14, 'Avatar Frontiers of Pandora', 60.00, 1, 'Avatar-Frontiers-of-Pandora.webp', 3, 10, 0),
(15, 'Luigi\'s Mansion 3', 49.00, 4, 'LuigisMansion3.jpg', 1, 10, 0),
(16, 'Legend of Zelda: Tears of the Kingdom', 59.99, 4, 'zeldatearsofthekingdom.webp', 3, 10, 0),
(17, 'Metroid Prime 4 Beyond', 40.00, 4, 'Metroid_Prime_4.webp', 2, 10, 0),
(18, 'Animal Crossing New Horizons', 60.00, 4, 'AnimalCrossingNewHorizons.jpg', 4, 10, 0),
(19, 'Forza Horizon 6', 50.00, 3, 'forzahorizon6.jpg', 1, 10, 0),
(20, 'Cyberpunk', 70.00, 3, 'cyberpunk2077.jpg', 2, 10, 0),
(21, 'Indiana Jones and The great circle', 58.00, 3, 'inidanajones.jpg', 3, 10, 0),
(22, 'Red Dead Redemption II', 70.00, 3, 'rdr2.jpg', 2, 10, 0),
(23, 'Gran Turismo 7', 55.00, 1, 'GT7.webp', 3, 10, 0),
(24, 'Spider Man 2', 40.00, 1, 'spider-man-2.jpg', 4, 10, 0),
(25, 'Ghost of Yotei', 50.00, 1, 'ghostofyotei.jpg', 3, 10, 0),
(26, 'Splatoon 3', 55.00, 4, 'Splatoon_3.jpg', 2, 10, 0),
(27, 'Super Smash Bros Ultimate', 69.99, 4, 'ssbu.jpg', 1, 10, 0),
(28, 'Pokemon Legends Arceus', 55.00, 4, 'PokemonLegendsArceus.jpg', 4, 10, 0),
(29, 'GTA V', 69.99, 1, 'GTAV.jpg', 1, 10, 0),
(30, 'The Last Of Us Part 1', 50.00, 1, 'TheLastofUs.jpg', 3, 10, 0),
(31, 'Ratchet & Clank Rift apart', 40.00, 1, 'ratchetclank.jpg', 3, 10, 0),
(32, 'Resident Evil 2', 60.00, 3, 'resident-evil.jpg', 2, 10, 0),
(33, 'Fc 25', 45.00, 3, 'fc25.jpg', 1, 10, 0),
(34, 'Minecraft', 25.00, 3, 'minecraft.jpg', 3, 10, 0),
(35, 'Hollow Knight', 20.00, 2, 'hollow.jpg', 3, 10, 0),
(36, 'Beamng.drive', 40.00, 2, 'beamngdrive.jpg', 1, 10, 0),
(37, 'The Forest', 35.00, 2, 'theforest.jpg', 5, 10, 0),
(38, 'Rust', 40.00, 2, 'rust.jpg', 1, 10, 0),
(39, 'Arc Raiders', 30.00, 2, 'arc-raiders.jpg', 2, 10, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`) VALUES
(1, 6, 5, 5, 'leuke webshop'),
(2, 2, 5, 3, 'niet te veel keuze'),
(3, 7, 5, 4, 'leuke games'),
(4, 8, 5, 4, 'goed werkende webshop');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`) VALUES
(1, 'Admin', '', 'Admin1', 1),
(2, 'Dion', 'dbreur@gmail.com', '$2y$10$N9xfRd9ZLqhGTOliNyrECOf.21xZbgsZzVgFA7hPJvpK6BrqHRdq6', 0),
(4, 'svenadmin', 'admin@mail.com', '$2y$10$wy.O.cqrWUbDwsragu0AsuG1MNNeoFdVMW1O5P0DqaskzLg5OK.Pu', 1),
(5, 'adminS', 'admin@mail.comm', '$2y$10$xM/61a6Vvnq8l2mWeVWhZOQvKGp4.z2QCH1VVZ4pZlwxSVtUw4sDq', 0),
(6, 'keano', '9028451@student.zadkine.nl', '$2y$10$DbSjbfFH.gw.d1aURYRr7OU.zedAxvP9bppfbizQV407y1okLX8Tq', 0),
(7, 'sven', 'k@k', '$2y$10$R/zkbK4.JIEAyi08v4fvLuzc.WO9DQIk.4Nh43oYr4FRKZ6ybEQ4S', 0),
(8, 'Dylano', '23@23', '$2y$10$n9nbsTw2flp1E4JQU8lFXeI/obZNo6V8CtNn7YESCUDOxs8Gr0GSG', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`) VALUES
(3, 4, 18);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `consoles`
--
ALTER TABLE `consoles`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `console_id` (`console_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `consoles`
--
ALTER TABLE `consoles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT voor een tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
