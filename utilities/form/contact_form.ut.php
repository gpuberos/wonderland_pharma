<section class="col-12 col-sm-8 m-auto">
  <h2 class="text-center">Formulaire de contact</h2>

  <form class="p-4 mb-5 " action="#" method="GET">
    <div class="col d-flex flex-column justify-content-center w-75 container">
      <div class="row row-cols-md-2 row-cols-1 mb-3">
        <div class="col">
          <label for="prenom" class="form-label">Prénom</label>
          <input type="text" class="form-control rounded-0" name="prenom" id="prenom">
        </div>
        <div class="col">
          <label for="nom" class="form-label">Nom</label>
          <input type="text" class="form-control rounded-0" name="nom" id="nom">
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control rounded-0" name="email" id="email">
      </div>
      <div class="mb-3">
        <label for="sujet" class="form-label">Sujet</label>
        <input type="text" class="form-control rounded-0" name="sujet" id="sujet">
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control rounded-0" id="message" name="message" rows="10"></textarea>
      </div>
      <div class="d-flex justify-content-center">
        <input type="submit" class="btn btn-primary rounded-0 bg-blue border-0">
      </div>
    </div>
  </form>

</section>

<?php

// Récupère la valeur du paramètre 'prenom', 'nom' ... dans l'URL
// En utilisant la superglobale $_GET pour récupérer les valeurs des paramètres spécifiés dans l’URL de la requête HTTP
// Vérifie si les clés 'prenom', 'nom', 'email', et 'sujet' existent dans $_GET avant d'y accéder
// isset — Détermine si une variable est déclarée et est différente de null
// filter_var — Filtre une variable avec un filtre spécifique
// FILTER_SANITIZE_EMAIL : Supprime tous les caractères sauf les lettres, chiffres, et !#$%&'*+-=?^_`{|}~@.[]. 

if ($prenom = isset($_GET['prenom'])) {
  $prenom = htmlspecialchars($_GET['prenom']);
} else {
  $prenom = null;
}

// Opérateur Ternaire
$nom = isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : null;
$email = isset($_GET['email']) ? filter_var(($_GET['email']), FILTER_SANITIZE_EMAIL) : null;
$sujet = isset($_GET['sujet']) ? htmlspecialchars($_GET['sujet']) : null;
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : null;

// Si on utilise ce code il affichera un warning
// $prenom = $_GET['prenom'];
// $nom = $_GET['nom'];
// $email = $_GET['email'];
// $sujet = $_GET['sujet'];
// $message = $_GET['message'];

// Vérification si les données saisies s'affichent
// var_dump($prenom);
// var_dump($nom);
// var_dump($email);
// var_dump($sujet);
// var_dump($message);

?>