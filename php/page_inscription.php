<?php
// Démarre la session
session_start();

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $fichier = "../data/utilisateurs.json";

  // Lit le fichier JSON des utilisateurs s’il existe
  $utilisateurs = file_exists($fichier) ? json_decode(file_get_contents($fichier), true) : [];

  // Récupère les champs du formulaire
  $prenom = trim($_POST['prenom']);
  $nom = trim($_POST['nom']);
  $date_naissance = $_POST['date_naissance'];
  $genre = $_POST['genre'];
  $email = trim($_POST['email']);
  $motdepasse = $_POST['motdepasse'];
  $confirm_mdp = $_POST['confirm_mdp'];
  $telephone = trim($_POST['telephone']);

  // Vérifie que les mots de passe correspondent
  if ($motdepasse !== $confirm_mdp) {
    die("Les mots de passe ne correspondent pas !");
  }

  // Vérifie si l’email existe déjà
  foreach ($utilisateurs as $u) {
    if ($u['email'] === $email) {
      die("Cet email existe déjà !");
    }
  }

  // Crée le nouveau compte utilisateur
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

  // Ajoute le nouvel utilisateur au tableau
  $utilisateurs[] = $nouvel_utilisateur;

  // Sauvegarde dans le fichier JSON
  file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

  // Redirige selon le bouton cliqué
  if (isset($_POST['vip'])) {
    header("Location: page_paiement_vip_inscription.php?id=" . $nouvel_utilisateur['id']);
    exit();
  } else {
    header("Location: page_connexion.php");
    exit();
  }
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
    <script src="../js/base.js" defer></script>
  </head>

  <body>
    <header>
      <!-- Barre de navigation -->
      <?php require_once './partials/nav.php' ?>
    </header>

    <!-- Formulaire d’inscription -->
    <form action="page_inscription.php" method="post" class="card">
      <h2>Inscris-toi !</h2>

      <!-- Prénom -->
      <div class="input-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required />
      </div>

      <!-- Nom -->
      <div class="input-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required />
      </div>

      <!-- Date de naissance -->
      <div class="input-group">
        <label for="date_naissance">Date de naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" required />
      </div>

      <!-- Genre (radio) -->
      <div class="input-group">
        <label>Genre :</label>
        <div class="radio-group">
          <input type="radio" id="homme" name="genre" value="Homme" checked />
          <label for="homme">Homme</label>
          <input type="radio" id="femme" name="genre" value="Femme" />
          <label for="femme">Femme</label>
        </div>
      </div>

      <!-- Adresse mail -->
      <div class="input-group">
        <label for="email">Adresse mail :</label>
        <input type="email" id="email" name="email" required />
      </div>

      <!-- Téléphone -->
      <div class="input-group">
        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required />
      </div>

      <!-- Mot de passe -->
      <div class="input-group input-password">
        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" maxlength="20" required />
        <button type="button" class="toggle-password" title="Afficher/Masquer">👁️</button>
        <span class="char-count">0 / 20</span>
      </div>

      <!-- Confirmation mot de passe -->
      <div class="input-group input-password">
        <label for="confirm_mdp">Confirmer mot de passe :</label>
        <input type="password" id="confirm_mdp" name="confirm_mdp" maxlength="20" required />
        <button type="button" class="toggle-password" title="Afficher/Masquer">👁️</button>
        <span class="char-count">0 / 20</span>
      </div>

      <!-- CGU à accepter -->
      <div class="input-group cgu">
        <label>
          <input type="checkbox" id="accept-cgu" required />
          <span>En créant un compte, vous acceptez nos <a class="btn-cgu" href="../data/CGU_T2T.pdf" target="_blank">Conditions Générales d'Utilisation</a> et notre politique de confidentialité.</span>
        </label>
      </div>

      <!-- Boutons de soumission -->
      <button type="submit" name="vip" class="btn-vip" disabled>👑 Je veux devenir VIP Traveleur !</button>
      <button type="submit" class="btn-primary" disabled>Créer mon compte</button>

      <!-- Lien vers connexion -->
      <a href="page_connexion.php" class="btn-secondary">J'ai déjà un compte</a>
    </form>

    <!-- Script JS pour la validation -->
    <script src="../js/form_validation.js"></script>
  </body>
</html>

<?php
// Pied de page
include './partials/footer.php';
?>
