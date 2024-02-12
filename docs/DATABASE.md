# La base de données `db_wpharma`

Réalisé sans outils à la main en se basant sur le schéma UML réalisé avec Draw.io.

1. **`nav_category`** : Cette table stocke les informations sur les différentes catégories de navigation. Chaque catégorie a un `id` unique (PK) et un `nav_name`.
2. **`pages`** : Cette table stocke les informations sur les différentes pages web. Chaque page a un `id` unique (PK), un `page_title`, un `page_meta_desc`, un `page_meta_keywords`, un `page_url`, un `page_bodyId` et un `nav_category_id`. Le `nav_category_id` est une clé étrangère (FK) qui fait référence à l'`id` de la table `nav_category`. Cela signifie qu'une page est associée à une catégorie de navigation.
3. **`section_category`** : Cette table stocke les informations sur les différentes catégories de sections. Chaque catégorie de section a un `id` unique (PK) et un `section_category_name`.
4. **`sections`** : Cette table stocke les informations sur les différentes sections. Chaque section a un `id` unique (PK), un `section_title`, un `section_description` et un `section_category_id`. Le `section_category_id` est une clé étrangère (FK) qui fait référence à l'`id` de la table `section_category`. Cela signifie qu'une section est associée à une catégorie de section.
5. **`product_category`** : Cette table stocke les informations sur les différentes catégories de produits. Chaque catégorie de produit a un `id` unique et un `category_name`.
6. **`products`** : Cette table stocke les informations sur les différents produits. Chaque produit a un `id` unique (PK), un `product_title`, un `product_description`, un `product_price` et un `product_category_id`. Le `product_category_id` est une clé étrangère qui fait référence à l'`id` de la table `product_category`. Cela signifie qu'un produit est associé à une catégorie de produit.
7. **`product_pictures`** : Cette table stocke les informations sur les différentes images de produits. Chaque image a un `id` unique (PK), un `pathImg` et un `product_id`. Le `product_id` est une clé étrangère (FK) qui fait référence à l'`id` de la table `products`. Cela signifie qu'une image est associée à un produit.
8. **`doctors`** : Cette table stocke les informations sur les différents médecins. Chaque médecin a un `id` unique (PK), un `doctor_name` et un `doctor_description`.
9. **`doctor_pictures`** : Cette table stocke les informations sur les différentes images de médecins. Chaque image a un `id` unique (PK), un `pathImg` et un `doctor_id`. Le `doctor_id` est une clé étrangère (FK) qui fait référence à l'`id` de la table `doctors`. Cela signifie qu'une image est associée à un médecin.
10. **`doctors_products`** : Cette table est une table de intermédiaire qui lie les tables `doctors` et `products`. Elle contient `doctor_id` et `product_id`, qui sont tous deux des clés étrangères (FK) faisant référence aux `id` des tables `doctors` et `products` respectivement. Cela signifie qu'un médecin peut être associé à plusieurs produits et vice versa.

> [!NOTE]
> PK (Primary Key) : La clé primaire permet d’identifier chaque enregistrement dans une table de base de données.  
> FK (Foreign Key) : La clé étrangère fait référence à la clé primaire d’une autre table, elle permet de mettre en relation les différentes tables de la BDD.

## Schéma UML

![Schéma UML dbbrief_med](../docs/uml/export/db_wpharma-uml.svg)

**Détails des relations entre les tables** :

1. **Many-to-One** :
   - `pages` à `nav_category` : Plusieurs pages (`pages`) peuvent appartenir à une seule catégorie de navigation (`nav_category`).
   - `sections` à `section_category` : Plusieurs sections (`sections`) peuvent appartenir à une seule catégorie de section (`section_category`).
   - `products` à `product_category` : Plusieurs produits (`products`) peuvent appartenir à une seule catégorie de produit (`product_category`).

2. **One-to-Many** :
   - `products` à `product_pictures` : Un produit (`products`) peut avoir plusieurs images de produits (`product_pictures`).
   - `doctors` à `doctor_pictures` : Un médecin (`doctors`) peut avoir plusieurs images de médecins (`doctor_pictures`).

3. **Many-to-Many** :
   - `doctors` à `products` via `doctors_products` : Un médecin (`doctors`) peut être associé à plusieurs produits (`products`) et vice versa. Cette relation est gérée par la table de liaison `doctors_products`.

## Requête SQL création de la base de données

