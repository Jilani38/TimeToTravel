<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: page_connexion.php");
    exit();
}

$chemin_csv = "../data/utilisateur.csv";
$fichier = fopen($chemin_csv, 'r+');

$utilisateurs = [];
$utilisateur = null;

// Récupérer l'entête du CSV
$entete = fgetcsv($fichier, 1000, ';');

// Récupération de tous les utilisateurs
while (($ligne = fgetcsv($fichier, 1000, ';')) !== FALSE) {
    if ($ligne[0] === $_SESSION['id']) {
        $utilisateur = $ligne;
    }
    $utilisateurs[] = $ligne;
}

if (!$utilisateur) {
    fclose($fichier);
    die("Erreur : Utilisateur introuvable.");
}

$mode_edition = isset($_GET['edit']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $date_naissance = $_POST['age'];
    $telephone = trim($_POST['tel']);

    // Mise à jour correcte des infos utilisateur
    foreach ($utilisateurs as $index => $u) {
        if ($u[0] === $_SESSION['id']) {
            $utilisateurs[$index][1] = $prenom;
            $utilisateurs[$index][2] = $nom;
            $utilisateurs[$index][3] = $date_naissance;
            $utilisateurs[$index][10] = $telephone;

            $_SESSION['prenom'] = $prenom;
            $_SESSION['nom'] = $nom;

            $utilisateur = $utilisateurs[$index]; // mise à jour propre de l'utilisateur actif
            break;
        }
    }

    rewind($fichier);
    ftruncate($fichier, 0);

    // Réécrire l'entête
    fputcsv($fichier, $entete, ';');

    // Réécrire tous les utilisateurs (correctement mis à jour)
    foreach ($utilisateurs as $u) {
        fputcsv($fichier, $u, ';');
    }

    fclose($fichier);

    header("Location: page_profil.php");
    exit();
}

fclose($fichier);
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/page_profil.css" />
  <script src="../js/base.js" defer></script>
  <title>Mon profil</title>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <div class="profil-container card">
    <h1>Mon profil</h1>

    <form id="profil" method="POST">
      <label for="nom">Nom :</label>
      <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($utilisateur[2]) ?>" <?= !$mode_edition ? 'readonly' : '' ?> />

      <label for="prenom">Prénom :</label>
      <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($utilisateur[1]) ?>" <?= !$mode_edition ? 'readonly' : '' ?> />

      <label for="email">Email :</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($utilisateur[5]) ?>" readonly />

      <label for="mdp">Mot de Passe :</label>
      <input type="password" id="mdp" name="mdp" value="********" readonly />

      <label for="age">Date de naissance :</label>
      <input type="date" id="age" name="age" value="<?= htmlspecialchars($utilisateur[3]) ?>" <?= !$mode_edition ? 'readonly' : '' ?> />

      <label for="tel">Téléphone :</label>
      <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($utilisateur[10]) ?>" <?= !$mode_edition ? 'readonly' : '' ?> />

      <?php if ($mode_edition): ?>
        <button type="submit" class="btn-primary">Enregistrer</button>
        <a href="page_profil.php" class="btn-error">Annuler</a>
      <?php else: ?>
        <a href="page_profil.php?edit=true" class="btn-primary">Modifier mon profil</a>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
