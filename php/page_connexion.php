<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  $email = trim($_POST['email']);
  $motdepasse = $_POST['motdepasse'];
  $chemin_csv = "../data/utilisateur.csv";

  if (!file_exists($chemin_csv)) {
    die("Le fichier CSV n'existe pas !");
  }

  $fichier = fopen($chemin_csv, 'r+');
  $utilisateurs = [];

  $connecte = false;

  while (($ligne = fgetcsv($fichier, 1000, ';')) !== FALSE) {
    if ($ligne[5] === $email && password_verify($motdepasse, $ligne[6])) {
      $connecte = true;
      $_SESSION['id'] = $ligne[0];
      $_SESSION['prenom'] = $ligne[1];
      $_SESSION['nom'] = $ligne[2];
      $_SESSION['role'] = $ligne[9];

      $ligne[8] = date("Y-m-d H:i:s");
    }
    $utilisateurs[] = $ligne;
  }

  rewind($fichier);
  ftruncate($fichier, 0);
  foreach ($utilisateurs as $utilisateur) {
    fputcsv($fichier, $utilisateur, ';');
  }

  fclose($fichier);

  if ($connecte) {
    header("Location: page_profil.php");
    exit();
  } else {
    die("Email ou mot de passe incorrect.");
  }
}
?>



<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/page_connexion.css" />
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
          <a href="./page_a_propos.php">À propos de nous</a>
          <a href="./page_profil.php">Mon profil</a>
          <a href="./page_connexion.php">Connexion</a>
          <a href="./page_inscription.php">Inscription</a>
        </div>
      </nav>
    </header>

    <div class="login-container">
      <h2>Connecte-toi !</h2>

      <form action="page_connexion.php" method="POST">
        <div class="input-group">
          <label for="email">E-mail :</label>
          <input type="email" id="email" name="email" required />
        </div>

        <div class="input-group">
          <label for="motdepasse">Mot de passe :</label>
          <input type="password" id="motdepasse" name="motdepasse" required />
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>
      </form>

      <p class="register-link">
        <a href="page_inscription.php">Je n'ai pas de compte</a>
        <br />
        <a href="./page_admin/index.php">Admin</a>
      </p>
    </div>
  </body>
</html>
