<?php

// La fonction formatLocalFilePath remplace le caractère pour séparer les répertoires sur le système d'exploitation.
function formatLocalFilePath($path)
{
    // La fonction str_replace est utilisée pour remplacer tous les '/' dans l'URL par DIRECTORY_SEPARATOR
    // DIRECTORY_SEPARATOR est une constante pré-définie en PHP qui contient le caractère correct pour séparer les répertoires sur le système d'exploitation actuel.
    // (par exemple, Windows utilise '\' tandis que Linux utilise '/').
    $formattedPath = str_replace('/', DIRECTORY_SEPARATOR, $path);

    return $formattedPath;
}

// La fonction uploadImageFile, upload les fichiers images dans un répertoire uniquement avec les extensions alloués et supprime l'ancienne image si elle existe et que le paramètre optionnelle est défini.
// Le paramètre $oldImage est optionnel et sa valeur par défaut est null.
function uploadImageFile($inputName, $destinationPath, $oldImage = null)
{
    // Vérifie si la méthode de la requête est POST et si un fichier a été uploadé sans erreur
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        // On utilise la fonction formatLocalFilePath pour s'assurer que le chemin est correctement formaté pour le système d'exploitation actuel.
        $destFormattedPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . formatLocalFilePath($destinationPath);

        // Récupère le chemin temporaire du fichier uploadé
        // $_FILES est une variable superglobale en PHP qui contient les informations des fichiers uploadés
        // $_FILES[$inputName]['tmp_name'] contient le chemin temporaire où le fichier uploadé est stocké sur le serveur
        // https://www.php.net/manual/fr/reserved.variables.files
        $fileTmpPath = $_FILES[$inputName]['tmp_name'];

        // Récupère le nom original du fichier
        // $_FILES[$inputName]['name'] contient le nom original du fichier (tel qu'il était sur l'ordinateur de l'utilisateur)
        $fileName = $_FILES[$inputName]['name'];

        // Récupère l'extension du fichier et la convertit en minuscule
        // pathinfo est une fonction intégrée à PHP pour obtenir des informations sur le fichier
        // La constante PATHINFO_EXTENSION sert à obtenir l'extension du fichier
        // https://www.php.net/manual/fr/function.pathinfo.php
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Nettoie le nom du fichier, le convertit en minuscule et limite le nombre de caractères à 50
        // La constante PATHINFO_EXTENSION sert à obtenir le nom du fichier
        $cleanFileName = str_replace([' ', '_'], '-', pathinfo($fileName, PATHINFO_FILENAME));
        $charLimitFileName = strtolower(substr($cleanFileName, 0, 50));

        // Crée le nouveau nom du fichier et un id unique
        // https://www.php.net/manual/fr/function.uniqid.php
        $newFileName = $charLimitFileName . '-' . uniqid() . '.' . $fileExtension;

        // Liste les extensions de fichiers autorisées
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'webp', 'png', 'svg'];

        // Vérifie si l'extension de fichier est dans la liste des extensions autorisées
        if (in_array($fileExtension, $allowedExtensions, true)) {
            // Si c'est le cas, on prépare le chemin de destination pour uploader le fichier.
            // On utilise le chemin $destFormatPath correctement formaté pour le système d'exploitation actuel.
            // On ajoute le nouveau nom du fichier à ce chemin.
            $destPath =  $destFormattedPath . $newFileName;

            // On tente de déplacer le fichier uploadé vers le répertoire de destination
            // La fonction move_upload_file vérifie la validité du fichier en s'assurant qu'il a été uploadé via un formulaire POST (HTTP POST).
            // https://www.php.net/manual/fr/function.move-uploaded-file.php
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Si le fichier a été déplacé avec succès, on supprime l'ancienne image si elle existe
                if ($oldImage !== null) {
                    // Si $oldImage n'est pas null, on construit le chemin complet de l'ancienne image en utilisant le chemin $destFormatPath correctement formaté pour le système d'exploitation actuel et le nom de l'ancienne image
                    $oldImagePath = $destFormattedPath . $oldImage;

                    if (file_exists($oldImagePath)) {
                        // Si le fichier existe, supprime le du serveur
                        // https://www.php.net/manual/fr/function.unlink
                        unlink($oldImagePath);
                    }
                }

                // On retourne le nom du fichier.
                return $newFileName;

            } else {
                // Si le fichier n'a pas pu être déplacé, on retourne null.
                return null;
            }
        }
    } else {
        // Si Une erreur inattendue s'est produite lors du téléchargement du fichier, on retourne null.
        return null;
    }
}
