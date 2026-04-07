-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 apr 2026 om 10:35
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
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `console_id` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `console_id`, `foto`, `categorie_id`, `stock`) VALUES
(2, 'Call of Duty: Black Ops 6', 80.00, 3, 'call_of_duty_bo6.jpg', 1, 10),
(3, 'Minecraft', 50.00, 3, 'minecraft.jpg', 1, 10),
(4, 'Call of Duty: Warzone', 20.00, 3, 'call_of_duty_warzone.jpg', 1, 10),
(5, 'Farcry', 50.00, 2, 'Farcry.jpg', 1, 10),
(6, 'R.E.P.O', 19.00, 2, 'repo.jpg', 5, 10),
(7, 'Peak', 19.00, 2, 'peak.jpg', 3, 10),
(8, 'Project Zomboid', 30.00, 2, 'project_zomboid.jpg', 5, 10),
(9, 'MarioKartWorld', 60.00, 4, 'MarioKartWorldjpg.jpg', 3, 10),
(10, 'mario_odyssey', 60.00, 4, 'mario_odysseyjpg.jpg', 3, 10),
(11, 'LuigisMansion3', 60.00, 4, 'LuigisMansion3.jpg', 5, 10),
(12, 'god of war ragnerok', 60.00, 1, 'god-of-war-ragnarok-2.webp', 3, 10),
(13, 'astrobots', 60.00, 1, 'astrobots.jpg', 3, 10),
(14, 'Avatar Frontiers of Pandora', 60.00, 1, 'Avatar-Frontiers-of-Pandora.webp', 3, 10);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `console_id` (`console_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