```sql
--
-- CREATION BDD : `db_wpharma`
--

DROP DATABASE IF EXISTS `db_wpharma`;
CREATE DATABASE IF NOT EXISTS `db_wpharma`;

USE `db_wpharma`;

--
-- CREATION DES TABLES
--

DROP TABLE IF EXISTS `nav_category`;
CREATE TABLE IF NOT EXISTS `nav_category` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `nav_name` VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `page_title` VARCHAR(110) NOT NULL,
    `page_meta_desc` TEXT,
    `page_meta_keywords` TEXT,
    `page_url` VARCHAR(255) NOT NULL,
    `page_bodyId` VARCHAR(110),
    `nav_category_id` INT NOT NULL,
    FOREIGN KEY (`nav_category_id`) REFERENCES `nav_category`(`id`)
);

DROP TABLE IF EXISTS `section_category`;
CREATE TABLE IF NOT EXISTS `section_category` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `section_category_name` VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `section_title` VARCHAR(110) NOT NULL,
    `section_description` TEXT NOT NULL,
    `section_category_id` INT NOT NULL,
    FOREIGN KEY (`section_category_id`) REFERENCES `section_category`(`id`)
);

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `category_name` VARCHAR(110) NOT NULL
);

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `product_title` VARCHAR(110) NOT NULL,
    `product_description` TEXT NOT NULL,
    `product_price` FLOAT NOT NULL,
    `product_category_id` INT NOT NULL,
    FOREIGN KEY (`product_category_id`) REFERENCES `product_category`(`id`)
);

DROP TABLE IF EXISTS `product_pictures`;
CREATE TABLE IF NOT EXISTS `product_pictures` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `pathImg` VARCHAR(255) NOT NULL,
    `product_id` INT,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
);

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `doctor_name` VARCHAR(110) NOT NULL,
    `doctor_description` TEXT NOT NULL
);

DROP TABLE IF EXISTS `doctor_pictures`;
CREATE TABLE IF NOT EXISTS `doctor_pictures` (
    `id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`id`),
    `pathImg` VARCHAR(255) NOT NULL,
    `doctor_id` INT,
    FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`)
);

DROP TABLE IF EXISTS `doctors_products`;
CREATE TABLE IF NOT EXISTS `doctors_products` (
    `doctor_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
);
```
```sql
--
-- INSERTION DES DONNEES
--

INSERT INTO 
`nav_category` (`nav_name`) 
VALUES
('navbar'),
('footernav');

INSERT INTO
`pages` (`page_title`, `page_meta_desc`, `page_meta_keywords`, `page_url`, `page_bodyId`, `nav_category_id`)
VALUES
('Accueil', 'Description SEO de ma page d''accueil', 'homekey1, homekey2, homekey3, homekey4', '/', 'home', 1),
('Produits', 'Description SEO de ma page produits', 'product1, product2, product3, product4', '/produits.php', 'products', 1),
('Contact', 'Description SEO de ma page contact', 'contact1, contact2, contact3, contact4', '/contact.php', 'contact', 1),
('Mentions légales', 'Mentions légales du site', 'legal1, legal2, legal3, legal4', '/mentions-legales.php', 'legal', 2),
('Conditions générales', 'Conditions générales du site', 'cgu1, cgu2, cgu3, cgu4', '/cgu.php', 'cgu', 2),
('Politique de confidentialités', 'Politique de confidentialités du site', 'privacy1, privacy2, privacy3, privacy4', '/vie-privee.php', 'privacy', 2);

INSERT INTO 
`section_category` (`section_category_name`) 
VALUES
('home'),
('contact');

INSERT INTO 
`sections` (`section_title`, `section_description`, `section_category_id`) 
VALUES
('Présentation', 'Bienvenue au laboratoire pharmaceutique Wonderland Pharma, un établissement unique où la science et la magie se rencontrent pour créer des médicaments extraordinaires. Notre équipe dévouée de chercheurs et d''alchimistes travaille sans relâche pour développer des formulations révolutionnaires qui permettent à nos clients de changer de taille, de couleur, ou même d''acquérir des pouvoirs magiques. Inspiré par l''univers fantastique de Lewis Carroll, notre laboratoire est déterminé à repousser les limites de la réalité et à offrir des expériences pharmacologiques inédites. Que vous cherchiez à explorer de nouveaux horizons dimensionnels ou à embrasser votre côté fantastique, notre gamme de produits innovants est conçue pour émerveiller et surprendre. Rejoignez-nous dans cette aventure extraordinaire où la science et la magie convergent pour créer des solutions pharmaceutiques uniques au pays des rêves et de l''émerveillement.', '1'),
('Contactez-nous', 'Vous avez des questions, n''hésitez pas à nous contacter nous nous ferons un plaisir de vous aider.', '2');

INSERT INTO
`product_category` (`category_name`)
VALUES
('Comprimés magiques'),
('Concoctions fantastiques'),
('Saveurs enchantées');

