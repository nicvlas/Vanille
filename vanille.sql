-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 17 Novembre 2019 à 18:19
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `vanille`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE IF NOT EXISTS `administrateur` (
  `ADM_id` int(3) NOT NULL AUTO_INCREMENT,
  `Login` varchar(20) NOT NULL,
  `Mdp` varchar(20) NOT NULL,
  PRIMARY KEY (`ADM_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`ADM_id`, `Login`, `Mdp`) VALUES
(1, 'admin1', 'A1'),
(2, 'admin2', 'B2');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `CAT_id` char(3) NOT NULL,
  `libelle` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`CAT_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`CAT_id`, `libelle`) VALUES
('bon', 'Bonbons'),
('car', 'Caramels'),
('cho', 'Chocolats');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `CDE_id` int(3) NOT NULL,
  `datecommande` date DEFAULT NULL,
  `nomPrenomClient` varchar(50) DEFAULT NULL,
  `adresseRueClient` varchar(50) DEFAULT NULL,
  `cpClient` char(5) DEFAULT NULL,
  `villeClient` varchar(40) DEFAULT NULL,
  `mailClient` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CDE_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`CDE_id`, `datecommande`, `nomPrenomClient`, `adresseRueClient`, `cpClient`, `villeClient`, `mailClient`) VALUES
(1, '2019-11-17', 'Nicolas VITE', '38 avenue augustin labouilhe', '31650', 'nicolas.vite@hotmail.com', 'SAINT ORENS DE GAMEVILLE'),
(2, '2019-11-17', 'Nicolas VITE', '38 avenue augustin labouilhe', '31650', 'nicolas.vite@hotmail.com', 'SAINT ORENS DE GAMEVILLE');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE IF NOT EXISTS `contenir` (
  `idcommande` int(3) NOT NULL,
  `idProduit` char(5) NOT NULL,
  PRIMARY KEY (`idcommande`,`idProduit`),
  KEY `I_FK_CONTENIR_Commande` (`idcommande`),
  KEY `I_FK_CONTENIR_Produit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `contenir`
--

INSERT INTO `contenir` (`idcommande`, `idProduit`) VALUES
(1, 'BO01'),
(1, 'CH03'),
(2, 'BO08');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `PDT_id` char(5) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `idCategorie` char(3) NOT NULL,
  `qte_stock` int(4) DEFAULT NULL,
  PRIMARY KEY (`PDT_id`),
  KEY `FK_Produit_CATEGORIE` (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`PDT_id`, `description`, `prix`, `image`, `idCategorie`, `qte_stock`) VALUES
('BO01', 'Bonbons acidulés Lot 3 Kg', '43.00', 'images/bonbons/bonbon1.png', 'bon', 499),
('BO03', 'Bonbons menthe Lot 3Kg', '33.00', 'images/bonbons/bonbon3.png', 'bon', 500),
('BO04', 'Sucettes festives Lot 3Kg', '48.00', 'images/bonbons/bonbon4.png', 'bon', 500),
('BO05', 'Bonbons surprise Lot 1Kg', '14.00', 'images/bonbons/bonbon5.png', 'bon', 500),
('BO06', 'Smarties Lot 3Kg', '18.00', 'images/bonbons/bonbon6.png', 'bon', 500),
('BO07', 'Nounours colorés Lot 2Kg', '24.00', 'images/bonbons/bonbon7.png', 'bon', 500),
('BO08', 'Bonbon coca', '23.00', 'images/bonbons/bonbon08.png', 'bon', 499),
('CA01', 'Caramels Beurre salé  lot 2Kg', '36.00', 'images/caramels/caramel1.png', 'car', 500),
('CA02', 'Caramels Vanille  lot 1Kg', '13.00', 'images/caramels/caramel2.png', 'car', 500),
('CA03', 'Caramel tablette Lot 3Kg', '30.00', 'images/caramels/caramel3.png', 'car', 500),
('CA04', 'Caramels parfumés Lot 2Kg', '41.00', 'images/caramels/caramel4.png', 'car', 500),
('CA05', 'Caramels croquants Lot 1Kg', '18.00', 'images/caramels/caramel5.png', 'car', 500),
('CA06', 'Caramels surprise Lot 3 Kg', '48.00', 'images/caramels/caramel6.png', 'car', 500),
('CH01', 'Chocolats Pralinés lot 1Kg', '17.00', 'images/chocolats/choco1.png', 'cho', 500),
('CH02', 'Oeufs en chocolat Lot 2Kg', '26.00', 'images/chocolats/choco2.png', 'cho', 500),
('CH03', 'Fagots au chocolat lot 1Kg', '17.00', 'images/chocolats/choco3.png', 'cho', 499),
('CH04', 'Chocolats amande Lot 2Kg', '45.00', 'images/chocolats/choco4.png', 'cho', 500),
('CH05', 'Noir Intense Lot 3Kg', '55.00', 'images/chocolats/choco5.png', 'cho', 500),
('CH06', 'Vanille Chocolat lot 1Kg', '23.00', 'images/chocolats/choco6.png', 'cho', 500),
('CH07', 'Trésor de Chocolats  lot 2Kg', '65.00', 'images/chocolats/choco7.png', 'cho', 500),
('CH08', 'Truffes délice lot 2Kg', '43.00', 'images/chocolats/choco8.png', 'cho', 500);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_fk_1` FOREIGN KEY (`idcommande`) REFERENCES `commande` (`CDE_id`),
  ADD CONSTRAINT `contenir_fk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`PDT_id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`CAT_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
