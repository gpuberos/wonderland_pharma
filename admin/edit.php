<?php require_once __DIR__ . '/utilities/layout/header.ut.php'; ?>

<?php
$currentId = $_GET['id'];

// Prépare la requête SQL pour sélectionner le jeu avec l'ID spécifié.
$sql = "SELECT * FROM products WHERE id = :current_id";
$product = findDataById($db, $sql, $currentId);

?>

<div class="container py-4">
    <form action="update.php" method="POST" class="col-6 mx-auto" enctype="multipart/form-data">
        <fieldset>
            <legend>Modifier un produit</legend>

            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <div class="row mb-3">
                <div class="col">
                    <label for="productName" class="form-label">Nom : </label>
                    <input type="text" name="product_name" value="<?= $product['product_name'] ?>" id="productName" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productPrice" class="form-label">Prix : </label>
                    <input type="number" name="product_price" value="<?= $product['product_price'] ?>" id="productPrice" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productDesc" class="form-label">Description : </label>
                    <textarea name="product_description" id="productDesc" class="form-control" rows="10"><?= $product['product_description'] ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <input type="submit" name="submitProduct" value="Mettre à jour" class="btn btn-primary">
                </div>
            </div>
        </fieldset>
    </form>

</div>

<?php require_once __DIR__ . '/utilities/layout/footer.ut.php'; ?>