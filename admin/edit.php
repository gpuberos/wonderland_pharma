<?php
$headTitle = "Back Office : Modification d'un produit";

require_once __DIR__ . '/utilities/layout/header.ut.php';

// Récupère toutes les catégories de produits.
$productCategoryQuery = "SELECT `product_category`.* FROM `product_category`";
$productCategories = findAllDatas($db, $productCategoryQuery);

// Récupère tous les médecins.
$doctorQuery = "SELECT `doctors`.* FROM `doctors`";
$doctors = findAllDatas($db, $doctorQuery);

// Récupère la valeur de 'id' à partir de la chaîne de requête URL et l'assigne à la variable $currentId
$currentId = $_GET['id'];

// Prépare la requête SQL pour récupérer les informations du produit, de la catégorie du produit, de l'image du produit et du médecin pour le produit avec l'ID spécifié.
$sql = "SELECT 
    products.id AS product_id,
    products.product_name,
    products.product_description,
    products.product_price,
    products.product_category_id,
    product_category.category_name,
    product_pictures.product_path_img,
    doctors.id AS doctor_id,
    doctors.doctor_name
FROM products
INNER JOIN product_category ON products.product_category_id = product_category.id
INNER JOIN product_pictures ON products.id = product_pictures.product_id
INNER JOIN doctors_products ON products.id = doctors_products.product_id
INNER JOIN doctors ON doctors_products.doctor_id = doctors.id
WHERE products.id = :current_id";

// Exécute la fonction findDataById pour récupérer les informations du produit de la requête SQL avec l'ID du produit et stocke le résultat dans la variable $product
$product = findDataById($db, $sql, $currentId);

var_dump($product);

?>

<div class="container-fluid p-5">
    <form action="update.php" method="POST" class="col-6 mx-auto" enctype="multipart/form-data">
        <fieldset>
            <legend>Modifier un produit</legend>

            <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

            <div class="row mb-3">
                <div class="col">
                    <label for="productName" class="form-label">Nom : </label>
                    <input type="text" name="product_name" value="<?= $product['product_name'] ?>" id="productName" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productCategory" class="form-label visually-hidden">Catégorie</label>
                    <select class="form-select" id="productCategory" name="product_category_id" aria-label="Sélection de la catégorie">
                        <option>Sélectionner une catégorie</option>
                        <?php foreach ($productCategories as $row) : ?>
                            <option value="<?= $row['id'] ?>" <?= isset($product['product_category_id']) && $row['id'] == $product['product_category_id'] ? "selected" : "" ?>><?= $row['category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="doctor" class="form-label visually-hidden">Médecins</label>
                    <select class="form-select" id="doctor" name="doctor_id" aria-label="Sélection du médecin">
                        <option>Sélectionner un médecin</option>
                        <?php foreach ($doctors as $row) : ?>
                            <option value="<?= $row['id'] ?>" <?= isset($product['doctor_id']) && $row['id'] == $product['doctor_id'] ? "selected" : "" ?>><?= $row['doctor_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="card">
                        <div class="row g-0 flex-md-row-reverse">
                            <div class="col-md-4">
                                <img src="../<?= PRODUCTS_IMG_PATH . $product['product_path_img'] ?>" class="img-fluid rounded-end" alt="Image du produit actuel" />
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <label for="productPathImg" class="form-label">Fichier image : </label>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="3072000" />
                                    <input type="file" name="product_path_img" id="productPathImg" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
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
