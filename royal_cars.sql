-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 juin 2026 à 21:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `royal_cars`
--

-- --------------------------------------------------------

--
-- Structure de la table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `acceleration` varchar(50) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cars`
--

INSERT INTO `cars` (`id`, `name`, `category`, `price_per_day`, `image_url`, `badge`, `acceleration`, `seats`, `fuel_type`) VALUES
(1, 'Volkswagen Golf 8R', 'hatchbacks', 400.00, 'uploads/1752257025_urban-automotive-volkswagen-golf-8r-urban-carbon-l.webp', 'PERFORMANCE', '3.5s 0-60', 5, 'Gasoline'),
(2, 'Renault Clio 5 ALPINE', 'hatchbacks', 450.00, 'uploads/1752257088_Clio-dynamique-10-V3-Renault-Clio-5-2023-779x520.webp', 'PERFORMANCE', '4.0s 0-60', 5, 'Premuim'),
(3, 'Renault Megane 5', 'hatchbacks', 450.00, 'uploads/1752257253_RS-5.jpg', 'PERFORMANCE', '3.9s 0-60', 5, 'Premuim'),
(4, 'Cupra Leon', 'hatchbacks', 470.00, 'uploads/1752257351_cupra-leon-maroc-101.jpg', 'SPORTY', '5.7s 0-60', 5, 'Diesel'),
(5, 'Mercedes A-Class', 'hatchbacks', 500.00, 'uploads/1752257528_Mercedes A-Class.jpeg', 'LUXURY', '6.2s 0-60', 5, 'Gasoline'),
(6, 'Dacia Sandero', 'hatchbacks', 250.00, 'uploads/1752257735_Dacia Sandero.jpg', 'BUDGET', '11.5s 0-60', 5, 'Diesel'),
(8, 'Cadillac CTS-V', 'sport', 1600.00, 'uploads/1752257995_Cadillac CT-5V.jpeg', 'Aggressive', '3.8s 0-60', 5, 'Gasoline'),
(9, 'Audi RS6', 'sport', 4500.00, 'uploads/1752258059_2022-audi-abt-rs6-r-5k-k9-1360x768.jpg', 'Aggressive', '3.5s 0-60', 5, 'Gasoline'),
(10, 'Porsche GT3RS', 'sport', 17900.00, 'uploads/1752258200_2021-porsche-gt3-rs-4k-bg-1360x768.jpg', 'TRACK READY', '3.0s 0-60', 2, 'Gasoline'),
(11, 'Audi RS7', 'sport', 8500.00, 'uploads/1752258255_black-box-richter-audi-rs-7-sportback-2020-front-af-1360x768.jpg', 'EXCLUSIVE', '3.5s 0-60', 5, 'Gasoline'),
(12, 'Aston Martin', 'sport', 11000.00, 'uploads/1752258375_aston-martin-vantage-middle-east-2024-lg-1360x768.jpg', 'EXCLUSIVE', '3.5s 0-60', 2, 'Gasoline'),
(13, 'McLaren 620r', 'sport', 22000.00, 'uploads/1752258422_2021-novitec-mclaren-620r-kf-1360x768.jpg', 'EXCLUSIVE', '3.5s 0-60', 2, 'Gasoline'),
(14, 'BMW M4 2021', 'coupe', 4500.00, 'uploads/1752261931_bmw-m4-competition-x-alcantara-2023-jl-1360x768.jpg', 'PERFORMANCE', '3.8s 0-60', 4, 'Gasoline'),
(15, 'Mercedes CLE', 'coupe', 1790.00, 'uploads/1752262015_Mercedes CLE Coupé.jpeg', 'NEW MODEL', '4.8s 0-60', 4, 'Gasoline'),
(16, 'Mercedes C-Class', 'coupe', 1990.00, 'uploads/1752262295_C63.jpeg', 'Aggressive', '3.8s 0-60', 4, 'Gasoline'),
(17, 'Mercedes E-Class', 'coupe', 2500.00, 'uploads/1752262399_Mercedes E-Class.jpg', 'PERFORMANCE', '3.8s 0-60', 4, 'Gasoline'),
(18, 'BMW M2', 'coupe', 2200.00, 'uploads/1752262559_BMW M2.jpg', 'PERFORMANCE', '3.8s 0-60', 4, 'Gasoline'),
(19, 'BMW M8', 'coupe', 5500.00, 'uploads/1752262780_BMW M8.jpg', 'PERFORMANCE', '3.8s 0-60', 4, 'Gasoline'),
(20, 'BMW X7M', 'luxury', 11000.00, 'uploads/1752262967_bmw-x7.jpg', 'POPULAR', '3.5s 0-60', 7, 'Gasoline'),
(21, 'Mercedes G-Class', 'luxury', 11000.00, 'uploads/1752263017_mercedes-g-63-4k-b0-1360x768.jpg', 'PERFORMANCE', '4.0s 0-60', 5, 'Gasoline'),
(22, 'Mercedes S-Class', 'luxury', 17000.00, 'uploads/1752263082_Mercedes S-Class.jpg', 'POPULAR', '4.0s 0-60', 5, 'Gasoline'),
(24, 'Dacia Bigster', 'suvs', 450.00, 'uploads/1752263458_Dacia.jpg', 'ECO', '5.8s 0-60', 5, 'Gasoline'),
(26, 'Hyundai Tucson', 'suvs', 450.00, 'uploads/1752366186_Tuco.jpeg', 'POPULAR', '5.8s 0-60', 5, 'Gasoline'),
(27, 'Jeep Trackhawk', 'suvs', 550.00, 'uploads/1752366245_jeep-grand-cherokee.jpg', 'PERFORMANCE', '4.2s 0-60', 5, 'Gasoline'),
(28, 'Ford Mustang GT', 'muscles', 2500.00, 'uploads/1752366379_shelby-super-snake-5k-qg-1360x768.jpg', 'PERFORMANCE', '3.8s 0-60', 4, 'Gasoline'),
(29, 'Ford Mustang Shelby', 'muscles', 3000.00, 'uploads/1752366430_ford-mustang-shelby-1360x768.jpg', 'PERFORMANCE', '3.2s 0-60', 4, 'Gasoline'),
(30, 'Dodge Challenger', 'muscles', 2500.00, 'uploads/1752366499_2024-dodge-challenger-srt-ux-1360x768.jpg', 'PERFORMANCE', '3.9s 0-60', 4, 'Gasoline'),
(31, 'Dodge Charger', 'muscles', 2500.00, 'uploads/1752366669_dodge-charger-srt-hellcat-2019-i5-1360x768.jpg', 'PERFORMANCE', '3.9s 0-60', 4, 'Gasoline'),
(32, 'Chevrolet Camaro ', 'muscles', 2450.00, 'uploads/1752366806_camaro-5k-jb-1360x768.jpg', 'FUN', '3.4s 0-60', 4, 'Gasoline'),
(33, 'Ford Mustang GT500', 'muscles', 3500.00, 'uploads/1752366992_shelby-gt500-4k-wk-1360x768.jpg', 'FUN', '3.4s 0-60', 4, 'Gasoline'),
(34, 'Volkswagen Caddy', 'vans', 450.00, 'uploads/1752367273_Caddy.jpeg', 'Elegence', '8.1s 0-60', 7, 'Diesel'),
(35, 'Fiat Doblo', 'vans', 650.00, 'uploads/1752367386_thumb2-fiat-e-doblo-4k-minivans-2023-cars-hdr.jpg', 'Elegence', '11.1s 0-60', 7, 'Diesel'),
(36, 'Peugeot Rifter', 'vans', 450.00, 'uploads/1752367641_P.jpeg', 'Elegence', '11.1s 0-60', 7, 'Diesel'),
(39, 'Seat Ibiza FR', 'hatchbacks', 450.00, 'uploads/1766878786_seat-ibiza-arona-2025-6-700x466.jpg', 'PERFORMANCE', '3.9s 0-60', 4, 'Diesel'),
(42, 'BMW M3 G80', 'sport', 3000.00, 'uploads/1777388245_Capture d\'écran 2026-04-27 182005.png', 'PERFORMANCE', '3.4s 0-60', 5, 'Premuim');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'royal_cars', '123');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
