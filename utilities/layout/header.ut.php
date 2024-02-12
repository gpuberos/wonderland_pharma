<?php

// Inclusion du fichier de configuration des chemins d'accès (Images)
require_once dirname(dirname(__DIR__)) . '/config/path.cfg.php';

// Inclusion du fichier de configuration de la base de données
require_once dirname(dirname(__DIR__)) . '/config/database.cfg.php';

// Inclusion du fichier contenant les fonctions relatives à la base de données
require_once dirname(dirname(__DIR__)) . '/function/database.fn.php';

// Appel de la fonction getPDOlink() pour obtenir un lien vers la base de données
$db = getPDOlink($config);

// Inclusion du fichier contenant les fonctions nécessaire à l'en-tête
require_once dirname(dirname(__DIR__)) . '/function/header.fn.php';

// Inclusion du fichier contenant les fonctions nécessaire au frontend
require_once dirname(dirname(__DIR__)) . '/function/frontend.fn.php';

// Appel de la fonction getPageInfo() pour obtenir les informations relatives à la page dans la base de données
$pageInfo = getPageInfo($db);

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

    <title><?= $pageInfo['page_title'] ?></title>
    <meta name="description" content="<?= $pageInfo['page_meta_desc'] ?>">
    <meta name="keywords" content="<?= $pageInfo['page_meta_keywords'] ?>">
</head>

<body id="<?= $pageInfo['page_bodyId'] ?>" class="d-flex flex-column vh-100">
    <header>
        <?php require_once dirname(dirname(__DIR__)) . '/utilities/nav/header_nav.ut.php'; ?>
    </header>

    <main class="flex-grow-1 py-4">