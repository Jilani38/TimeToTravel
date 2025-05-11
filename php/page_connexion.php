<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);
  $motdepasse = $_POST['motdepasse'];
  $fichier = "../data/utilisateurs.json";

  if (!file_exists($fichier)) {
    die("Fichier utilisateurs non trouvé.");
  }

  $utilisateurs = json_decode(file_get_contents($fichier), true);
  $connecte = false;

  foreach ($utilisateurs as &$u) {
    if ($u['email'] === $email && password_verify($motdepasse, $u['motdepasse'])) {
      $connecte = true;

      $_SESSION['id'] = $u['id'];
      $_SESSION['prenom'] = $u['prenom'];
      $_SESSION['nom'] = $u['nom'];
      $_SESSION['role'] = $u['role'];

      $u['derniere_connexion'] = date("Y-m-d H:i:s");
      break;
    }
  }

  if ($connecte) {
    file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: page_accueil.php");
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
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_connexion.css" />
  </head>
  <body>
    <header>
      <?php require_once './partials/nav.php'; ?>
    </header>

    <div class="card login-container">
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
