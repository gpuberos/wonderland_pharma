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
    $results = $sth->fetchAll();

    // Retourne les résultats récupérés.
    // La fonction retourne le tableau associatif $result qui contient tous les résultats récupérés de la base de données.
    return $results;
}

// Fonction qui récupère un produit spécifique de la base de données en utilisant son ID.
function findDataById($db, $sql, $currentId)
{
    try {
        // Prépare la requête SQL pour l'exécution.
        $sth = $db->prepare($sql);

        // Lie le paramètre à la requête SQL.
        $sth->bindParam(':current_id', $currentId, PDO::PARAM_INT);

        // Exécute la requête SQL.
        $sth->execute();

        // Récupère le résultat de la requête SQL et le stocke dans $game.
        $result = $sth->fetch();

        // Retourne le jeu récupéré.
        return $result;
    } catch (PDOException $e) {
        // Affiche le message d'erreur à l'utilisateur
        echo "Erreur lors de la recherche des données : " . $e->getMessage();
        // Retourne false si une erreur s'est produite.
        return false;
    }
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
        // Le & avant $value signifie que nous passons $value par référence. 
        // Cela signifie que nous donnons à la fonction un lien vers la variable originale, et non une copie de sa valeur.
        foreach ($params as $param => &$value) {
            // Liaison du paramètre à la requête SQL
            $sth->bindParam($param, $value);
        }

        // Execute la requête préparée
        $sth->execute();

        // Retourne l'objet 'statement' ($sth) si la requête a réussi.
        return $sth;
    } catch (PDOException $e) {
        // Affiche le message d'erreur à l'utilisateur
        echo "Erreur : " . $e->getMessage();

        // Retourne false si une erreur s'est produite.
        return false;
    }
}

function updateProduct($db, $id, $data)
{
    // Commencer la transaction
    $db->beginTransaction();

    // Prépare la requête SQL pour mettre à jour le produit
    $sql = "UPDATE products SET 
            product_name = :product_name, 
            product_description = :product_description, 
            product_price = :product_price,
            product_category_id = :product_category_id
            WHERE id = :product_id";

    $params = [
        ':product_name' => isset($data['product_name']) ? $data['product_name'] : null,
        ':product_description' => isset($data['product_description']) ? $data['product_description'] : null,
        ':product_price' => isset($data['product_price']) ? $data['product_price'] : null,
        ':product_category_id' => isset($data['product_category_id']) ? $data['product_category_id'] : null,
        ':product_id' => $id
    ];

    // Exécute la requête SQL
    $result = executeQuery($db, $sql, $params);
    if ($result === false) {
        echo "Erreur lors de la mise à jour du produit.";
        $db->rollBack();
        return false;
    }

    // Si 'product_path_img' est présent dans les données, mettez à jour l'image du produit
    if (isset($data['product_path_img'])) {
        $sql = "UPDATE product_pictures SET product_path_img = :product_path_img WHERE product_id = :product_id";
        $params = [
            ':product_path_img' => $data['product_path_img'],
            ':product_id' => $id
        ];

        // Exécute la requête SQL
        $result = executeQuery($db, $sql, $params);
        if ($result === false) {
            echo "Erreur lors de la mise à jour de l'image du produit.";
            $db->rollBack();
            return false;
        }
    }

    // Si 'doctor_id' est présent dans les données, mettez à jour le 'doctor_id' du produit
    if (isset($data['doctor_id'])) {
        $sql = "UPDATE doctors_products SET doctor_id = :doctor_id WHERE product_id = :product_id";
        $params = [
            ':doctor_id' => $data['doctor_id'],
            ':product_id' => $id
        ];

        // Exécute la requête SQL
        $result = executeQuery($db, $sql, $params);
        if ($result === false) {
            echo "Erreur lors de la mise à jour du médecin associé.";
            $db->rollBack();
            return false;
        }
    }

    // Si tout se passe bien, valider la transaction
    $db->commit();

    return true;
}

function deleteProduct($db, $id)
{
    try {
        // Commencer la transaction
        $db->beginTransaction();

        // Retourne le product_path_img
        $ImagePathSql = "SELECT 
                    product_pictures.product_path_img 
                    FROM products 
                    INNER JOIN product_pictures ON products.id = product_pictures.product_id
                    WHERE products.id = :current_id";
        $ImagePath = findDataById($db, $ImagePathSql, $id);

        // Supprimer d'abord les entrées dans la table product_pictures associées au produit
        $sqlDeletePictures = "DELETE FROM product_pictures WHERE product_id = :product_id";
        $params = [':product_id' => $id];
        $result = executeQuery($db, $sqlDeletePictures, $params);
        if ($result === false) {
            // Annulation de la transaction
            $db->rollBack();
            return;
        }

        // Ensuite, supprimer les associations dans la table doctors_products
        $sqlDeleteAssociations = "DELETE FROM doctors_products WHERE product_id = :product_id";
        $result = executeQuery($db, $sqlDeleteAssociations, $params);
        if ($result === false) {
            // Annulation de la transaction
            $db->rollBack();
            return;
        }

        // Ensuite, supprimer le produit lui-même
        $sqlDeleteProduct = "DELETE FROM products WHERE id = :product_id";
        $result = executeQuery($db, $sqlDeleteProduct, $params);
        if ($result === false) {
            // Annulation de la transaction
            $db->rollBack();
            return;
        }

        // Si tout se passe bien, supprimer le fichier de l'image du produit
        if (file_exists($ImagePath)) {
            unlink($ImagePath);
        }

        // Si tout se passe bien, valider la transaction
        $db->commit();
    } catch (PDOException $e) {
        // Une erreur s'est produite, annuler la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}
