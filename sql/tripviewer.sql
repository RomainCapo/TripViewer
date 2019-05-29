-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 29 mai 2019 à 11:24
-- Version du serveur :  5.7.21
-- Version de PHP :  7.1.16

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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`id`, `destination`, `latitude`, `longitude`, `country`) VALUES
(49, 'sydney', -33.8688197, 151.2092955, 'Australia'),
(50, 'genève', 46.2043907, 6.1431577, 'Switzerland'),
(51, 'lyon', 45.764043, 4.835659, 'France'),
(52, 'paris', 48.856614, 2.3522219, 'France'),
(53, 'london', 51.5073509, -0.1277583, 'United Kingdom'),
(54, 'zurich', 47.3768866, 8.541694, 'Switzerland'),
(55, 'liverpool', 43.106456, -76.2177046, 'United States'),
(56, 'bangkok', 13.7563309, 100.5017651, 'Thailand'),
(57, 'geneve', 46.2043907, 6.1431577, 'Switzerland'),
(58, 'bora bora', -16.5004126, -151.7414904, 'French Polynesia');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_trip` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trip` (`id_trip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  PRIMARY KEY (`id`),
  KEY `FK_user` (`id_user`),
  KEY `FK_transport_type` (`id_transport_type`),
  KEY `FK_destination` (`id_destination`),
  KEY `FK_departure` (`id_departure`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `trip`
--

INSERT INTO `trip` (`id`, `name`, `description`, `departure_date`, `return_date`, `km_traveled`, `total_price`, `trip_state`, `id_user`, `id_transport_type`, `id_destination`, `id_departure`, `number_people`) VALUES
(1, 'test', '', '2019-05-25', '2019-06-01', 776, 44, 'reserved', 7, 3, 53, 54, 4),
(2, 'test', 'wetrt', '2019-06-01', '2019-07-06', 488, 55, 'reserved', 7, 4, 52, 54, 45),
(3, 'quwhfio', '', '2019-05-10', '2019-06-01', 16774, 666, 'realized', 7, 1, 49, 50, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `creation_date`) VALUES
(7, 'Romain', 'romain.capocasale99@gmail.com', '$2y$10$/.OfI5shfjJ1kWHl2Iso5OHqRUlnlm2fSCkRVrFb9u8i4C.tRDNkq', '2019-05-22 16:21:33'),
(8, 'toto', 'toto@gmail.com', '$2y$10$L4yheM9CcOhMDcuovUGbOO0ERousKJ6j4J6a8PK5WaP4OZos5gIpK', '2019-05-22 17:00:00');

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
  ADD CONSTRAINT `FK_departure` FOREIGN KEY (`id_departure`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_destination` FOREIGN KEY (`id_destination`) REFERENCES `destination` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_transport_type` FOREIGN KEY (`id_transport_type`) REFERENCES `transport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
