<?php

require_once __DIR__ . '/utilities/layout/header.ut.php';

if (isset($_POST['submitProduct'])) {
    // Récupère les données envoyées par le formulaire
    $sendDatas = $_POST;

    // Récupère les données actuelles du produit
    $currentId = $_POST['id'];
    $sql = "SELECT 
            products.*,
            product_pictures.product_path_img
            FROM products
            INNER JOIN product_pictures ON products.id = product_pictures.product_id
            WHERE products.id = :current_id";
            
    $product = findDataById($db, $sql, $currentId);
    $currentDatas = $product;

    // Compare les données envoyées avec les données actuelles
    $differences = array_diff_assoc($sendDatas, $currentDatas);

    // Si il y a des différences, alors on met à jour la base de données
    if (!empty($differences)) {
        foreach ($differences as $key => $value) {
            $sql = "UPDATE products SET $key = :value WHERE id = :current_id";
            $params = [
                ':value' => $value,
                ':current_id' => $currentId
            ];
            
            executeQuery($db, $sql, $params);
        }
    }
}
?>
