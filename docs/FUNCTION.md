# Fonctions du site dbbrief_med

## database.fn.php

```php
function getPDOlink($config)
{
    // Construction du DSN (Data Source Name) pour la connexion à la base de données.
    // Le DSN comprend le type de base de données (mysql), le nom de la base de données, l'hôte et le port.
    $dsn = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['dbhost'] . ';port=' . $config['dbport'] . ';charset=' . $config['dbchar'];

    // Tentative de connexion à la base de données en utilisant l'objet PDO (PHP Data Objects).
    try {
        // Création d'une nouvelle instance de l'objet PDO avec le DSN et les informations d'authentification.
        $db = new PDO($dsn, $config['dbuser'], $config['dbpass']);

        // Définition du mode de récupération par défaut pour les requêtes.
        // PDO::FETCH_ASSOC signifie que les résultats seront retournés sous forme de tableau associatif.
        // Cela évite d'avoir des doublons dans les résultats (les colonnes ne sont pas retournées à la fois comme des indices numériques et des noms de colonnes).
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Retour de l'objet PDO qui représente la connexion à la base de données.
        return $db;
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, on utilise l'objet PDOException pour récupérer et afficher le message d'erreur.
        exit('Erreur de connexion à la base de données : ' . $e->getMessage());
    }
}
```

