<?php

/*

index.php :
Etape 1 : Connexion à la base de données et récupération des informations de tous les produits
Etape 2 : Récupération de la liste des produits et affichage sous forme de tableau
Etape 3 : Ajouter un bouton modifier qui a l'id du produit et en URL : edit.php?id={numéro id de mon produit}

edit.php :
Etape 1 : Récupération de l'ID du produit en utilisant GET
Etape 2 : Connexion à la base de données et récupération des informations du produit
Etape 3 : Affichage du formulaire pré-rempli

update.php :
Etape 1 : Récupération des données soumises
Etape 2 : Connexion à la base de données et récupération des données actuelles
Etape 3 : Comparaison des tableaux
Etape 4 : Vérification des différences

*/

require_once __DIR__ . '/utilities/layout/header.ut.php';

// Prépare la requête SQL pour récupérer les produits
$productsQuery = "SELECT 
                products.id,
                products.product_name, 
                products.product_description, 
                products.product_price, 
                product_category.category_name
                FROM products 
                INNER JOIN product_category ON products.product_category_id = product_category.id
                ";

// Exécute la fonction findAllDatas qui affiche tous les résultats de la requête SQL et les stockent dans la variable $products
$products = findAllDatas($db, $productsQuery);

// Vérifie si 'sortBy' a été posté
if (isset($_POST['sortBy'])) {
    // Si c'est le cas, stocke la valeur dans la variable $sortBy
    $sortBy = $_POST['sortBy'];

    // Vérifie si la valeur de $sortBy est 'ASC' ou 'DESC'
    if ($sortBy === 'ASC' || $sortBy === 'DESC') {
        // Si c'est le cas, appelle la fonction getSortedProducts() avec la base de données et l'ordre de tri sélectionné par l'utilisateur
        $products = getSortedProducts($db, $sortBy);
    }
} 

?>

<div class="container py-4">
    <section>
        <div class="row mb-4">
            <div class=" col-auto">
                <form action="#" method="POST" class="row g-3">
                    <div class="col-auto">
                        <label for="sortByPrice" class="visually-hidden">Trier les produits par prix</label>
                        <select class="form-select" id="sortByPrice" name="sortBy" aria-label="Select pour trier par prix">
                            <option selected>Trier par prix</option>
                            <option value="ASC">Moins cher</option>
                            <option value="DESC">Plus cher</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="submit" value="Valider" class="btn bg-blue text-white">
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom du produit</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Description</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $row) : ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td><?= substr($row['product_description'], 0, 60) ?> ...</td>
                            <td><?= $row['product_price'] ?> €</td>
                            <td><a href="edit.php?id=<?= $row['id'] ?>" class="btn bg-blue text-white">Modifier</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/utilities/layout/footer.ut.php'; ?>