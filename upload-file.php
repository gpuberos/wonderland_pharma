<?php

// @TODO! - Test upload fichier image

require_once __DIR__ . '/config/path.cfg.php';

var_dump($_POST);
var_dump($_FILES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // https://www.php.net/manual/fr/features.file-upload.errors.php
    if (isset($_FILES['product_path_img']) && $_FILES['product_path_img']['error'] == 0) {

        $fileTmpPath = $_FILES['product_path_img']['tmp_name'];
        $fileName = $_FILES['product_path_img']['name'];
        $fileSize = $_FILES['product_path_img']['size'];
        $fileType = $_FILES['product_path_img']['type'];

        // Divise le nom du fichier en un tableau en utilisant le point comme délimiteur (nom du fichier, extension du fichier)
        $fileNameCmps = explode(".", $fileName);

        // On met en minuscule l'extension du fichier $fileNameCmps[0] = nom du fichier, $fileNameCmps[1] = extension du fichier
        $fileExtension = strtolower($fileNameCmps[1]);
        
        // On supprime les espaces, les - et les _
        $cleanFileName = str_replace([' ', '-', '_'], '', $fileNameCmps[0]);
        
        // On limite le nombre de caractère du nom de fichier à 50
        $charLimitFileName = substr($cleanFileName, 0, 50);
        
        // On met en minuscule le nom du fichier, on ajoute la date et le nom de l'extension en minuscule ex: filename-20240212165000.jpg
        $newFileName = strtolower($charLimitFileName) . '-' . date("YmdHis") . '.' . $fileExtension;

        // Extensions de fichiers autorisées
        $allowedfileExtensions = ['jpg', 'jpeg', 'gif', 'webp', 'png', 'svg'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = PRODUCTS_IMG_PATH;
            $destPath = $uploadFileDir . $newFileName;

            move_uploaded_file($fileTmpPath, $destPath);

            echo "Le fichier a été uploadé avec succès !";

        } else {
            echo "Erreur dans l'upload";
        }
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

    <title>Back Office : Upload de fichier</title>
</head>

<body class="d-flex flex-column vh-100">
    <main class="flex-grow-1 py-4">
        <div class="container py-4">
            <form action="#" method="POST" class="col-6 mx-auto" enctype="multipart/form-data">
                <fieldset>
                    <legend>Upload fichier</legend>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="productPathImg" class="form-label">Fichier image : </label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="3072000" />
                            <input type="file" name="product_path_img" id="productPathImg" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="submit" name="submitProduct" value="Enregistrer" class="btn btn-primary">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

    </main>
</body>

</html>