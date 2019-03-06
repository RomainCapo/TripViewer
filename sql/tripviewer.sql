-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 28 fév. 2019 à 21:06
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

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

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

DROP TABLE IF EXISTS `destination`;
CREATE TABLE IF NOT EXISTS `destination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destination` varchar(255) COLLATE utf8_bin NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `country` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`id`, `destination`, `latitude`, `longitude`, `country`) VALUES
(1, 'Buenos Aires', -35, -58, 'Argentina'),
(2, 'Lima', -12.0463731, -77.042754, 'Peru');

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transport` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

DROP TABLE IF EXISTS `trip`;
CREATE TABLE IF NOT EXISTS `trip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `departure_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `km_traveled` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `trip_state` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_transport_type` int(11) NOT NULL,
  `id_destination` int(11) NOT NULL,
  `id_departure` int(11) NOT NULL,
  `number_people` int(11) DEFAULT NULL,
  `id_company` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user` (`id_user`),
  KEY `FK_transport_type` (`id_transport_type`),
  KEY `FK_destination` (`id_destination`),
  KEY `FK_departure` (`id_departure`),
  KEY `FK_company` (`id_company`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `creation_date`) VALUES
(1, 'Romain', 'romain.capocasale@gmail.com', '1234', '2019-02-28 20:49:04');

--
-- Contraintes pour les tables déchargées
--

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
