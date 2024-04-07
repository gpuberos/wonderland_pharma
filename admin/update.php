<?php

require_once __DIR__ . '/utilities/layout/header.ut.php';
require_once __DIR__ . '/function/database.fn.php';
require_once __DIR__ . '/function/upload.fn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère le current Id
    $currentId = $_POST['current_id'];

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

    // Vérifie si une nouvelle image a été téléchargée
    if (!empty($_FILES['product_path_img']['name'])) {
        // Télécharge la nouvelle image
        $newImageName = uploadImageFile('product_path_img', PRODUCTS_IMG_PATH);
        if ($newImageName === null) {
            echo "Erreur lors du téléchargement de l'image.";
            $db->rollBack();
            return false;
        }

        // Stocke le nom de l'ancienne image
        $oldImageName = $_POST['old_image'];

        // Ajoute le nom de la nouvelle image aux données à mettre à jour
        $sendDatas['product_path_img'] = $newImageName;
    } else {
        // Si aucune nouvelle image n'est téléchargée, utilise l'ancienne image
        $sendDatas['product_path_img'] = $_POST['old_image'];
    }

    // Met à jour le produit dans la base de données
    $result = updateProduct($db, $currentId, $sendDatas);
    if ($result) {
        // Supprime l'ancienne image si elle existe et si la suppression est demandée
        if (isset($oldImageName) && !empty($oldImageName)) {
            deleteImageFile($oldImageName, PRODUCTS_IMG_PATH);
        }
        echo "Le produit a été mis à jour !";
    } else {
        echo "Une erreur s'est produite lors de la mise à jour du produit.";
    }
}
