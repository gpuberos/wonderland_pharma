<?php
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

    <div class="row row-cols-1 row-cols-md-4 row-gap-4">
        <?php foreach ($products as $row) : ?>
            <div class="col">
                <div class="card h-100 text-center rounded-0">
                    <img src="<?= PRODUCTS_IMG_PATH . $row['product_path_img'] ?>" class="card-img-top rounded-0" alt="<?= $row['product_name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['product_name'] ?></h5>
                        <p><span class="badge rounded-pill text-bg-light"><?= $row['category_name'] ?></span></p>
                        <p class="card-text"><?= $row['product_description'] ?></p>
                    </div>
                    <div class="card-footer pb-4">
                        <p class="card-text"><strong>Prix : <?= $row['product_price'] ?> €</strong></p>
                        <a href="#" class="btn bg-blue text-white">Acheter</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>