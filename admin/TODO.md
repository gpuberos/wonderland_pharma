# Back Office

## index.php :
1. Etape 1 : Connexion à la base de données et récupération des informations de tous les produits
```php
$db = getPDOlink($config);
```
2. Etape 2 : Récupération de la liste des produits et affichage sous forme de tableau
```php
$sql = "SELECT * FROM products";
```
3. Etape 3 : Ajouter un bouton modifier qui a l'id du produit et en URL : edit.php?id={numéro id de mon produit}

## edit.php :
1. Etape 1 : Récupération de l'ID du produit en utilisant GET
```php
// Récupération de l'ID du produit
$currentId = $_GET['id'];
$produit = $sth->fetch();
```
2. Etape 2 : Connexion à la base de données et récupération des informations du produit
```php
$db = getPDOlink($config);
$sql = "SELECT * FROM products WHERE id = :current_id";

```
3. Etape 3 : Affichage du formulaire pré-rempli
```php
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
    <input type="text" name="product_name" value="<?= $produit['product_name'] ?>">
    <textarea name="product_description"><?= $produit['product_description'] ?></textarea>
    <input type="number" name="product_price" value="<?= $produit['product_price'] ?>">
    <input type="submit" value="Mettre à jour">
</form>
```

## update.php :
1. Etape 1 : Récupération des données soumises
    ```php
   $sendDatas = $_POST;
   ```
3. Etape 2 : Connexion à la base de données et récupération des données actuelles
```php
sql = "SELECT * FROM products WHERE id = :current_id";
$currentDatas = $sth->fetch();
```
5. Etape 3 : Comparaison des tableaux
   ```php
   $differences = array_diff_assoc($sendDatas, $currentDatas);
   ```
6. Etape 4 : Vérification des différences
   ```php
   if (!empty($differences)) {
        // Update de la base données
        $sql = "UPDATE products 
                SET product_name = :product_name, product_description = :product_description, product_price = :product_price 
                WHERE id = :current_id";

            // prepare, bindParam, execute
            echo "Le produit a été mis à jour !"
    } else {
        echo "Aucune modification n'a été détectée !"
    }
   ```

Delete Créer table Statut :
1 Quand je le rendre public
2 Brouillon (Draft)
3 Mettre à la poubelle (Trash) / mais pouvoir le récupérer

trim() supprime les espaces en début et fin de chaine.

opérateur de coalescence ?? : https://www.php.net/manual/fr/migration70.new-features.php#migration70.new-features.null-coalesce-op
// TODO : Thème tableau Bootstrap : https://mdbootstrap.com/snippets/standard/mdbootstrap/2920555?view=side