1. **Construction du DSN** : Le DSN (Data Source Name) est une chaîne qui contient les informations nécessaires pour se connecter à la base de données. Dans notre cas, il comprend le type de base de données (mysql), le nom de la base de données, l'hôte, le port et le jeu de caractères UTF8.
2. **Tentative de connexion à la base de données** : On essaie de se connecter à la base de données en utilisant l'objet PDO (PHP Data Objects). PDO est une extension de PHP qui fournit une interface pour accéder aux bases de données en PHP.
3. **Création d'une nouvelle instance de l'objet PDO** : On crée une nouvelle instance de l'objet PDO avec le DSN et les informations d'authentification (nom d'utilisateur et mot de passe).
4. **Définition du mode de récupération par défaut pour les requêtes** : On définit le mode de récupération par défaut pour les requêtes sur PDO::FETCH_ASSOC. Cela signifie que les résultats des requêtes seront retournés sous forme de tableau associatif. Cela évite d'avoir des doublons dans les résultats (les colonnes ne sont pas retournées à la fois comme des indices numériques et des noms de colonnes).
5. **Retour de l'objet PDO** : `TRY` si tout se passe bien, la fonction retourne l'objet PDO qui représente la connexion à la base de données.
6. **Gestion des erreurs** : `CATCH` si une erreur se produit lors de la connexion à la base de données, on attrape l'exception PDOException et on affiche le message d'erreur.

> [!NOTE]
> Les informations du DSN sont récupérés dans le fichier de configuration `/config/database.cfg.php`.  
> Le `try-catch` est une structure de contrôle d'erreur en programmation qui permet de `tenter (try)` un bloc de code et de `capturer (catch)` les erreurs qui peuvent survenir lors de l'exécution de ce bloc.

## frontend.fn.php

### displaySection($db, $sectionCategory)

Fonction qui récupère les informations sur une section spécifique dans la table `sections` de la base de données et affiche cette section. Si la section n'existe pas, elle affiche un message d'erreur.

Ceci nous permettra de créer autant de section générique que nous le souhaitons.

Dans la fonction `displaySection(param1, param2)`, on passe en premier paramètre la connexion à la bdd, et en second la catégorie de section. Dans notre exemple ci-dessous il s'agit de `home` qui correspond à la page d'accueil. Nous avons également la même chose pour la page `contact.php` en choisissant la catégorie `contact`. Ensuite la fonction retourne le titre et la description lié à la catégorie choisie.

```php
<?php displaySection($db, 'home'); ?>
```
**Fonction :**  

```php
// Fonction qui affiche une section
function displaySection($db, $sectionCategory)
{
    // Prépare la requête SQL
    $sql = "SELECT sections.* FROM sections 
    INNER JOIN section_category ON sections.section_category_id = section_category.id
    WHERE section_category.section_category_name = :category";

    // Prépare la requête SQL pour l'exécution.
    $sth = $db->prepare($sql);

    // Lie la valeur de $sectionCategory au paramètre nommé dans la requête SQL
    $sth->bindParam(':category', $sectionCategory);

    // Exécute la requête SQL.
    $sth->execute();

    // Récupère tous les résultats de la requête SQL et les stockes dans $games.
    $sections = $sth->fetchAll();

    // On vérifie si la section principale de la page courante existe.
    if (!empty($sections)) {
        // Si elle existe, on récupère les informations de cette section.
        foreach ($sections as $section) {
            // On affiche la section en utilisant echo. La section est composée d'un titre (h2) et d'un contenu (p).
            // Le titre et le contenu sont récupérés à partir du tableau $section.
            echo '
            <section class="mb-5">
                <h2 class="text-center fs-1 mb-4">' . $section['section_title'] . '</h2>
                <p class="fs-22">' . $section['section_description'] . '</p>
            </section>
            ';
        }
    } else {
        // Si la section n'existe pas, on affiche un message d'erreur.
        echo 'La section n\'existe pas.';
    }
}
```

1. **Préparation de la requête SQL** : On prépare la requête SQL pour récupérer toutes les sections qui correspondent à la catégorie de section spécifiée. Le placeholder `:category` est utilisé pour représenter le **nom de la catégorie** de section.
2. **Liaison des paramètres** : on utilise la méthode `bindParam()` pour lier la valeur de `$sectionCategory` au placeholder `:category` dans la requête SQL.
3. **Exécution de la requête SQL** : On exécute la requête SQL avec la méthode `execute()`.
4. **Récupération des résultats** : On récupére tous les résultats de la requête SQL avec la méthode `fetchAll()` et on les stockes dans la variable `$sections`.
5. **Vérification de l'existence de la section** : on vérifie si la section de la page courante existe en utilisant la fonction `empty()`. Si le tableau `$sections` n'est pas vide, cela signifie que la section existe.
6. **Affichage de la section** : Si la section existe, on parcourt chaque section avec une boucle `foreach`. Pour chaque section, on affiche la section en utilisant `echo`. La section est composée d'un titre `h2` et d'un contenu `p`, qui sont récupérés à partir du tableau `$section`.
7. **Gestion des erreurs** : Si la section n'existe pas (si le tableau `$sections` est **vide**), on affiche un message d'erreur.

**Explication de la requête `$sql`** : 
   
- `SELECT sections.*` : on sélectionne toutes les colonnes `*` de la table `sections`.
- `FROM pages` : nous indiquons que nous commençons par la table `sections`.
- `INNER JOIN nav_category` : on joint la table `section_category` à la table `sections`. Un `INNER JOIN` retourne les lignes où il y a une correspondance dans les 2 tables.
- `ON sections.section_category_id = section_category.id` : on spécifie la condition de jointure. Nous joignons les 2 tables, la colonne `section_category_id` de la table `sections` et la colonne `id` de la table `section_category`.
- `WHERE section_category.section_category_name = :category` : on ajoute une condition à la requête. Seules les lignes où le `section_category_name` de la table `section_category` est égal à la valeur de `:category` (paramètre défini lors de l’exécution de la requête) seront retournées.

### findAllDatas($db, $sql)

Fonction générique qui peut être utilisée pour exécuter n'importe quelle requête SQL qui récupère des données de la base de données, ce qui est très utile pour éviter la répétition du code. Elle prend en entrée une connexion à une base de données `$db` et une requête SQL `$sql`, exécute la requête, récupère tous les résultats et les retourne sous forme de tableau associatif.

Dans la fonction `findAllDatas(param1, param2)`, on passe en premier paramètre la connexion à la bdd, et en second la requête SQL. Dans notre exemple ci-dessous on passe la requête `$doctorsQuery` qui correspond à la requête pour récupérer les données de la base de données pour les cartes docteurs. Ensuite la fonction retourne les valeurs des cartes. À chaque itération de la boucle foreach on génère une carte avec image, nom du docteur, description du docteur.

```php
<?php
// La requête SQL est stockée dans la variable $doctorsQuery puis est passé en paramètre dans fonction displayCards.
$doctorsQuery = "SELECT doctors.* FROM doctors";
$doctors = findAllDatas($db, $doctorsQuery);

foreach ($doctors as $doctor) :
?>
    <div class="col">
        <div class="card h-100 text-center rounded-0">
            <img src="<?= DOCTORS_IMG_PATH . $doctor['doctor_pathimg'] ?>" class="card-img-trounded-0" alt="<?= $doctor['doctor_name'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $doctor['doctor_name'] ?></h5>
                <p class="card-text"><?= $doctor['doctor_description'] ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
```
**Explication de la requête `$doctorsQuery`** :  
  
- `SELECT doctors.*` : on sélectionne toutes les colonnes `*` de la table `doctors`.
- `FROM doctors` : nous indiquons que nous commençons par la table `doctors`.

**Fonction :**  
  
```php
// Fonction qui récupère tous les résultats de la base de données.
function findAllDatas($db, $sql)
{
    // Prépare la requête SQL pour l'exécution.
    // La méthode prepare() est utilisée pour préparer la requête SQL pour l'exécution.
    // Elle retourne un objet PDOStatement qui est stocké dans la variable $sth.
    $sth = $db->prepare($sql);

    // Exécute la requête SQL.
    // La méthode execute() est utilisée pour exécuter la requête SQL préparée.
    $sth->execute();

    // Récupère tous les résultats de la requête SQL et les stocke dans $result.
    // La méthode fetchAll() est utilisée pour récupérer tous les résultats de la requête SQL.
    // Elle retourne un tableau associatif de tous les résultats qui sont stockés dans la variable $result.
    $result = $sth->fetchAll();

    // Retourne les résultats récupérés.
    // La fonction retourne le tableau associatif $result qui contient tous les résultats récupérés de la base de données.
    return $result;
}
```

1. **Préparation de la requête SQL** : On prépare la requête SQL pour l'exécution. La méthode `prepare()` de l'objet PDO `$db` est utilisée pour préparer la requête SQL pour l'exécution. Elle retourne un objet **PDOStatement** qui est stocké dans la variable `$sth`.
2. **Exécution de la requête SQL** : On exécute la requête SQL préparée avec la méthode `execute()` de l'objet **PDOStatement** `$sth`.
3. **Récupération des résultats** : On récupére tous les résultats de la requête SQL avec la méthode `fetchAll()` de l'objet **PDOStatement** (`$sth`). Cette méthode retourne un tableau associatif de tous les résultats qui sont stockés dans la variable `$result`.
4. **Retour des résultats** : La fonction retourne le tableau associatif `$result` qui contient tous les résultats récupérés de la base de données.

### getSortedProducts($db, $orderBy)

La fonction `getSortedProducts` a pour but de récupérer les produits à partir de la base de données, en les triant par prix (soit en ordre croissant, soit en ordre décroissant) en fonction de la préférence de l’utilisateur. Elle prend en entrée une connexion à une base de données `$db` et la préférence de tri `$orderBy` (soit `ASC` pour croissant, soit `DESC` pour décroissant).

```php
// Fonction pour récupérer les produits triés en fonction de la préférence de l'utilisateur
function getSortedProducts($db, $orderBy)
{
    // Construction de la requête SQL pour récupérer les produits avec les noms de catégorie
    $productsQuery = "SELECT products.*, product_category.category_name
                    FROM products
                    INNER JOIN product_category ON products.product_category_id = product_category.id
                    ORDER BY product_price $orderBy";

    // Appel de la fonction findAllDatas pour exécuter la requête et renvoyer les résultats
    return findAllDatas($db, $productsQuery);
}
```
**Explication de la requête `$productsQuery` :**

- `SELECT products.*, product_category.category_name` : on sélectionne toutes les colonnes `*` de la table `products` et la colonne `category_name` de la table `product_category`.
- `FROM products` : nous indiquons que nous commençons par la table `products`.
- `INNER JOIN product_category` : on joint la table `product_category` à la table `products`. Un `INNER JOIN` retourne les lignes où il y a une correspondance dans les 2 tables.
- `ON products.product_category_id = product_category.id` : on spécifie la condition de jointure. Nous joignons les 2 tables entre la colonne `product_category_id` de la table `products` et la colonne `id` de la table `product_category`.
- `ORDER BY product_price $orderBy` : Trie les résultats par prix de produit (soit en ordre croissant, soit en ordre décroissant) en fonction de la préférence de tri spécifiée dans `$orderBy`.

## header.fn.php

Fichier PHP regroupant les fonctions liés au header. (Information de la page, navigation). Il sera inclut dans le `/utilities/layout/header.ut.php` en utilisant la fonction `require_once()`.

### getCurrentScriptPath()

La fonction retourne le chemin du script en cours d'exécution.

```php
// Fonction qui retourne le chemin du script en cours d'exécution.
function getCurrentScriptPath()
{
    return $_SERVER['SCRIPT_NAME'];
}
```

Pour ceci on utilise la **variable superglobale** `$_SERVER` en PHP, qui contient des informations sur les en-têtes, les chemins et les emplacements de script.

La **clé** `SCRIPT_NAME` dans `$_SERVER` contient le chemin du script courant. C'est le chemin de votre script PHP par rapport à la racine du site web. Il commence toujours par un slash (/) et contient le nom du script PHP qui est en cours d'exécution.

**Exemple :**  
Lorsque nous serons sur `http://monsite.com/produit.php`, la fonction `getCurrentScriptPath()` retournera `/produits.php`.

> [!NOTE]
> La création d'une fonction dédié à la récupération du script en cours d'éxecution est judicieux sachant que nous avons besoin de cette information dans nos différents scripts ex: getPageInfo et generateNavLinks.

### getPageInfo($db)

La fonction parcourt toutes les pages stockés dans la table `pages` de la base de données et retourne les informations de la page dont l'URL correspond à l'URL courante. Si aucune page ne correspond à l'URL courante, la fonction ne retourne rien.

**Affichage des informations de la page courante :**  
- Titre de la page (SEO)
- Meta description (SEO)
- Meta keywords (SEO)
- BodyId (id à ajouter au body de la page ex: id="home")

```php
<?php
// Appel de la fonction getPageInfo() pour obtenir les informations relatives à la page dans la base de données
$pageInfo = getPageInfo($db);
?>
<head>
    <title><?= $pageInfo['page_title'] ?></title>
    <meta name="description" content="<?= $pageInfo['page_meta_desc'] ?>">
    <meta name="keywords" content="<?= $pageInfo['page_meta_keywords'] ?>">
</head>

<body id="<?= $pageInfo['page_bodyId'] ?>">
```
**Fonction :**  
  
```php
// Fonction qui retourne les informations de la page correspondant à l'URL courante.
function getPageInfo($db)
{
    // On récupère le chemin du script courant.
    $currentScriptPath = getCurrentScriptPath();

    // Prépare la requête SQL
    $sql = "SELECT page_title, page_meta_desc, page_meta_keywords, page_url, page_bodyId FROM pages";

    // Prépare la requête SQL pour l'exécution.
    $sth = $db->prepare($sql);

    // Exécute la requête SQL.
    $sth->execute();

    // Récupère tous les résultats de la requête SQL et les stockes dans $pages.
    $pages = $sth->fetchAll();

    // On parcourt chaque page dans la section spécifiée.
    foreach ($pages as $page) {
        // On vérifie si l'URL courante est trouvée dans l'URL de la page ou dans l'URL de la page suivie de 'index.php'.
        // Cela permet de gérer le cas où l'utilisateur saisit directement 'index.php' dans son URL.
        if (strpos($page['page_url'], $currentScriptPath) !== false || strpos($page['page_url'] . 'index.php', $currentScriptPath) !== false) {
            // Si une correspondance est trouvée, on retourne les informations de cette page.
            return $page;
        }
    }
}
```

**Description du fonctionnement :**  

1. **Récupération du chemin du script courant** : La fonction `getCurrentScriptPath()` est appelée pour obtenir le chemin du script courant.
2. **Préparation de la requête SQL** : Une requête SQL est préparée pour récupérer toutes les pages de votre base de données.
3. **Exécution de la requête SQL** : La requête SQL est exécutée avec la méthode `execute()`.
4. **Récupération des résultats** : Tous les résultats de la requête SQL sont récupérés avec la méthode `fetchAll()` et stockés dans la variable `$pages`.
5. **Parcours des pages** : Chaque page est parcourue avec une boucle `foreach`. Pour chaque page, on vérifie si l'URL courante est trouvée dans l'URL de la page ou dans l'URL de la page suivie de `index.php`. Si une correspondance est trouvée, la fonction retourne les informations de cette page.

### generateNavLinks($db, $navName)

La fonction génère un tableau de liens de navigation pour une catégorie de navigation spécifiée.

Dans la fonction `generateNavLinks(param1, param2)`, on passe en premier paramètre la connexion à la bdd, et en second la catégorie de navigation choisi. Dans notre exemple ci-dessous il s'agit de `navbar`. Nous avons également la même chose pour le `footer` en choisissant la catégorie footer. Ensuite la fonction retourne les liens liés à la catégorie (titre du lien, url et si on est sur la page active ou non).

```php
<?php
$navbarLinks = generateNavLinks($db, 'navbar');
foreach ($navbarLinks as $key => $value) :
?>
    <li class="nav-item">
        <a href="<?= $value['link_url'] ?>" class="nav-link px-5 text-center text-white <?= $value['link_active'] ?>"><?= $value['link_title'] ?></a>
    </li>
<?php endforeach; ?>
```
**Fonction :**  
  
```php
// La fonction generateNavLinks génère un tableau de liens de navigation pour une catégorie de navigation spécifiée (navbar, footernav ...).
// Chaque lien contient le titre de la page, son URL et une classe CSS indiquant si le lien est actif ou non (basé sur l'URL courante).
function generateNavLinks($db, $navName)
{
    // Obtention du chemin du script courant
    $currentScriptPath = getCurrentScriptPath();

    // Prépare la requête SQL pour récupérer les pages qui correspondent à la catégorie de navigation spécifiée
    $sql = "SELECT pages.*, nav_category.nav_name FROM pages 
    INNER JOIN nav_category ON pages.nav_category_id = nav_category.id
    WHERE nav_category.nav_name = :navName";

    // Prépare la requête SQL pour l'exécution.
    $sth = $db->prepare($sql);

    // Lie la valeur de $navName au paramètre nommé dans la requête SQL
    $sth->bindParam(':navName', $navName);

    // Exécute la requête SQL.
    $sth->execute();

    // Récupère tous les résultats de la requête SQL et les stockes dans $games.
    $pages = $sth->fetchAll();

    // On parcourt chaque page dans la section spécifiée.
    foreach ($pages as $page) {
        // On vérifie si l'URL courante est trouvée dans l'URL de la page ou dans l'URL de la page suivie de 'index.php'.
        // Cela permet de gérer le cas où l'utilisateur saisit directement 'index.php' dans son URL.
        if (strpos($page['page_url'], $currentScriptPath) !== false || strpos($page['page_url'] . 'index.php', $currentScriptPath) !== false) {
            // Si une correspondance est trouvée, on retourne les informations de cette page.
            $activeLink = 'active';
        } else {
            // Sinon, le lien n'est pas actif tu n'ajoutes rien
            $activeLink = '';
        }

        // Ajout d'un nouveau tableau associatif au tableau des liens de navigation
        // Ce tableau contient le titre du lien, l'URL du lien et l'état actif du lien
        $navLinks[] = [
            'link_title' => $page['page_title'],
            'link_url' => $page['page_url'],
            'link_active' => $activeLink
        ];
    }

    // Retour du tableau des liens de navigation
    return $navLinks;
}

```

**Description du fonctionnement :**

1. **Obtention du chemin du script courant** : La fonction `getCurrentScriptPath()` est appelée pour obtenir le chemin du script courant.
2. **Préparation de la requête SQL** : Une requête SQL est préparée pour récupérer les pages qui correspondent à la catégorie de navigation spécifiée. Le placeholder `:navName` est utilisé pour représenter le nom de la catégorie de navigation.
3. **Liaison des paramètres** : La méthode `bindParam()` est utilisée pour lier la valeur de `$navName` au placeholder `:navName` dans la requête SQL.
4. **Exécution de la requête SQL** : La requête SQL est exécutée avec la méthode `execute()`.
5. **Récupération des résultats** : Tous les résultats de la requête SQL sont récupérés avec la méthode `fetchAll()` et stockés dans la variable `$pages`.
6. **Parcours des pages** : Chaque page est parcourue avec une boucle `foreach`. Pour chaque page, on vérifie si l'URL courante est trouvée dans l'URL de la page ou dans l'URL de la page suivie de `index.php`. Si une correspondance est trouvée, la variable `$activeLink` est définie sur `active`. Sinon, `$activeLink` est définie sur `""`.
7. **Ajout d'un nouveau tableau associatif au tableau des liens de navigation** : Un nouveau tableau associatif est ajouté au tableau `$navLinks`. Ce tableau contient le titre du lien `(link_title)`, l'URL du lien `(link_url)` et l'état actif du lien `(link_active)`.
8. **Retour du tableau des liens de navigation** : Enfin, le tableau `$navLinks` est renvoyé par la fonction.

**Explication de la requête `$sql`** : 
   
- `SELECT pages.*, nav_category.nav_name` : on sélectionne toutes les colonnes `*` de la table `pages` et la colonne `nav_name` de la table `nav_category`.
- `FROM pages` : nous indiquons que nous commençons par la table `pages`.
- `INNER JOIN nav_category` : on joint la table `nav_category` à la table `pages`. Un `INNER JOIN` retourne les lignes où il y a une correspondance dans les 2 tables.
- `ON pages.nav_category_id = nav_category.id` : on spécifie la condition de jointure. Nous joignons les 2 tables, la colonne `nav_category_id` de la table `pages` et la colonne `id` de la table `nav_category`.
- `WHERE nav_category.nav_name = :navName` : on ajoute une condition à la requête. Seules les lignes où le `nav_name` de la table `nav_category` est égal à la valeur de `:navName` (paramètre défini lors de l’exécution de la requête) seront retournées.

> [!NOTE]
> **Pourquoi nous utilisons `$navLinks[]` au lieu de `$navLinks`** :  
>   
> `$navLinks[]` est utilisé pour ajouter un nouvel élément à la fin du tableau `$navLinks`. Chaque fois que vous utilisez `$navLinks[] = ...`, vous ajoutez un nouvel élément au tableau.  
> Si on utilise simplement `$navLinks = ...`, on écrase le tableau `$navLinks` à chaque itération de la boucle, et à la fin, `$navLinks` ne contiendrait que le dernier élément ajouté.
>
> **Placeholder** (ou espace réservé en français) est un terme utilisé en programmation pour désigner un emplacement qui doit être remplacé par des données réelles à un moment donné dans notre cas ce sera `:navName`. Dans notre requête SQL préparée elle indique l'endroit ou une valeur doit être insérée.
>
> **Statement Handle** `$sth` : Il s'agit d'un objet qui représente une requête SQL préparée, une fois la requête exécutée, le jeu de résultats associé.
>  
> **`pages.*`** : on sélectionne toutes les colonnes de la table `pages` uniquement et `nav_category.nav_name`. Si on avait uniquement utilisé `*` on aurait également sélectionner toutes les tables de `nav_category.nav_name`.

#### Fonction `strpos()`

`strpos()` est une fonction intégrée en PHP qui est utilisée pour trouver la position de la première occurrence d'une sous-chaîne dans une chaîne. Elle renvoie la position en tant que **nombre entier** ou **false** si la sous-chaîne n'est pas trouvée.
```php
if (strpos($page['page_url'], $currentScriptPath) !== false || strpos($page['page_url'] . 'index.php', $currentScriptPath) !== false)
```
`strpos($page['page_url'], $currentScriptPath)` cherche l'URL courante `$currentScriptPath` dans l'URL de la page `$page['page_url']`. Si l'URL courante est trouvée dans l'URL de la page, `strpos()` renvoie la position de la première occurrence de l'URL courante dans l'URL de la page. Sinon, elle renvoie **false**.

La seconde partie, `strpos($page['page_url'] . 'index.php', $currentScriptPath)`, fait la même chose, mais elle ajoute `index.php` à l'URL de la page avant de chercher l'URL courante. Cela permet de gérer le cas où l'utilisateur saisit directement `index.php` dans son URL.

> [!IMPORTANT]
> En utilisant `!==` `false` avec la fonction `strpos()`, on s'assure de bien distinguer 2 cas :  
> Quand une sous-chaîne est trouvée au tout début d'une chaîne (cela renvoie `0`) et quand elle n'est pas trouvée du tout (cela renvoie `false`). Si on utilisait `!=` `false`, ces deux cas seraient confondus car `0` est considéré comme `false`.

#### Les requêtes préparées

1. **Préparation avec prepare** : La méthode `prepare` est utilisée pour préparer une requête SQL pour l'exécution. Elle prend une instruction SQL en entrée et retourne un objet `PDOStatement`. Cette méthode est utilisée pour prévenir les injections SQL, car elle sépare l'instruction SQL de ses donnée
2. **Compilation** : En PHP et SQL, la **compilation** fait référence à la préparation de la requête SQL par le serveur de base de données. Lorsque vous utilisez `prepare`, le serveur de base de données vérifie la syntaxe de la requête SQL et la compile en un format interne qu'il peut exécuter plus tard. Cette étape est généralement transparente pour le développeur PHP.
3. **Liaison avec bindParam** : La méthode `bindParam` de PHP est utilisée pour lier une variable PHP à un paramètre de marqueur correspondant dans une requête SQL préparée. Cette méthode est généralement utilisée pour insérer, mettre à jour ou filtrer les données dans une base de données.
4. **Exécution avec execute** : La méthode `execute` est utilisée pour exécuter la requête SQL préparée. Pour les instructions SELECT `execute` retourne un nouvel objet `PDOStatement` qui peut être utilisé pour récupérer les résultats.

**Pourquoi utiliser des requêtes préparées ?**

1. **Sécurité** : Les requêtes préparées aident à prévenir les injections SQL, qui sont une vulnérabilité de sécurité courante. Même si votre requête actuelle ne contient pas de paramètres, utiliser des requêtes préparées est une bonne habitude à prendre.
2. **Performance** : Si vous exécutez la même requête plusieurs fois avec des valeurs de paramètres différentes, l'utilisation de requêtes préparées peut améliorer les performances. Le serveur de base de données n'a besoin de parser et de compiler la requête qu'une seule fois, et peut ensuite la réutiliser avec différentes valeurs de paramètres.
3. **Lisibilité et maintenabilité** : Les requêtes préparées peuvent rendre votre code plus lisible et plus facile à maintenir, surtout si vous avez une requête complexe avec de nombreux paramètres.

Mais dans notre cas l'intérêt sachant que certaines requêtes vont êtres appelées et exécutées à plusieurs reprises, les requêtes préparées peuvent améliorer l'efficacité du cache de requêtes du serveur SQL, cela diminuera la charge sur la base de données. Ce qui en matière de performance n'est pas négligeable.