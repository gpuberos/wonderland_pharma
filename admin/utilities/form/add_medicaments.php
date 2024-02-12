<?php
require_once __DIR__ . ('/utilities/header.php');

$sql = "SELECT * FROM `product_category`";
$sth = $db->prepare($sql);
$productCategories = $sth->execute();

// Vérifie si la méthode de la requête est POST. S'execute uniquement quand le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupère les valeurs du formulaire à partir de la superglobale $_POST.
        // Ajout de htmlspecialchars() pour échapper les caractères spéciaux et ainsi se protéger contre certaine attaques XSS
        $name = htmlspecialchars($_POST['product_title']);
        $description = htmlspecialchars($_POST['product_description']);
        $price = htmlspecialchars($_POST['prix']);
        $productPathImg = htmlspecialchars($_POST['product_pathimg']);
        $productCategory = htmlspecialchars($_POST['product_category_id']);

        // Prépare la requête SQL pour insérer les données du formulaire dans la base de données.
        $sql = "INSERT INTO products (product_title, product_description, product_price, product_pathimg, product_category_id) VALUES (:product_title, :product_description, :price, :product_pathimg, :product_category_id)";

        // Exécute la requête SQL.
        // $dbco->query($sql);

        // PDOStatement - On prépare la requete
        $sth = $db->prepare($sql);

        // Lie les paramètres à la requête SQL.
        $sth->bindParam(':product_title', $name);
        $sth->bindParam(':product_description', $description);
        $sth->bindParam(':price', $price);
        $sth->bindParam(':product_pathimg', $productPathImg);
        $sth->bindParam(':product_category_id', $productCategory);

        // Exécute la requête SQL.
        $sth->execute();

        // Affiche le message de succès si la requête a réussi.
        echo "Jeu ajouté avec succès !";
    } catch (PDOException $e) {
        // Si une erreur se produit lors de l'exécution de la requête SQL, on affiche un message d'erreur.
        echo "Erreur lors de l'ajout du jeu : " . $e->getMessage();
    }
}
?>

<form action="#" method="POST">
    <label for="name">Nom : </label> <input type="text" name="product_title" id="name"><br>
    <label for="price">Prix : </label><input type="number" name="price" id="prix"><br>
    <div class="form-floating">
        <label for="category" class="visually-hidden">Catégorie</label>
        <select class="form-select" id="category" name="product_category_id" aria-label="Selection de la catégorie">
            <option selected>Sélectionner une catégorie</option>
            <?php foreach ($productCategories as $productCategory) : ?>
                <option value="<?= $productCategory['id'] ?>"><?= $productCategory['name'] ?></option>
            <?php endforeach; ?>
            <!-- <option value="1">Comprimés magiques</option>
            <option value="2">Concoctions fantastiques</option>
            <option value="3">Saveurs enchantées</option> -->
        </select>
    </div>
    <label for="pathImg">Fichier image : </label><input type="file" name="product_pathimg" id="pathImg"><br>
    <label for="desc">Description : </label><textarea name="product_description" id="desc"></textarea><br>
    <input type="submit" value="Ajouter">
</form>