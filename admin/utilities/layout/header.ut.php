<?php

// Inclusion du fichier de configuration des chemins d'accès (Images)
require_once dirname(__DIR__, 2) . '/config/path.cfg.php';

// Inclusion du fichier de configuration de la base de données
require_once dirname(__DIR__, 2) . '/config/database.cfg.php';

// Inclusion du fichier contenant les fonctions relatives à la base de données
require_once dirname(__DIR__, 2) . '/function/database.fn.php';

// Appel de la fonction getPDOlink() pour obtenir un lien vers la base de données
$db = getPDOlink($config);

// Inclusion du fichier contenant les fonctions nécessaire à l'en-tête
require_once dirname(__DIR__, 2) . '/function/header.fn.php';

// Inclusion du fichier contenant les fonctions nécessaire au frontend
require_once dirname(__DIR__, 2) . '/function/frontend.fn.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS Custom -->
    <link rel="stylesheet" href="<?= CSS_PATH_BO ?>/styles.css">

    <title><?= isset($headTitle) ? $headTitle : "Back Office" ?></title>
</head>

<body class="d-flex flex-column vh-100">
    <header>
        <?php require_once dirname(__DIR__, 2) . '/utilities/nav/header_nav.ut.php'; ?>
    </header>

    <main class="flex-grow-1">