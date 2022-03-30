-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 mars 2022 à 13:10
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `airsport`
--
CREATE DATABASE IF NOT EXISTS `airsport` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `airsport`;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `IdCommande` int(11) NOT NULL AUTO_INCREMENT,
  `date_commande` date NOT NULL,
  `NumClient` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  PRIMARY KEY (`IdCommande`),
  KEY `FK_CommandeUtil` (`NumClient`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`IdCommande`, `date_commande`, `NumClient`, `montant`) VALUES
(7, '2022-03-13', 1, 120),
(13, '2022-03-26', 1, 100);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(150) NOT NULL,
  `IdProduit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idProduit` (`IdProduit`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `url`, `IdProduit`) VALUES
(1, 'image/produit/maillotequipedefrance1.png', 1),
(2, 'image/produit/maillotequipedefrance3.png', 1),
(38, 'image/produit/téléchargement.jpg', 55),
(47, 'image/produit/produitballon_de_basket.2jpg.jpg', 65),
(48, 'image/produit/produitballon_de_basket.jpg', 65),
(70, 'image/produit/roller.jpg', 77),
(71, 'image/produit/roller2.jpg', 77),
(72, 'image/produit/masqueescrime.jpg', 78),
(73, 'image/produit/masqueescrime2.jpg', 78),
(74, 'image/produit/casquevello.jpg', 79),
(75, 'image/produit/volley1.jpg', 80),
(76, 'image/produit/volley2.jpg', 80);

-- --------------------------------------------------------

--
-- Structure de la table `lignescommandes`
--

DROP TABLE IF EXISTS `lignescommandes`;
CREATE TABLE IF NOT EXISTS `lignescommandes` (
  `quantite` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`,`idProduit`),
  KEY `FK_QteCommandeProduit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lignescommandes`
--

INSERT INTO `lignescommandes` (`quantite`, `idCommande`, `idProduit`) VALUES
(2, 7, 1),
(1, 13, 1),
(2, 13, 65);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomProduit` varchar(256) NOT NULL,
  `description` varchar(500) NOT NULL,
  `prix` int(255) NOT NULL,
  `marque` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nomProduit`, `description`, `prix`, `marque`) VALUES
(1, 'Maillot Équipe de France', 'Maillot synthétique de l\'équipe de France disponible en Taille XS/S/M/L/XL', 60, 'Nike'),
(55, 'Raquette de Tennis', 'Raquette destinée aux jeunes joueurs (10-15ans) de tennis - Collection Wilson et Rolland Garros 2021', 25, 'Wilson'),
(65, 'Ballon de Basket', 'Ballon', 20, 'Spalding'),
(77, 'Roller rose et blanc', 'Taille : 20,5cm - 23cm\r\nCouleur Blanc-Rose\r\nLacets et scratch', 90, 'Raven'),
(78, 'Masque AllStar Escrime', 'Masque Allstar &quot;Super&quot; norme FFE avec un grillage très résistant et un grand confort', 150, 'AllStar'),
(79, 'Casque de vélo', 'Casque de vélo de montagne ou de route.\r\nTaille réglable entre 56cm - 60cm', 20, 'Luckatch'),
(80, 'Ballon de VolleyBall', 'Ballon de compétition en cuir synthétique souple', 42, 'Molten');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `nom` varchar(38) CHARACTER SET utf8 NOT NULL,
  `prenom` varchar(38) CHARACTER SET utf8 NOT NULL,
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `adressemail` varchar(100) CHARACTER SET utf8 NOT NULL,
  `adresse` varchar(100) CHARACTER SET utf8 NOT NULL,
  `mot_de_passe` varchar(100) CHARACTER SET utf8 NOT NULL,
  `CP` int(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `role` varchar(1) NOT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`nom`, `prenom`, `idUtilisateur`, `adressemail`, `adresse`, `mot_de_passe`, `CP`, `ville`, `role`) VALUES
('test', 'Test', 1, 'test@gmail.com', 'test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 76000, 'Rouen', 'C'),
('Admin', 'PrenomAdmin', 2, 'admin@gmail.com', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 76000, 'Rouen', 'A');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_CommandeUtil` FOREIGN KEY (`NumClient`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_Image` FOREIGN KEY (`IdProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `lignescommandes`
--
ALTER TABLE `lignescommandes`
  ADD CONSTRAINT `FK_QteCommandeCommande` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`IdCommande`),
  ADD CONSTRAINT `FK_QteCommandeProduit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
