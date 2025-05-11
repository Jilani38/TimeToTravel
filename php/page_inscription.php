<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $fichier = "../data/utilisateurs.json";
  $utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

  $prenom = trim($_POST['prenom']);
  $nom = trim($_POST['nom']);
  $date_naissance = $_POST['date_naissance'];
  $genre = $_POST['genre'];
  $email = trim($_POST['email']);
  $motdepasse = $_POST['motdepasse'];
  $confirm_mdp = $_POST['confirm_mdp'];
  $telephone = trim($_POST['telephone']);

  if ($motdepasse !== $confirm_mdp) {
    die("Les mots de passe ne correspondent pas !");
  }

  foreach ($utilisateurs as $u) {
    if ($u['email'] === $email) {
      die("Cet email existe déjà !");
    }
  }

  $nouvel_utilisateur = [
    "id" => uniqid(),
    "prenom" => $prenom,
    "nom" => $nom,
    "date_naissance" => $date_naissance,
    "genre" => $genre,
    "email" => $email,
    "motdepasse" => password_hash($motdepasse, PASSWORD_DEFAULT),
    "telephone" => $telephone,
    "date_inscription" => date("Y-m-d"),
    "derniere_connexion" => date("Y-m-d H:i:s"),
    "role" => "client",
    "commandes" => []
  ];

  $utilisateurs[] = $nouvel_utilisateur;
  file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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
        <input type="date" id="date_naissance" name="date_naissance" required />
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
        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required />
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
      <a href="page_connexion.php" class="btn-secondary">J'ai déjà un compte</a>
    </form>
  </body>
</html>
