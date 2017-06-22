-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 22 Juin 2017 à 17:57
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kportal`
--

-- --------------------------------------------------------

--
-- Structure de la table `h5p__dependency`
--

CREATE TABLE `h5p__dependency` (
  `id_dependency` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `id_dependee` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `dependency_type` varchar(31) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'preloaded'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `h5p__dependency`
--

INSERT INTO `h5p__dependency` (`id_dependency`, `id_dependee`, `dependency_type`) VALUES
('1', '9', 'preloaded'),
('5', '1', 'preloaded'),
('5', '3', 'preloaded'),
('5', '8', 'preloaded'),
('6', '2', 'preloaded'),
('6', '3', 'preloaded'),
('6', '5', 'preloaded'),
('6', '7', 'preloaded'),
('7', '3', 'preloaded'),
('7', '5', 'preloaded');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `h5p__dependency`
--
ALTER TABLE `h5p__dependency`
  ADD PRIMARY KEY (`id_dependency`,`id_dependee`),
  ADD KEY `IDX_A69E0D328AD2D5D2` (`id_dependency`),
  ADD KEY `IDX_A69E0D325353E2FA` (`id_dependee`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `h5p__dependency`
--
ALTER TABLE `h5p__dependency`
  ADD CONSTRAINT `FK_A69E0D325353E2FA` FOREIGN KEY (`id_dependee`) REFERENCES `h5p__library` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A69E0D328AD2D5D2` FOREIGN KEY (`id_dependency`) REFERENCES `h5p__library` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
