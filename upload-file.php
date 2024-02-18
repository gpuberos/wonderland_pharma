<?php

// @TODO! - Test upload fichier image

require_once __DIR__ . '/config/path.cfg.php';
require_once __DIR__ . '/function/upload.fn.php';

var_dump($_POST);
var_dump($_FILES);

uploadImageFile('product_path_img', PRODUCTS_IMG_PATH);

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