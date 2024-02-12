# La base de données dbbrief_med

Réalisé sans outils à la main en se basant sur le schéma UML réalisé avec Draw.io.

1. **nav_category** : Cette table stocke les informations sur les différentes catégories de navigation. Chaque catégorie a un `id` unique (PK) et un `nav_name`.
2. **pages** : Cette table stocke les informations sur les différentes pages du site. Chaque page a un `id` unique, un `page_title`, un `page_meta_desc`, un `page_meta_keywords`, un `page_url`, un `page_bodyId` et un `nav_category_id` qui est une clé étrangère (FK) faisant référence à l'`id` dans la table `nav_category`.
3. **section_category** : Cette table stocke les informations sur les différentes catégories de sections. Chaque catégorie de section a un `id` unique (PK) et un `section_category_name`.
4. **sections** : Cette table stocke les informations sur les différentes sections du site. Chaque section a un `id` unique (PK), un `section_title`, un `section_description` et un `section_category_id` qui est une clé étrangère (FK) faisant référence à l'`id` dans la table `section_category`.
5. **product_category** : Cette table stocke les informations sur les différentes catégories de produits. Chaque catégorie de produit a un `id` unique (PK) et un `category_name`.
6. **products** : Cette table stocke les informations sur les différents produits. Chaque produit a un `id` unique (PK), un `product_title`, un `product_description`, un `product_price`, un `product_pathimg` et un `product_category_id` qui est une clé étrangère (FK) faisant référence à l'`id` dans la table `product_category`.
7. **doctors** : Cette table stocke les informations sur les différents médecins. Chaque médecin a un `id` unique (PK), un `doctor_name`, un `doctor_description` et un `doctor_pathimg`.

## Schéma UML

![Schéma UML dbbrief_med](../docs/uml/export/dbbrief_med-uml.svg)

**Détails des relations entre les tables** :

1. **Pages et Catégories de Navigation (Many-to-One)**:
  - La table `pages` a une relation **Many-to-One** avec la table `nav_category`. Cela signifie que plusieurs pages peuvent être associées à une seule catégorie de navigation `nav_category`. La clé étrangère `nav_category_id` dans la table `pages` référence la clé primaire `id` de la table `nav_category`.
2. **Sections et Catégories de Section (One-to-Many)**:
  - La table `sections` a une relation **One-to-Many** avec la table `section_category`. Cela signifie qu’une catégorie de section `section_category` peut être associée à plusieurs sections. La clé étrangère `section_category_id` dans la table `sections` référence la clé primaire `id` de la table `section_category`.
3. **Produits et Catégories de Produits (One-to-Many)**:
  - La table `products` a également une relation **One-to-Many** avec la table `product_category`. Une catégorie de produit `product_category` peut contenir plusieurs produits. La clé étrangère `product_category_id` dans la table `products` référence la clé primaire `id` de la table `product_category`.

> [!NOTE]
> PK (Primary Key) : La clé primaire permet d’identifier chaque enregistrement dans une table de base de données.  
> FK (Foreign Key) : La clé étrangère fait référence à la clé primaire d’une autre table, elle permet de mettre en relation les différentes tables de la BDD.

## Requête SQL création de la base de données

