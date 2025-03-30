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

  $fichier = fopen($chemin_csv, 'a+');

  // Ajouter la ligne d'entête si le fichier est vide
  if ($nouveau_fichier) {
    fputcsv($fichier, [
      "id", "prenom", "nom", "date_naissance", "genre", "email",
      "motdepasse", "date_inscription", "derniere_connexion", "role", "telephone"
    ], ';');
  }

  while (($ligne = fgetcsv($fichier, 1000, ';')) !== FALSE) {
    if ($ligne[5] === $email) {
      fclose($fichier);
      die("Cet email existe déjà !");
    }
  }

  $motdepasse_hash = password_hash($motdepasse, PASSWORD_DEFAULT);
  $id = uniqid();

  $file = fopen('../data/utilisateur.csv', 'a'); // 'a' = append
fputcsv($file, [
    $id,
    $_POST['prenom'],     // prénom
    $_POST['nom'],     // nom
    $_POST['date_naissance'],   // date de naissance
    $_POST['genre'],      // genre
    $_POST['email'],     // email
    $hashed_password, // mot de passe haché
    date('Y-m-d'),    // date inscription
    '',               // dernière connexion vide
    'client',         // rôle par défaut
    ''                // téléphone vide
], ';'); // séparateur ;

fclose($file);


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
    <link rel="stylesheet" href="../css/page_inscription.css" />
  </head>

  <body>
    <header>
      <nav>
        <!-- <h1>Time to Travel</h1> -->
        <a href="./page_accueil.php">
          <img src="../img/accueil_logo.svg" alt="Time to Travel" />
        </a>

        <div>
          <a href="./page_de_recherche.php">Rechercher</a>
          <a href="./page_admin/index.php">Admin</a>
          <a href="./page_a_propos.php">À propos de nous</a>
          <a href="./page_profil.php">Mon profil</a>
          <a href="./page_connexion.php">Connexion</a>
          <a href="./page_inscription.php">Inscription</a>
        </div>
      </nav>
    </header>

    <form action="page_inscription.php" method="post">
      <legend>Inscris-toi !</legend>

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