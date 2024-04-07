<?php
$headTitle = "Back Office : Suppression d'un produit";

require_once __DIR__ . '/utilities/layout/header.ut.php';
require_once __DIR__ . '/function/database.fn.php';


// Vérifie si l'ID du produit à supprimer est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    // Récupère l'ID du produit à supprimer
    $productId = $_GET['id'];

    // Appelle la fonction deleteProduct pour supprimer le produit de la base de données
    deleteProduct($db, $productId);
}
