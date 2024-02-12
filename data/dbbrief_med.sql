-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 03 fév. 2024 à 19:29
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbbrief_med`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_name` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `doctor_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `doctor_pathimg` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_name`, `doctor_description`, `doctor_pathimg`) VALUES
(1, 'Alice', 'Dr. Alice Kingsleigh, médecin renommée du pays des merveilles, apporte sa magie à la médecine moderne. Forte de son expérience dans des mondes fantastiques, elle assure la qualité des médicaments disponibles sur notre site. Sa combinaison unique de rigueur scientifique et de créativité offre des solutions novatrices pour le bien-être de tous. Faites confiance au Dr. Alice Kingsleigh pour des conseils médicaux exceptionnels au-delà de l\'ordinaire.', 'alice-doctor.webp'),
(2, 'Chapelier Fou', 'Le Chapelier Fou, expert excentrique en potions et remèdes du pays des merveilles, apporte une touche de folie à la médecine. Sa créativité débordante et sa compréhension unique des ingrédients inhabituels font de lui une figure clé dans le domaine pharmaceutique. En naviguant à travers des réalités fantaisistes, le Chapelier Fou propose des solutions médicales hors du commun pour favoriser le bien-être de chacun. Sa folie maîtrisée et son savoir atypique font de lui un allié surprenant et fiable dans la recherche de conseils médicaux singuliers et innovants.', 'madhatter-doctor.webp'),
(3, 'La Chenille', 'La Chenille, experte énigmatique du pays des merveilles, offre une perspective unique en tant que conseillère médicale. Sa sagesse transcendantale et son approche contemplative se reflètent dans la sélection minutieuse des produits pharmaceutiques sur notre site. La Chenille, avec son regard perspicace et son penchant pour les remèdes naturels, incarne une approche holistique de la santé. Confiez-vous à la guidance exceptionnelle de la Chenille pour des conseils médicaux uniques et apaisants.', 'caterpillar-doctor.webp'),
(4, 'Tweedledum et Tweedledee', 'Tweedledum et Tweedledee, experts du bien-être au pays des merveilles, ajoutent une touche ludique à la médecine. Ces jumeaux énergiques apportent une perspective unique, mêlant fantaisie et soins de santé. Leurs conseils, bien que farfelus, sont empreints d\'une jovialité contagieuse. En tant que figures clés sur notre site de vente de médicaments, Tweedledum et Tweedledee incarnent l\'harmonie entre la santé et la joie. Optez pour leur approche décalée pour une expérience médicale inédite et réjouissante.', 'twins-doctor.webp');

-- --------------------------------------------------------

--
-- Structure de la table `nav_category`
--

DROP TABLE IF EXISTS `nav_category`;
CREATE TABLE IF NOT EXISTS `nav_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nav_category`
--

INSERT INTO `nav_category` (`id`, `nav_name`) VALUES
(1, 'navbar'),
(2, 'footernav');

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_title` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `page_meta_desc` text COLLATE utf8mb4_general_ci,
  `page_meta_keywords` text COLLATE utf8mb4_general_ci,
  `page_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `page_bodyId` varchar(110) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nav_category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nav_category_id` (`nav_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pages`
--

INSERT INTO `pages` (`id`, `page_title`, `page_meta_desc`, `page_meta_keywords`, `page_url`, `page_bodyId`, `nav_category_id`) VALUES
(1, 'Accueil', 'Description SEO de ma page d\'accueil', 'homekey1, homekey2, homekey3, homekey4', '/', 'home', 1),
(2, 'Produits', 'Description SEO de ma page produits', 'product1, product2, product3, product4', '/produits.php', 'products', 1),
(3, 'Contact', 'Description SEO de ma page contact', 'contact1, contact2, contact3, contact4', '/contact.php', 'contact', 1),
(4, 'Mentions légales', 'Mentions légales du site', 'legal1, legal2, legal3, legal4', '/mentions-legales.php', 'legal', 2),
(5, 'Conditions générales', 'Conditions générales du site', 'cgu1, cgu2, cgu3, cgu4', '/cgu.php', 'cgu', 2),
(6, 'Politique de confidentialités', 'Politique de confidentialités du site', 'privacy1, privacy2, privacy3, privacy4', '/vie-privee.php', 'privacy', 2);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_title` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` float NOT NULL,
  `product_pathimg` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `product_category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_id` (`product_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `product_title`, `product_description`, `product_price`, `product_pathimg`, `product_category_id`) VALUES
