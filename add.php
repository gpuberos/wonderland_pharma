<?php

// @TODO! - Créer Backoffice et intégrer la page ajout dans /admin/

require_once __DIR__ . '/config/path.cfg.php';
require_once __DIR__ . '/config/database.cfg.php';
require_once __DIR__ . '/function/database.fn.php';

$db = getPDOlink($config);

require_once __DIR__ . '/function/header.fn.php';
require_once __DIR__ . '/function/frontend.fn.php';

// Récupère toutes les catégories de produits.
$productCategoryQuery = "SELECT `product_category`.* FROM `product_category`";
$productCategories = findAllDatas($db, $productCategoryQuery);

// Récupère tous les médecins.
$doctorQuery = "SELECT `doctors`.* FROM `doctors`";
$doctors = findAllDatas($db, $doctorQuery);

// Vérifie si la méthode de la requête est POST. S'execute uniquement quand le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupère les valeurs du formulaire à partir de la superglobale $_POST.
        // Ajout de htmlspecialchars() pour échapper les caractères spéciaux et ainsi se protéger contre certaine attaques XSS
        $productName = htmlspecialchars($_POST['product_name']);
        $productDescription = htmlspecialchars($_POST['product_description']);
        $productPrice = htmlspecialchars($_POST['product_price']);
        $productPathImg = htmlspecialchars($_POST['product_path_img']);
        $productCategoryId = htmlspecialchars($_POST['product_category_id']);
        $doctorId = htmlspecialchars($_POST['doctor_id']);

        // Démarre une nouvelle transaction
        $db->beginTransaction();

        // Insère le nouveau produit dans la table 'products'
        $sql = "INSERT INTO `products` (`product_name`, `product_description`, `product_price`, `product_category_id`)
                VALUES (:product_name, :product_description, :product_price, :product_category_id)";

        // Préparation de la requête SQL pour l'exécution.
        // $db est l'objet de la base de données, et $sql est la chaîne de la requête SQL.
        // La méthode prepare() renvoie un objet 'statement' ($sth) qui peut être utilisé pour exécuter la requête.
        $sth = $db->prepare($sql);


        // Lie les paramètres à la requête SQL.
        $sth->bindParam(':product_name', $productName);
        $sth->bindParam(':product_description', $productDescription);
        $sth->bindParam(':product_price', $productPrice);
        $sth->bindParam(':product_category_id', $productCategoryId);

        // Execute la requête préparée
        $sth->execute();

        // Récupère l'ID du produit qui vient d'être inséré
        $productId = $db->lastInsertId();

        // Insère la nouvelle image de produit dans la table 'product_pictures'
        $sql = "INSERT INTO `product_pictures` (`product_path_img`, `product_id`) VALUES (:product_path_img, :product_id)";

        // Préparation de la requête SQL pour l'exécution.
        $sth = $db->prepare($sql);

        // Lie les paramètres à la requête SQL.
        $sth->bindParam(':product_path_img', $productPathImg);
        $sth->bindParam(':product_id', $productId);

        // Execute la requête préparée
        $sth->execute();

        // Insère le nouveau lien entre le médecin et le produit dans la table 'doctors_products'
        $sql = "INSERT INTO `doctors_products` (`doctor_id`, `product_id`) VALUES (:doctor_id, :product_id)";

        // Préparation de la requête SQL pour l'exécution.
        $sth = $db->prepare($sql);

        // Lie les paramètres à la requête SQL.
        $sth->bindParam(':doctor_id', $doctorId);
        $sth->bindParam(':product_id', $productId);

        // Execute la requête préparée
        $sth->execute();

        // Valide la transaction en cours et rends permanent toutes les modifications apportées à la base de données depuis le dernier appel à beginTransaction().
        $db->commit();

        // Affiche le message de succès si la transaction a réussi.
        echo "Produit ajouté avec succès !";
    } catch (PDOException $e) {
        // Si une erreur se produit, on annule la transaction en cours et toutes les modifications apportées à la base de données
        $db->rollBack();

        // Puis on affiche un message d'erreur.
        echo "Erreur lors de l'ajout du produit : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- CSS Custom -->
    <link rel="stylesheet" href="<?= CSS_PATH ?>/styles.css">

    <title>Back Office : Ajout de produits</title>
</head>

<body class="d-flex flex-column vh-100">

    <main class="flex-grow-1 py-4">
        <div class="container py-4">
            <form action="#" method="POST" class="col-6 mx-auto">
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
                            <input type="number" name="product_price" id="productPrice" class="form-control">
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

    </main>
</body>
</html>