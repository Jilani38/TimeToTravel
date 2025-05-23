<?php
// Démarre la session pour gérer la connexion utilisateur
session_start();

// Variables pour l'affichage des erreurs et le champ email
$messageErreur = "";
$email = "";

// Vérifie si le formulaire a été soumis en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);  // Récupère l'email
  $motdepasse = $_POST['motdepasse'];  // Récupère le mot de passe
  $fichier = "../data/utilisateurs.json";  // Chemin vers le fichier JSON des utilisateurs

  // Vérifie que le fichier existe
  if (!file_exists($fichier)) {
    die("Fichier utilisateurs non trouvé.");
  }

  // Charge les utilisateurs depuis le fichier JSON
  $utilisateurs = json_decode(file_get_contents($fichier), true);

  $connecte = false;
  $messageErreur = "Email ou mot de passe incorrect.";

  // Parcours des utilisateurs pour vérifier les identifiants
  foreach ($utilisateurs as &$u) {
    // Vérifie email et mot de passe
    if ($u['email'] === $email && password_verify($motdepasse, $u['motdepasse'])) {

      // Refus si utilisateur banni
      if ($u['role'] === 'banni') {
        $messageErreur = "Votre compte a été banni. Connexion impossible.";
        break;
      }

      // Connexion réussie, création de la session
      $connecte = true;
      $_SESSION['id'] = $u['id'];
      $_SESSION['prenom'] = $u['prenom'];
      $_SESSION['nom'] = $u['nom'];
      $_SESSION['role'] = $u['role'];

      // Mise à jour de la date de dernière connexion
      $u['derniere_connexion'] = date("Y-m-d H:i:s");
      break;
    }
  }

  // Si la connexion est réussie, sauvegarde la modification dans le fichier JSON
  if ($connecte) {
    file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: page_accueil.php");  // Redirection vers la page d’accueil
    exit();
  } else {
    // Si la connexion a échoué
    $messageErreur = "Email ou mot de passe incorrect.";
  }
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion</title>
    <!-- Feuilles de style -->
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_connexion.css" />
    <!-- Script JS général -->
    <script src="../js/base.js" defer></script>
  </head>
  <body>
    <header>
      <!-- Barre de navigation -->
      <?php require_once './partials/nav.php'; ?>
    </header>

    <!-- Conteneur du formulaire de connexion -->
    <div class="card login-container">
      <h2>Connecte-toi !</h2>

      <!-- Affiche un message d’erreur si besoin -->
      <?php if ($messageErreur !== ""): ?>
        <span class="message-error">
          <?= $messageErreur ?>
        </span>
      <?php endif; ?>

      <!-- Formulaire de connexion -->
      <form action="page_connexion.php" method="POST">
        <div class="input-group">
          <label for="email">E-mail :</label>
          <input type="email" id="email" name="email" value="<?= $email ?>" required />
        </div>

        <div class="input-group input-password">
          <label for="motdepasse">Mot de passe :</label>
          <input type="password" id="motdepasse" name="motdepasse" maxlength="20" required <?= $email != "" ? 'autofocus' : '' ?> />
          <button type="button" class="toggle-password" title="Afficher/Masquer le mot de passe">👁️</button>
          <span class="char-count">0 / 20</span>
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>
      </form>

      <!-- Lien vers la page d'inscription -->
      <p class="register-link">
        <a href="page_inscription.php" class="btn-secondary">Je n'ai pas de compte</a>
        <br />
      </p>
    </div>

    <!-- Script JS pour la validation du formulaire -->
    <script src="../js/form_validation.js"></script>
  </body>
</html>