```sql
CREATE DATABASE dbbrief_med;

USE dbbrief_med;

CREATE TABLE nav_category (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    nav_name VARCHAR(100) NOT NULL
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    page_title VARCHAR(110) NOT NULL,
    page_meta_desc TEXT,
    page_meta_keywords TEXT,
    page_url VARCHAR(255) NOT NULL,
    page_bodyId VARCHAR(110),
    nav_category_id INT NOT NULL,
    FOREIGN KEY (nav_category_id) REFERENCES nav_category (id)
);

CREATE TABLE section_category (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    section_category_name VARCHAR(100) NOT NULL
);

CREATE TABLE sections (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    section_title VARCHAR(110) NOT NULL,
    section_description TEXT NOT NULL,
    section_category_id INT NOT NULL,
    FOREIGN KEY (section_category_id) REFERENCES section_category (id)
);

CREATE TABLE product_category (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    category_name VARCHAR(110) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    product_title VARCHAR(110) NOT NULL,
    product_description TEXT NOT NULL,
    product_price FLOAT NOT NULL,
    product_pathimg VARCHAR(110) NOT NULL,
    product_category_id INT NOT NULL,
    FOREIGN KEY (product_category_id) REFERENCES product_category (id)
);

CREATE TABLE doctors (
    id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (id),
    doctor_name VARCHAR(110) NOT NULL,
    doctor_description TEXT NOT NULL,
    doctor_pathimg VARCHAR(110) NOT NULL
);

INSERT INTO
nav_category (nav_name)
VALUES
('navbar'),
('footernav');

INSERT INTO
pages (page_title, page_meta_desc, page_meta_keywords, page_url, page_bodyId, nav_category_id)
VALUES
('Accueil', 'Description SEO de ma page d''accueil', 'homekey1, homekey2, homekey3, homekey4', '/', 'home', 1),
('Produits', 'Description SEO de ma page produits', 'product1, product2, product3, product4', '/produits.php', 'products', 1),
('Contact', 'Description SEO de ma page contact', 'contact1, contact2, contact3, contact4', '/contact.php', 'contact', 1),
('Mentions légales', 'Mentions légales du site', 'legal1, legal2, legal3, legal4', '/mentions-legales.php', 'legal', 2),
('Conditions générales', 'Conditions générales du site', 'cgu1, cgu2, cgu3, cgu4', '/cgu.php', 'cgu', 2),
('Politique de confidentialités', 'Politique de confidentialités du site', 'privacy1, privacy2, privacy3, privacy4', '/vie-privee.php', 'privacy', 2);

INSERT INTO section_category (section_category_name) VALUES
('home'),
('contact');

INSERT INTO sections (section_title, section_description, section_category_id) VALUES
('Présentation', 'Bienvenue au laboratoire pharmaceutique Wonderland Pharma, un établissement unique où la science et la magie se rencontrent pour créer des médicaments extraordinaires. Notre équipe dévouée de chercheurs et d''alchimistes travaille sans relâche pour développer des formulations révolutionnaires qui permettent à nos clients de changer de taille, de couleur, ou même d''acquérir des pouvoirs magiques. Inspiré par l''univers fantastique de Lewis Carroll, notre laboratoire est déterminé à repousser les limites de la réalité et à offrir des expériences pharmacologiques inédites. Que vous cherchiez à explorer de nouveaux horizons dimensionnels ou à embrasser votre côté fantastique, notre gamme de produits innovants est conçue pour émerveiller et surprendre. Rejoignez-nous dans cette aventure extraordinaire où la science et la magie convergent pour créer des solutions pharmaceutiques uniques au pays des rêves et de l''émerveillement.', '1'),
('Contactez-nous', 'Vous avez des questions, n''hésitez pas à nous contacter nous nous ferons un plaisir de vous aider.', '2');

INSERT INTO
product_category (category_name)
VALUES
('Comprimés magiques'),
('Concoctions fantastiques'),
('Saveurs enchantées');

INSERT INTO
products (product_title, product_description, product_pathimg, product_price, product_category_id)
VALUES 
('Drink Me', 'Une potion qui vous fait rétrécir ou grandir selon la quantité que vous buvez. Attention à ne pas en abuser !', 'drink_me.webp', 9.99, 2),
('Eat Me', 'Un gâteau qui vous fait changer de taille selon la part que vous mangez. Idéal pour explorer des endroits inaccessibles !', 'eat_me.webp', 12.99, 3),
('Upelkuchen', 'Un biscuit qui vous fait changer de couleur selon la saveur que vous choisissez. Parfait pour vous camoufler ou vous amuser !', 'upelkuchen.webp', 14.99, 3),
('Jabberwocky Blood', 'Un élixir qui vous donne des pouvoirs magiques pendant une courte durée. Utilisez-le avec prudence !', 'jabberwocky_Blood.webp', 19.99, 2),
('Outlandish', 'Une pilule qui vous fait changer de personnalité selon l'humeur que vous souhaitez. Idéale pour vous évader ou vous surprendre !', 'outlandish.webp', 16.99, 1),
('Rose me', 'Un gâteau qui vous transforme en une rose rouge. Vous pouvez ainsi embellir le jardin de la Reine de cœur, mais attention à ne pas vous faire couper !', 'rose_me.webp', 11.99, 3),
('Chess me', 'Un médicament qui vous fait entrer dans le jeu d'échecs vivant. Vous pouvez ainsi devenir un pion, un fou, une tour, un cavalier, un roi ou une reine, mais attention à ne pas vous faire échec et mat !', 'chess_me.webp', 6.99, 1),
('Wonderland Tea', 'Un thé qui vous transporte dans le monde merveilleux d'Alice. Attention, vous ne contrôlez pas le temps ni le lieu de votre retour !', 'wonderland_Tea.webp', 24.99, 3);

INSERT INTO
doctors (doctor_name, doctor_description, doctor_pathimg)
VALUES 
('Alice', 'Dr. Alice Kingsleigh, médecin renommée du pays des merveilles, apporte sa magie à la médecine moderne. Forte de son expérience dans des mondes fantastiques, elle assure la qualité des médicaments disponibles sur notre site. Sa combinaison unique de rigueur scientifique et de créativité offre des solutions novatrices pour le bien-être de tous. Faites confiance au Dr. Alice Kingsleigh pour des conseils médicaux exceptionnels au-delà de l''ordinaire.', 'alice-doctor.webp'),
('Chapelier Fou', 'Le Chapelier Fou, expert excentrique en potions et remèdes du pays des merveilles, apporte une touche de folie à la médecine. Sa créativité débordante et sa compréhension unique des ingrédients inhabituels font de lui une figure clé dans le domaine pharmaceutique. En naviguant à travers des réalités fantaisistes, le Chapelier Fou propose des solutions médicales hors du commun pour favoriser le bien-être de chacun. Sa folie maîtrisée et son savoir atypique font de lui un allié surprenant et fiable dans la recherche de conseils médicaux singuliers et innovants.', 'madhatter-doctor.webp'),
('La Chenille', 'La Chenille, experte énigmatique du pays des merveilles, offre une perspective unique en tant que conseillère médicale. Sa sagesse transcendantale et son approche contemplative se reflètent dans la sélection minutieuse des produits pharmaceutiques sur notre site. La Chenille, avec son regard perspicace et son penchant pour les remèdes naturels, incarne une approche holistique de la santé. Confiez-vous à la guidance exceptionnelle de la Chenille pour des conseils médicaux uniques et apaisants.', 'caterpillar-doctor.webp'),
('Tweedledum et Tweedledee', 'Tweedledum et Tweedledee, experts du bien-être au pays des merveilles, ajoutent une touche ludique à la médecine. Ces jumeaux énergiques apportent une perspective unique, mêlant fantaisie et soins de santé. Leurs conseils, bien que farfelus, sont empreints d''une jovialité contagieuse. En tant que figures clés sur notre site de vente de médicaments, Tweedledum et Tweedledee incarnent l''harmonie entre la santé et la joie. Optez pour leur approche décalée pour une expérience médicale inédite et réjouissante.', 'twins-doctor.webp');
```