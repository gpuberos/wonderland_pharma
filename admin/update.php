<?php

require_once __DIR__ . '/utilities/layout/header.ut.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submitProduct']) && $_POST['current_id'] === $_POST['product_id']) {
        // Récupère les données envoyées par le formulaire
        $tmpDatas = $_POST;

        // On crée un tableau similaire au tableau $currentDatas pour la comparaison
        $sendDatas = [
            'product_id' => $tmpDatas['current_id'],
            'product_name' => $tmpDatas['product_name'],
            'product_description' => $tmpDatas['product_description'],
            'product_price' => $tmpDatas['product_price'],
            'product_category_id' => $tmpDatas['product_category_id'],
            'doctor_id' => $tmpDatas['doctor_id']
        ];

        // Récupère le current Id
        $currentId = $_POST['current_id'];

        $sql = "SELECT 
                products.id AS product_id,
                products.product_name,
                products.product_description,
                products.product_price,
                products.product_category_id,
                doctors.id AS doctor_id
                FROM products
                INNER JOIN product_category ON products.product_category_id = product_category.id
                INNER JOIN doctors_products ON products.id = doctors_products.product_id
                INNER JOIN doctors ON doctors_products.doctor_id = doctors.id
                WHERE products.id = :current_id";
        $params = [
            ':current_id' => $currentId
        ];

        $sth = executeQuery($db, $sql, $params);
        $currentDatas = $sth->fetch();

        $differences = array_diff_assoc($sendDatas, $currentDatas);

        // var_dump($currentId);
        // var_dump($currentDatas);
        // var_dump($sendDatas);

        if (!empty($differences)) {
            var_dump($differences);
            // Update de la base données
            // $sql = "UPDATE products 
            //         SET 
            //         product_name = :product_name, 
            //         product_description = :product_description, 
            //         product_price = :product_price,
            //         product_category_id = :product_category_id,
            //         doctor_id = :doctor_id
            //         WHERE id = :current_id";

            // $params = [
            //     ':product_name' => $differences['product_name'],
            //     ':product_description' => $differences['product_description'],
            //     ':product_price' => $differences['product_price'],
            //     ':product_category_id' => $differences['product_category_id'],
            //     ':doctor_id' => $differences['doctor_id']
            // ];

            // S'il y a une différence dans ce cas fait l'update uniquement de la colonne modifié
            // Problématique : Construire la requête SQL et ne passer que le ou les paramètres modifiés bindParam.
            // 
            // Concaténer $sql = $sql .
            // $difference = ['product_price' => 17]
            // SET nom = :nom
            // SET $key = :$key,
            // $key = 'product_price

            $sql = "UPDATE products SET ";
            $params = [];

            foreach ($differences as $key => $value) {
                // var_dump($key);
                $sql = $sql . "$key = :$key, ";
                $params[":$key"] = $value;
            }

            // Supprimer la virgule et l'espace à la fin de ma chaîne de caractère dans $sql avant de concaténer le WHERE
            // https://www.php.net/manual/fr/function.rtrim.php
            $sql = rtrim($sql, ", ");
            $sql = $sql . " WHERE products.id = :current_id";
            
            $params[':current_id'] = $currentId;
            
            executeQuery($db, $sql, $params);

            echo "Le produit a été mis à jour !";
            
        } else {
            echo "Aucune modification n'a été détectée !";
        }
    }
}
