<?php

// Cette fonction établit une connexion à la base de données en utilisant les informations de configuration fournies.
// Le paramètre $config est un tableau associatif qui contient les informations de connexion à la base de données.
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

// Fonction qui exécute une requête SQL préparée avec des paramètres liés.
function executeQuery($db, $sql, $params)
{
    try {

        // Préparation de la requête SQL pour l'exécution.
        // $db est l'objet de la base de données, et $sql est la chaîne de la requête SQL.
        // La méthode prepare() renvoie un objet 'statement' ($sth) qui peut être utilisé pour exécuter la requête.
        $sth = $db->prepare($sql);
        
        // Parcours de chaque paramètre dans le tableau $params.
        foreach ($params as $param => $value) {
            // Liaison du paramètre à la requête SQL
            $sth->bindParam($param, $value);
        }
        
        // Execute la requête préparée
        $sth->execute();
        
        // Retourne l'objet 'statement' ($sth) si la requête a réussi.
        return $sth;

    } catch (PDOException $e) {
        // Affiche le message d'erreur à l'utilisateur
        echo "Erreur lors de l'ajout du produit : " . $e->getMessage();

        // Retourne false si une erreur s'est produite.
        return false;
    }
}