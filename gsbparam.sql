-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 mai 2022 à 08:47
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbparam`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `nomPrenom` text NOT NULL,
  `ville` text NOT NULL,
  `rue` text NOT NULL,
  `cp` text NOT NULL,
  `mail` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` char(3) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `nom` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `mdp` char(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `libelle` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `nomPrenomClient` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `adresseRueClient` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `cpClient` char(5) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `villeClient` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `mailClient` char(50) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `dateCommande`, `nomPrenomClient`, `adresseRueClient`, `cpClient`, `villeClient`, `mailClient`) VALUES
('1101461660', '2011-07-12', 'Dupont Jacques', '12, rue haute', '75001', 'Paris', 'dupont@wanadoo.fr'),
('1101461665', '2011-07-20', 'Durant Yves', '23, rue des ombres', '75012', 'Paris', 'durant@free.fr'),
('1101461666', '2021-11-10', 'Weill Alban', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461667', '2021-11-10', 'Weill Alban', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461668', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461669', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461670', '2021-11-10', 'Weill Alban', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461671', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461672', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461673', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461674', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461675', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461676', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461677', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461678', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461679', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461680', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461681', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461682', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461683', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461684', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461685', '2021-11-10', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461686', '2021-11-23', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com'),
('1101461687', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461688', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461689', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461690', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461691', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461692', '2021-11-23', 'Weill', '1 rue du clos moussu', '45190', 'Orléa', 'alban45190@gmail.com'),
('1101461693', '2021-11-23', 'test', 'tswet', '45190', 'setst', 'alban45190@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `idCommande` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `idProduit` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`idCommande`, `idProduit`) VALUES
('1101461660', 'f03'),
('1101461660', 'p01'),
('1101461665', 'f05'),
('1101461665', 'p06'),
('1101461666', 'c02'),
('1101461668', 'c03'),
('1101461669', 'c03'),
('1101461670', 'c01'),
('1101461671', 'c01'),
('1101461672', 'c01'),
('1101461673', 'c01'),
('1101461674', 'c01'),
('1101461675', 'c01'),
('1101461676', 'c01'),
('1101461677', 'c01'),
('1101461678', 'c01'),
('1101461679', 'c01'),
('1101461680', 'c01'),
('1101461681', 'c01'),
('1101461682', 'c01'),
('1101461686', 'c01'),
('1101461686', 'c02'),
('1101461687', 'c02'),
('1101461687', 'c03'),
('1101461687', 'c04'),
('1101461693', 'c01'),
('1101461693', 'c02');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `description` char(50) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` char(100) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `idCategorie` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `description`, `prix`, `image`, `idCategorie`) VALUES
('c01', 'Laino Shampooing Douche au Thé Vert BIO', '4.00', 'images/laino-shampooing-douche-au-the-vert-bio-200ml.png', 'CH'),
('c02', 'Klorane fibres de lin baume après shampooing', '10.80', 'images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', 'CH'),
('c03', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', '4.00', 'images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', 'CH'),
('c04', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', '4.00', 'images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', 'CH'),
('c05', 'Klorane Shampooing sec à l\'extrait d\'ortie', '6.10', 'images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', 'CH'),
('c06', 'Phytopulp mousse volume intense', '18.00', 'images/phytopulp-mousse-volume-intense-200ml.jpg', 'CH'),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', '8.00', 'images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', 'CH'),
('f01', 'Nuxe Men Contour des Yeux Multi-Fonctions', '12.05', 'images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', 'FO'),
('f02', 'Tisane romon nature sommirel bio sachet 20', '5.50', 'images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', 'FO'),
('f03', 'La Roche Posay Cicaplast crème pansement', '11.00', 'images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', 'FO'),
('f04', 'Futuro sport stabilisateur pour cheville', '26.50', 'images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', 'FO'),
('f05', 'Microlife pèse-personne électronique weegschaal', '63.00', 'images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', 'FO'),
('f06', 'Melapi Miel Thym Liquide 500g', '6.50', 'images/melapi-miel-thym-liquide-500g.jpg', 'FO'),
('f07', 'Meli Meliflor Pollen 200g', '8.60', 'images/melapi-pollen-250g.jpg', 'FO'),
('p01', 'Avène solaire Spray très haute protection', '22.00', 'images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', 'PS'),
('p02', 'Mustela Solaire Lait très haute Protection', '17.50', 'images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', 'PS'),
('p03', 'Isdin Eryfotona aAK fluid', '29.00', 'images/isdin-eryfotona-aak-fluid-100-50ml.jpg', 'PS'),
('p04', 'La Roche Posay Anthélios 50+ Brume Visage', '8.75', 'images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', 'PS'),
('p05', 'Nuxe Sun Huile Lactée Capillaire Protectrice', '15.00', 'images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', 'PS'),
('p06', 'Uriage Bariésun stick lèvres SPF30 4g', '5.65', 'images/uriage-bariesun-stick-levres-spf30-4g.jpg', 'PS'),
('p07', 'Bioderma Cicabio creme SPF50+ 30ml', '13.70', 'images/bioderma-cicabio-creme-spf50-30ml.png', 'PS');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`idCommande`,`idProduit`),
  ADD KEY `I_FK_CONTENIR_COMMANDE` (`idCommande`),
  ADD KEY `I_FK_CONTENIR_Produit` (`idProduit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `I_FK_Produit_CATEGORIE` (`idCategorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
