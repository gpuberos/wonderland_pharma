<?php

// Fonction pour récupérer les produits triés en fonction de la préférence de l'utilisateur
function getSortedProducts($db, $orderBy)
{
    // Construction de la requête SQL pour récupérer les produits avec les noms de catégorie
    $productsQuery = "SELECT 
                    products.id AS product_id,
                    products.product_name, 
                    products.product_description, 
                    products.product_price, 
                    product_category.category_name
                    FROM products 
                    INNER JOIN product_category ON products.product_category_id = product_category.id
                    ORDER BY product_price $orderBy;
                    ";

    // Appel de la fonction findAllDatas pour exécuter la requête et renvoyer les résultats
    return findAllDatas($db, $productsQuery);
}
