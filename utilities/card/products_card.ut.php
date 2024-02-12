<?php
// Vérification si l'utilisateur a soumis une préférence de tri (ASC ou DESC)
if (isset($_POST['sortBy']) && $_POST['sortBy'] == 'ASC') {
    // Si ASC est sélectionné, récupérer les produits triés par ordre croissant
    $products = getSortedProducts($db, 'ASC');
} else if (isset($_POST['sortBy']) && $_POST['sortBy'] == 'DESC') {
    // Si DESC est sélectionné, récupérer les produits triés par ordre décroissant
    $products = getSortedProducts($db, 'DESC');
} else {
    // Si aucune préférence n'est spécifiée, récupérer tous les produits sans tri
    $productsQuery = "SELECT products.*, product_category.category_name FROM products INNER JOIN product_category ON products.product_category_id = product_category.id";
    $products = findAllDatas($db, $productsQuery);
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
        <?php foreach ($products as $product) : ?>
            <div class="col">
                <div class="card h-100 text-center rounded-0">
                    <img src="<?= PRODUCTS_IMG_PATH . $product['product_pathimg'] ?>" class="card-img-top rounded-0" alt="$product['product_title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['product_title'] ?></h5>
                        <p><span class="badge rounded-pill text-bg-light"><?= $product['category_name'] ?></span></p>
                        <p class="card-text"><?= $product['product_description'] ?></p>
                    </div>
                    <div class="card-footer pb-4">
                        <p class="card-text"><strong>Prix : <?= $product['product_price'] ?> €</strong></p>
                        <a href="#" class="btn bg-blue text-white">Acheter</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>