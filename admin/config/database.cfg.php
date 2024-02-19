<?php

// Tableau de configuration contenant les variables d'environnement pour la base de données (BDD).
// Ces informations sont nécessaires pour établir une connexion avec la BDD.
$config = [
    'dbhost' => 'localhost', // L'hôte de la BDD.
    'dbname' => 'db_wpharma', // Le nom de la BDD.
    'dbport' => '3306', // Le port à utiliser pour la connexion à la BDD.
    'dbchar' => 'utf8', // Charset UTF-8 pour assurer la compatibilité avec les caractères internationaux.
    'dbuser' => 'root', // Le nom d'utilisateur pour se connecter à la BDD.
    'dbpass' => 'root' // Le mot de passe pour se connecter à la BDD.
];
