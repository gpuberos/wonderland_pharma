<?php

// $differences = array_diff_assoc($sendDatas, $currentDatas);

// if (!empty($differences)) {
//     // Update de la base données
//     $sql = "UPDATE products 
//             SET product_name = :product_name, product_description = :product_description, product_price = :product_price 
//             WHERE id = :current_id";
// }

require_once __DIR__ . '/utilities/layout/header.ut.php';

if (isset($_POST['submitProduct']) && $_POST['current_id'] === $_POST['product_id']) {
    // Récupère les données envoyées par le formulaire
    $sendDatas = $_POST;

    // Récupère le current Id
    $currentId = $_POST['current_id'];

    var_dump($currentId);
    var_dump($sendDatas);
    
}