(1, 'Drink Me', 'Une potion qui vous fait rétrécir ou grandir selon la quantité que vous buvez. Attention à ne pas en abuser !', 9.99, 'drink_me.webp', 2),
(2, 'Eat Me', 'Un gâteau qui vous fait changer de taille selon la part que vous mangez. Idéal pour explorer des endroits inaccessibles !', 12.99, 'eat_me.webp', 3),
(3, 'Upelkuchen', 'Un biscuit qui vous fait changer de couleur selon la saveur que vous choisissez. Parfait pour vous camoufler ou vous amuser !', 14.99, 'upelkuchen.webp', 3),
(4, 'Jabberwocky Blood', 'Un élixir qui vous donne des pouvoirs magiques pendant une courte durée. Utilisez-le avec prudence !', 19.99, 'jabberwocky_Blood.webp', 2),
(5, 'Outlandish', 'Une pilule qui vous fait changer de personnalité selon l’humeur que vous souhaitez. Idéale pour vous évader ou vous surprendre !', 16.99, 'outlandish.webp', 1),
(6, 'Rose me', 'Un gâteau qui vous transforme en une rose rouge. Vous pouvez ainsi embellir le jardin de la Reine de cœur, mais attention à ne pas vous faire couper !', 11.99, 'rose_me.webp', 3),
(7, 'Chess me', 'Un médicament qui vous fait entrer dans le jeu d’échecs vivant. Vous pouvez ainsi devenir un pion, un fou, une tour, un cavalier, un roi ou une reine, mais attention à ne pas vous faire échec et mat !', 6.99, 'chess_me.webp', 1),
(8, 'Wonderland Tea', 'Un thé qui vous transporte dans le monde merveilleux d’Alice. Attention, vous ne contrôlez pas le temps ni le lieu de votre retour !', 24.99, 'wonderland_Tea.webp', 3);

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_category`
--

INSERT INTO `product_category` (`id`, `category_name`) VALUES
(1, 'Comprimés magiques'),
(2, 'Concoctions fantastiques'),
(3, 'Saveurs enchantées');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `section_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `section_category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_category_id` (`section_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `section_title`, `section_description`, `section_category_id`) VALUES
(1, 'Présentation', 'Bienvenue au laboratoire pharmaceutique Wonderland Pharma, un établissement unique où la science et la magie se rencontrent pour créer des médicaments extraordinaires. Notre équipe dévouée de chercheurs et d\'alchimistes travaille sans relâche pour développer des formulations révolutionnaires qui permettent à nos clients de changer de taille, de couleur, ou même d\'acquérir des pouvoirs magiques. Inspiré par l\'univers fantastique de Lewis Carroll, notre laboratoire est déterminé à repousser les limites de la réalité et à offrir des expériences pharmacologiques inédites. Que vous cherchiez à explorer de nouveaux horizons dimensionnels ou à embrasser votre côté fantastique, notre gamme de produits innovants est conçue pour émerveiller et surprendre. Rejoignez-nous dans cette aventure extraordinaire où la science et la magie convergent pour créer des solutions pharmaceutiques uniques au pays des rêves et de l\'émerveillement.', 1),
(2, 'Contactez-nous', 'Vous avez des questions, n\'hésitez pas à nous contacter nous nous ferons un plaisir de vous aider.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `section_category`
--

DROP TABLE IF EXISTS `section_category`;
CREATE TABLE IF NOT EXISTS `section_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_category_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `section_category`
--

INSERT INTO `section_category` (`id`, `section_category_name`) VALUES
(1, 'home'),
(2, 'contact');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`nav_category_id`) REFERENCES `nav_category` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`);

--
-- Contraintes pour la table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`section_category_id`) REFERENCES `section_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
