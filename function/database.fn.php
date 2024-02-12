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
