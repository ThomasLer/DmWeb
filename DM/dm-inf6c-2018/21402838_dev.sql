-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  mysql.info.unicaen.fr:3306
-- Généré le :  Mer 28 Mars 2018 à 22:52
-- Version du serveur :  5.5.59-0+deb8u1-log
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `21402838_dev`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `nom` varchar(50) NOT NULL,
  `pseudo` varchar(70) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `role` varchar(30) DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comptes`
--

INSERT INTO `comptes` (`nom`, `pseudo`, `mdp`, `role`) VALUES
('Nathan Chevalier', 'Asurion', '$2y$10$Q6Mzi/2Z5B82bF9Z.pGj3ejicq8r5BPzqQVYq/e6lZ6txX/nVq.q6', 'admin'),
('Nathan Chevalier', 'Asuri0n', '$2y$10$1XQS.FuH5XXJHu7xO3HmxuqLNx4HBITFy1z7zHFY4xwPlUedzefy2', 'admin'),
('qdz', '21404260', '$2y$10$.hEAeNUTysEBcAgkS3BZaOAZCoXSG6Vlpfo.lffnb40ZUpEswygOG', 'admin'),
('toto', 'toto', '$2y$10$ASQ8Wt9dA.nfCQE7duKxv.ZFaXvHuI53CcpUauHoVHNrXK4RX1sFW', 'user'),
('TOTO2', 'toto2', '$2y$10$6/bk0xGA9fR303HeCPzfZOHxmnsIjmhFYCNqMBuCisAlbasg3s5QG', 'user'),
('aaa', 'zzz', '$2y$10$WfZnLEDMsUzk8p5tTFNzSOg7QH5GkhKKzvFCIeU6C.b6PtKmCe81a', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `jvd`
--

CREATE TABLE `jvd` (
  `id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `genre` varchar(250) DEFAULT NULL,
  `annee_sortie` int(11) DEFAULT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `pseudo_utilisateur` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `jvd`
--

INSERT INTO `jvd` (`id`, `nom`, `genre`, `annee_sortie`, `photo`, `pseudo_utilisateur`) VALUES
(6, 'aaaa', 'zzzzzzz', 1950, './upload/upload_', 'Asurion'),
(2, 'TomRaider', 'Aventure', 1988, './upload/upload_', 'Asurion'),
(5, 'jeu toto', 'action', 1950, './upload/upload_Warframe0006.jpg', 'toto'),
(4, 'Test', 'action', 2009, './upload/upload_Warframe0005.jpg', 'toto'),
(7, 'teste', 'test', 1955, './upload/upload_', 'Asurion');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `jvd`
--
ALTER TABLE `jvd`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `jvd`
--
ALTER TABLE `jvd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
