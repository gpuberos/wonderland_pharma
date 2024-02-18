# Documentations

- [**STRUCTURE.md** : documentation sur la structure du site](/docs/STRUCTURE.md)
- [**FUNCTION.md** : documentation sur les fonctions](/docs/FUNCTION.md)
- [**DATABASE.md** : documentation sur la base de données](/docs/DATABASE.md)

## @TODO

- Regex pour nommer les fichiers en respectant la normalisation en terme de nommage en fonction du système de fichiers.

- Gérer les messages d'erreur de $_FILES (début d'idée de code)
```php
// Vérifie si une erreur s'est produite lors de l'upload du fichier
if ($_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
    // Récupère le code d'erreur
    $errorCode = $_FILES[$inputName]['error'];

    // Initialise un tableau pour stocker les messages d'erreur
    // https://www.php.net/manual/en/features.file-upload.errors.php
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => "La taille du fichier téléchargé excède la valeur upload_max_filesize dans php.ini.",
        UPLOAD_ERR_FORM_SIZE  => "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIspécifiée dans le formulaire HTML.",
        UPLOAD_ERR_PARTIAL    => "Le fichier n'a été que partiellement téléchargé.",
        UPLOAD_ERR_NO_FILE    => "Aucun fichier n'a été téléchargé.",
        UPLOAD_ERR_NO_TMP_DIR => "Le dossier temporaire est manquant.",
        UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque.",
        UPLOAD_ERR_EXTENSION  => "Une extension PHP a arrêté l'envoi de fichier."
    ];

    // Si le code d'erreur est dans le tableau des messages d'erreur, retourne moi le messad'erreur correspondant
    if (isset($errorMessages[$errorCode])) {
        return $errorMessages[$errorCode];
    } else {
    // Sinon, retourne un message d'erreur générique
        return "Une erreur inconnue s'est produite lors de l'upload du fichier.";
    }
```

- Gérer la permission d'écriture dans le répertoire CHMOD

### A lire

**Sécurité** :
- https://book.hacktricks.xyz/v/fr/network-services-pentesting/pentesting-web/php-tricks-esp#in_array
- https://medium.com/swlh/php-type-juggling-vulnerabilities-3e28c4ed5c09

**Regex** :
- https://www.php.net/manual/fr/function.preg-replace.php

**Droits d'écriture sur répertoire** :
- https://www.php.net/manual/fr/function.is-writable.php

**Permissions CHMOD** :
- https://www.php.net/manual/fr/function.chmod.php

**Pour gérer les espaces dans l'URL** :
- https://www.php.net/manual/fr/function.urldecode.php
