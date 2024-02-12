# Structure des dossiers

## config

Contient les fichiers de configuration du site

- `database.cfg.php` : Contient les informations qui sont nécessaires pour établir une connexion avec la BDD.
- `path.cfg.php` : Contient les chemins d'accès pour CSS, pour les images.

Ces scripts sont inclus dans les pages du site en utilisant `require_once`.

## data

- `dbbrief_med.sql` : Contient le dump SQL pour créer la base de données.

## docs

Contient les différentes documentations :
- `DATABASE.md` : Documentation sur la base de données
- `FUNCTION.md` : Documentation sur les fonctions utilisées
- `STRUCTURE.md` : Documentation descriptif des différents fichiers.

Répertoire `uml` contient le fichier source du schéma UML de la base de données (draw.io) `dbbrief_med-uml.drawio`. Le répertoire `export` contient les différentes images exportés du schéma UML.

Répertoire `slideshow` contient la présentation diaporama au format PDF ou PowerPoint du Brief.

## function

Répertoire contenant des fichiers de fonctions qui sont utilisés à travers le site. Ces fichiers conteniennent des fonctions réutilisables qui accomplissent des tâches spécifiques comme la manipulation de données, l'affichage de données...
Ces scripts sont inclus dans les pages en utilisant `require_once`.

## utilities

 Répertoire utilisé pour stocker des scripts qui fournissent des fonctionnalités communes et réutilisables à travers le site. Ces scripts sont inclus dans les pages du site en utilisant `require_once`. C’est une bonne pratique pour organiser le code de manière modulaire et réutilisable.

## Fichiers à la racine du site :
- `index.php` : Page d'accueil
- `contact.php` : Page de contact
- `cgu.php` : Page condition générale
- `mentions-legales.php` : Page mentions légales
- `produits.php` : Page produits
- `vie-privee.php` : Page vie privée