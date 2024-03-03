<?php
$headTitle = "Back Office : Ajout d'un produit";

require_once __DIR__ . '/utilities/layout/header.ut.php';
require_once __DIR__ . '/function/upload.fn.php';


// Récupère toutes les catégories de produits.
$productCategoryQuery = "SELECT `product_category`.* FROM `product_category`";
$productCategories = findAllDatas($db, $productCategoryQuery);

// Récupère tous les médecins.
$doctorQuery = "SELECT `doctors`.* FROM `doctors`";
$doctors = findAllDatas($db, $doctorQuery);

// Vérifie si la méthode de la requête est POST. S'execute uniquement quand le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les valeurs du formulaire à partir de la superglobale $_POST.
    // Ajout de htmlspecialchars() pour échapper les caractères spéciaux et ainsi se protéger contre certaine attaques XSS
    $productName = htmlspecialchars($_POST['product_name']);
    $productDescription = htmlspecialchars($_POST['product_description']);
    $productPrice = htmlspecialchars($_POST['product_price']);
    $productCategoryId = htmlspecialchars($_POST['product_category_id']);
    $doctorId = htmlspecialchars($_POST['doctor_id']);

    // Démarre une nouvelle transaction
    $db->beginTransaction();

    // Insère le nouveau produit dans la table 'products'
    $sql = "INSERT INTO `products` (`product_name`, `product_description`, `product_price`, `product_category_id`)
            VALUES (:product_name, :product_description, :product_price, :product_category_id)";

    // Définition des paramètres de liaison dans un tableau pour la requête SQL préparée.
    $params = [
        ':product_name' => $productName,
        ':product_description' => $productDescription,
        ':product_price' => $productPrice,
        ':product_category_id' => $productCategoryId
    ];

    // Execute de la requête préparée via la fonction executeQuery
    $sth = executeQuery($db, $sql, $params);

    // Si la requête a échoué, envoie un message d'erreur et annule la transaction en cours et toutes les modifications apportées à la base de données.
    if ($sth === false) {
        // Annulation de la transaction
        $db->rollBack();
        return;
    }

    // Récupère l'ID du produit qui vient d'être inséré
    $productId = $db->lastInsertId();

    // Upload de l'image
    $productPathImg = uploadImageFile('product_path_img', PRODUCTS_IMG_PATH);

    // Vérifier s'il y a eu une erreur lors du téléchargement de l'image
    if ($productPathImg !== null) {
        // Insère la nouvelle image de produit dans la table 'product_pictures'
        $sql = "INSERT INTO `product_pictures` (`product_path_img`, `product_id`) 
                VALUES (:product_path_img, :product_id)";

        // Définition des paramètres de liaison dans un tableau pour la requête SQL préparée.
        $params = [
            ':product_path_img' => $productPathImg,
            ':product_id' => $productId
        ];

        // Execute de la requête préparée via la fonction executeQuery
        $sth = executeQuery($db, $sql, $params);

        // Si la requête a échoué, envoie un message d'erreur et annule la transaction en cours et toutes les modifications apportées à la base de données.
        if ($sth === false) {
            // Annulation de la transaction
            $db->rollBack();
            return;
        }
    } else {
        // Afficher un message d'erreur
        echo "Une erreur s'est produite lors du téléchargement de l'image.";
    }

    // Insère le nouveau lien entre le médecin et le produit dans la table 'doctors_products'
    $sql = "INSERT INTO `doctors_products` (`doctor_id`, `product_id`) 
            VALUES (:doctor_id, :product_id)";

    // Définition des paramètres de liaison dans un tableau pour la requête SQL préparée.
    $params = [
        ':doctor_id' => $doctorId,
        ':product_id' => $productId
    ];

    // Execute de la requête préparée via la fonction executeQuery
    $sth = executeQuery($db, $sql, $params);

    // Si la requête a échoué, envoie un message d'erreur et annule la transaction en cours et toutes les modifications apportées à la base de données.
    if ($sth === false) {
        // Annulation de la transaction
        $db->rollBack();
        return;
    }

    // Valide la transaction en cours et rends permanent toutes les modifications apportées à la base de données depuis le dernier appel à beginTransaction().
    $db->commit();

    // Affiche le message de succès si la transaction a réussi.
    echo "Produit ajouté avec succès !";
}

?>

<div class="container py-5">
    <form action="#" method="POST" class="col-6 mx-auto" enctype="multipart/form-data">
        <fieldset>
            <legend>Ajouter un produit</legend>
            <div class="row mb-3">
                <div class="col">
                    <label for="productName" class="form-label">Nom : </label>
                    <input type="text" name="product_name" id="productName" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productPrice" class="form-label">Prix : </label>
                    <input type="number" min="0" step="0.01" name="product_price" id="productPrice" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">

                    <label for="productCategory" class="form-label visually-hidden">Catégorie</label>
                    <select class="form-select" id="productCategory" name="product_category_id" aria-label="Sélection de la catégorie">
                        <option selected>Sélectionner une catégorie</option>
                        <?php foreach ($productCategories as $row) : ?>
                            <option value="<?= $row['id'] ?>"><?= $row['category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="doctor" class="form-label visually-hidden">Médecins</label>
                    <select class="form-select" id="doctor" name="doctor_id" aria-label="Sélection du médecin">
                        <option selected>Sélectionner un médecin</option>
                        <?php foreach ($doctors as $row) : ?>
                            <option value="<?= $row['id'] ?>"><?= $row['doctor_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productPathImg" class="form-label">Fichier image : </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="3072000" />
                    <input type="file" name="product_path_img" id="productPathImg" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="productDesc" class="form-label">Description : </label>
                    <textarea name="product_description" id="productDesc" class="form-control" rows="10"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <input type="submit" name="submitProduct" value="Ajouter" class="btn btn-primary">
                </div>
            </div>
        </fieldset>
    </form>
</div>

<?php require_once __DIR__ . '/utilities/layout/footer.ut.php'; ?>