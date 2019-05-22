-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 22 mai 2019 à 16:08
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tripviewer`
--

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `name`) VALUES
(1, 'Aegean Airlines'),
(2, 'Aer Lingus'),
(3, 'Aeroflot'),
(4, 'Aerolineas Argentinas'),
(5, 'Aeromexico'),
(6, 'Air Austral'),
(7, 'Air Canada'),
(8, 'Air Caraibes'),
(9, 'Air China'),
(10, 'Air Europa'),
(11, 'Air France'),
(12, 'Air India'),
(13, 'Air India Express'),
(14, 'Air Italy'),
(15, 'Air Namibia'),
(16, 'Air New Zealand'),
(17, 'Air Serbia'),
(18, 'Air Tahiti Nui'),
(19, 'Air Transat'),
(20, 'Air Vanuatu'),
(21, 'AirAsia'),
(22, 'AirAsia X'),
(23, 'Aircalin'),
(24, 'Alaska Airlines'),
(25, 'Alitalia'),
(26, 'Allegiant'),
(27, 'American Airlines'),
(28, 'ANA'),
(29, 'Asiana'),
(30, 'AtlasGlobal'),
(31, 'Austrian'),
(32, 'Avianca'),
(33, 'Azerbaijan Hava Yollary'),
(34, 'Azores Airlines'),
(35, 'Azul'),
(36, 'Bangkok Airways'),
(37, 'bmi regional'),
(38, 'British Airways'),
(39, 'Brussels Airlines'),
(40, 'Cathay Pacific'),
(41, 'CEBU Pacific Air'),
(42, 'China Airlines'),
(43, 'China Eastern'),
(44, 'China Southern'),
(45, 'Condor'),
(46, 'Copa Airlines'),
(47, 'Croatia Airlines'),
(48, 'Czech Airlines'),
(49, 'Delta'),
(50, 'Dragonair'),
(51, 'easyJet'),
(52, 'Edelweiss Air'),
(53, 'Egyptair'),
(54, 'EL AL'),
(55, 'Emirates'),
(56, 'Ethiopian Airlines'),
(57, 'Etihad'),
(58, 'Eurowings'),
(59, 'EVA Air'),
(60, 'Fiji Airways'),
(61, 'Finnair'),
(62, 'FlyBE'),
(63, 'flydubai'),
(64, 'FlyOne'),
(65, 'French bee'),
(66, 'Frontier'),
(67, 'Garuda Indonesia'),
(68, 'Germanwings'),
(69, 'Gol'),
(70, 'Gulf Air'),
(71, 'Hainan Airlines'),
(72, 'Hawaiian Airlines'),
(73, 'Hong Kong Airlines'),
(74, 'Iberia'),
(75, 'Icelandair'),
(76, 'IndiGo Airlines'),
(77, 'InterJet'),
(78, 'Japan Airlines'),
(79, 'Jeju Air'),
(80, 'Jet Airways'),
(81, 'Jet2'),
(82, 'JetBlue'),
(83, 'Jetstar'),
(84, 'Kenya Airways'),
(85, 'KLM'),
(86, 'Korean Air'),
(87, 'La Compagnie'),
(88, 'LATAM Brasil'),
(89, 'LATAM Chile'),
(90, 'Lion Airlines'),
(91, 'LOT Polish Airlines'),
(92, 'Lufthansa'),
(93, 'Malaysia Airlines'),
(94, 'Middle East Airlines'),
(95, 'Nok Air'),
(96, 'Nordwind Airlines'),
(97, 'Norwegian Air Shuttle'),
(98, 'Oman Air'),
(99, 'Pakistan International Airlines'),
(100, 'Peach'),
(101, 'Pegasus Airlines'),
(102, 'Philippine Airlines'),
(103, 'Porter'),
(104, 'Qantas'),
(105, 'Qatar Airways'),
(106, 'Regional Express'),
(107, 'Rossiya - Russian Airlines'),
(108, 'Royal Air Maroc'),
(109, 'Royal Brunei'),
(110, 'Royal Jordanian'),
(111, 'Ryanair'),
(112, 'S7 Airlines'),
(113, 'SAS'),
(114, 'Saudia'),
(115, 'Scoot Airlines'),
(116, 'Shanghai Airlines'),
(117, 'Silkair'),
(118, 'Singapore Airlines'),
(119, 'Skylanes'),
(120, 'South African Airways'),
(121, 'Southwest'),
(122, 'SpiceJet'),
(123, 'Spirit'),
(124, 'Spring Airlines'),
(125, 'Spring Japan'),
(126, 'SriLankan Airlines'),
(127, 'Sun Country'),
(128, 'Sunwing'),
(129, 'SWISS'),
(130, 'Swoop'),
(131, 'TAAG'),
(132, 'TACA'),
(133, 'TAP Portugal'),
(134, 'THAI'),
(135, 'Thomas Cook Airlines'),
(136, 'Thomson'),
(137, 'tigerair Australia'),
(138, 'Transavia Airlines'),
(139, 'TUIfly'),
(140, 'Tunis Air'),
(141, 'Turkish Airlines'),
(142, 'Ukraine International'),
(143, 'United'),
(144, 'UTair Aviation'),
(145, 'Vanilla Air'),
(146, 'Vietnam Airlines'),
(147, 'Virgin Atlantic'),
(148, 'Virgin Australia'),
(149, 'Vistara'),
(150, 'Viva Aerobus'),
(151, 'Volaris'),
(152, 'Volotea'),
(153, 'Vueling Airlines'),
(154, 'WestJet'),
(155, 'Wizzair'),
(156, 'WOW air'),
(157, 'Xiamen Airlines');

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

CREATE TABLE `destination` (
  `id` int(11) NOT NULL,
  `destination` varchar(255) COLLATE utf8_bin NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `country` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_trip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `transport` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `transport`
--

INSERT INTO `transport` (`id`, `transport`) VALUES
(1, 'Plane'),
(2, 'Car'),
(3, 'Boat'),
(4, 'Bike'),
(5, 'On foot'),
(6, 'Others');

-- --------------------------------------------------------

--
-- Structure de la table `trip`
--

CREATE TABLE `trip` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `departure_date` date NOT NULL,
  `return_date` date NOT NULL,
  `km_traveled` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `trip_state` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_transport_type` int(11) NOT NULL,
  `id_destination` int(11) NOT NULL,
  `id_departure` int(11) NOT NULL,
  `number_people` int(11) DEFAULT NULL,
  `id_company` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_trip` (`id_trip`);

--
-- Index pour la table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `FK_transport_type` (`id_transport_type`),
  ADD KEY `FK_destination` (`id_destination`),
  ADD KEY `FK_departure` (`id_departure`),
  ADD KEY `FK_company` (`id_company`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT pour la table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_trip` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `FK_company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_departure` FOREIGN KEY (`id_departure`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_destination` FOREIGN KEY (`id_destination`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_transport_type` FOREIGN KEY (`id_transport_type`) REFERENCES `transport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
