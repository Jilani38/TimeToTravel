<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $prenom = trim($_POST['prenom']);
  $nom = trim($_POST['nom']);
  $date_naissance = $_POST['date_naissance'];
  $genre = $_POST['genre'];
  $email = trim($_POST['email']);
  $motdepasse = $_POST['motdepasse'];
  $confirm_mdp = $_POST['confirm_mdp'];
  $date_inscription = date("Y-m-d");
  $derniere_connexion = "";
  $role = "client";
  $telephone = "";

  if ($motdepasse !== $confirm_mdp) {
    die("Les mots de passe ne correspondent pas !");
  }

  $chemin_csv = "../data/utilisateur.csv";
  $nouveau_fichier = !file_exists($chemin_csv) || filesize($chemin_csv) == 0;

  // 🔁 Étape 1 : vérification doublon avec lecture
  if (file_exists($chemin_csv)) {
    $f = fopen($chemin_csv, 'r');
    while (($ligne = fgetcsv($f, 1000, ';')) !== false) {
      if (isset($ligne[5]) && $ligne[5] === $email) {
        fclose($f);
        die("Cet email existe déjà !");
      }
    }
    fclose($f);
  }

  // 🔁 Étape 2 : écriture propre avec saut de ligne AVANT
  $fichier = fopen($chemin_csv, 'a');

  if ($nouveau_fichier) {
    fwrite($fichier, "id;prenom;nom;date_naissance;genre;email;motdepasse;date_inscription;derniere_connexion;role;telephone\n");
  }

  $motdepasse_hash = password_hash($motdepasse, PASSWORD_DEFAULT);
  $id = uniqid();

  $ligne = [
    $id,
    $prenom,
    $nom,
    $date_naissance,
    $genre,
    $email,
    $motdepasse_hash,
    $date_inscription,
    $derniere_connexion,
    $role,
    $telephone
  ];

  // On force un saut de ligne avant + point-virgule final
  fwrite($fichier, "\n" . implode(';', $ligne));

  fclose($fichier);

  header("Location: page_connexion.php");
  exit();
}
?>






<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_inscription.css" />
  </head>

  <body>
    <header>
      <?php require_once './partials/nav.php' ?>
    </header>

    <form action="page_inscription.php" method="post" class="card">
      <h2>Inscris-toi !</h2>

      <div class="input-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required />
      </div>

      <div class="input-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required />
      </div>

      <div class="input-group">
        <label for="date_naissance">Date de naissance :</label>
        <input
          type="date"
          id="date_naissance"
          name="date_naissance"
          value="2003-12-23"
          max="2007-01-01"
          required
        />
      </div>

      <div class="input-group">
        <label>Genre :</label>
        <div class="radio-group">
          <input type="radio" id="homme" name="genre" value="Homme" checked />
          <label for="homme">Homme</label>
          <input type="radio" id="femme" name="genre" value="Femme" />
          <label for="femme">Femme</label>
        </div>
      </div>

      <div class="input-group">
        <label for="email">Adresse mail :</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="input-group">
        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" required />
      </div>

      <div class="input-group">
        <label for="confirm_mdp">Confirmer mot de passe :</label>
        <input type="password" id="confirm_mdp" name="confirm_mdp" required />
      </div>

      <button type="submit" class="btn-primary">Créer mon compte</button>
      <a href="page_connexion.php" class="btn-secondary">
        J'ai déjà un compte
      </a>
    </form>
  </body>
</html>