INSERT INTO
`products` (`product_title`, `product_description`, `product_price`, `product_category_id`)
VALUES 
('Drink Me', 'Une potion qui vous fait rétrécir ou grandir selon la quantité que vous buvez. Attention à ne pas en abuser !', 9.99, 2),
('Eat Me', 'Un gâteau qui vous fait changer de taille selon la part que vous mangez. Idéal pour explorer des endroits inaccessibles !', 12.99, 3),
('Upelkuchen', 'Un biscuit qui vous fait changer de couleur selon la saveur que vous choisissez. Parfait pour vous camoufler ou vous amuser !', 14.99, 3),
('Jabberwocky Blood', 'Un élixir qui vous donne des pouvoirs magiques pendant une courte durée. Utilisez-le avec prudence !', 19.99, 2),
('Outlandish', 'Une pilule qui vous fait changer de personnalité selon l''humeur que vous souhaitez. Idéale pour vous évader ou vous surprendre !', 16.99, 1),
('Rose me', 'Un gâteau qui vous transforme en une rose rouge. Vous pouvez ainsi embellir le jardin de la Reine de cœur, mais attention à ne pas vous faire couper !', 11.99, 3),
('Chess me', 'Un médicament qui vous fait entrer dans le jeu d''échecs vivant. Vous pouvez ainsi devenir un pion, un fou, une tour, un cavalier, un roi ou une reine, mais attention à ne pas vous faire échec et mat !', 6.99, 1),
('Wonderland Tea', 'Un thé qui vous transporte dans le monde merveilleux d''Alice. Attention, vous ne contrôlez pas le temps ni le lieu de votre retour !', 24.99, 3);

INSERT INTO `product_pictures` (`pathImg`, `product_id`) VALUES
('drink_me.webp', 1),
('eat_me.webp', 2),
('upelkuchen.webp', 3),
('jabberwocky_Blood.webp', 4),
('outlandish.webp', 5),
('rose_me.webp', 6),
('chess_me.webp', 7),
('wonderland_Tea.webp', 8);

INSERT INTO
`doctors` (`doctor_name`, `doctor_description`)
VALUES 
('Alice', 'Dr. Alice Kingsleigh, médecin renommée du pays des merveilles, apporte sa magie à la médecine moderne. Forte de son expérience dans des mondes fantastiques, elle assure la qualité des médicaments disponibles sur notre site. Sa combinaison unique de rigueur scientifique et de créativité offre des solutions novatrices pour le bien-être de tous. Faites confiance au Dr. Alice Kingsleigh pour des conseils médicaux exceptionnels au-delà de l''ordinaire.'),
('Chapelier Fou', 'Le Chapelier Fou, expert excentrique en potions et remèdes du pays des merveilles, apporte une touche de folie à la médecine. Sa créativité débordante et sa compréhension unique des ingrédients inhabituels font de lui une figure clé dans le domaine pharmaceutique. En naviguant à travers des réalités fantaisistes, le Chapelier Fou propose des solutions médicales hors du commun pour favoriser le bien-être de chacun. Sa folie maîtrisée et son savoir atypique font de lui un allié surprenant et fiable dans la recherche de conseils médicaux singuliers et innovants.'),
('La Chenille', 'La Chenille, experte énigmatique du pays des merveilles, offre une perspective unique en tant que conseillère médicale. Sa sagesse transcendantale et son approche contemplative se reflètent dans la sélection minutieuse des produits pharmaceutiques sur notre site. La Chenille, avec son regard perspicace et son penchant pour les remèdes naturels, incarne une approche holistique de la santé. Confiez-vous à la guidance exceptionnelle de la Chenille pour des conseils médicaux uniques et apaisants.'),
('Tweedledum et Tweedledee', 'Tweedledum et Tweedledee, experts du bien-être au pays des merveilles, ajoutent une touche ludique à la médecine. Ces jumeaux énergiques apportent une perspective unique, mêlant fantaisie et soins de santé. Leurs conseils, bien que farfelus, sont empreints d''une jovialité contagieuse. En tant que figures clés sur notre site de vente de médicaments, Tweedledum et Tweedledee incarnent l''harmonie entre la santé et la joie. Optez pour leur approche décalée pour une expérience médicale inédite et réjouissante.');

INSERT INTO `doctor_pictures` (`pathImg`, `doctor_id`) VALUES
('alice-doctor.webp', 1),
('madhatter-doctor.webp', 2),
('caterpillar-doctor.webp', 3),
('twins-doctor.webp', 4);

INSERT INTO `doctors_products` (`doctor_id`, `product_id`) VALUES
(1, 1),
(1, 2),
(3, 3),
(2, 4),
(4, 5),
(3, 6),
(2, 7),
(4, 8);
```
