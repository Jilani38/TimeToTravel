<?php
$retour = $_SERVER['HTTP_REFERER'] ?? './index.php';

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Accès réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

// Vérifie si un ID est passé
if (!isset($_GET['id'])) {
  header('Location: ./utilisateur.php');
  exit;
}

// Charger les utilisateurs depuis le JSON
$utilisateurs = json_decode(file_get_contents('../../data/utilisateurs.json'), true);
$id = $_GET['id'];
$utilisateur = null;
$index = null;

// Recherche de l'utilisateur
foreach ($utilisateurs as $i => $u) {
  if ($u['id'] === $id) {
    $utilisateur = $u;
    $index = $i;
    break;
  }
}

if ($utilisateur === null) {
  header('Location: ./utilisateur.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $utilisateurs[$index]['prenom'] = trim($_POST['prenom']);
  $utilisateurs[$index]['nom'] = trim($_POST['nom']);
  $utilisateurs[$index]['email'] = trim($_POST['email']);
  $utilisateurs[$index]['telephone'] = trim($_POST['telephone']);
  $utilisateurs[$index]['role'] = $_POST['role'];

  if (!empty($_POST['nouveau_mdp'])) {
    if ($_POST['nouveau_mdp'] !== $_POST['confirmer_mdp']) {
      die("Erreur : les mots de passe ne correspondent pas.");
    }
    $utilisateurs[$index]['motdepasse'] = password_hash($_POST['nouveau_mdp'], PASSWORD_DEFAULT);
  }

  file_put_contents('../../data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: ./utilisateur.php');
  exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../../css/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/edit_voyage.css" />
  <script src="../../js/page_admin/edit_voyage.js" defer></script>
  <title>Modifier un utilisateur</title>
</head>
<body>
<?php require '../partials/admin-nav.php'; ?>

<main>
  <h1>Modifier un utilisateur</h1>
  <form method="POST">
    <table>
      <tr><th>Prénom</th><td><input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']) ?>" required></td></tr>
      <tr><th>Nom</th><td><input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required></td></tr>
      <tr><th>Email</th><td><input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required></td></tr>
      <tr><th>Téléphone</th><td><input type="text" name="telephone" value="<?= htmlspecialchars($utilisateur['telephone']) ?>"></td></tr>
      <tr><th>Rôle</th>
        <td>
          <select name="role" required>
            <option value="client" <?= $utilisateur['role'] === 'client' ? 'selected' : '' ?>>Client</option>
            <option value="admin" <?= $utilisateur['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </td>
      </tr>
      <tr><th>Mot de passe actuel (hash)</th><td><input type="text" readonly value="<?= htmlspecialchars($utilisateur['motdepasse']) ?>"></td></tr>
      <tr><th>Nouveau mot de passe</th><td><input type="password" name="nouveau_mdp" placeholder="Laisser vide si inchangé"></td></tr>
      <tr><th>Confirmer mot de passe</th><td><input type="password" name="confirmer_mdp"></td></tr>
    </table>

    <div>
      <input type="submit" name="submit" value="Enregistrer">
      <a href="<?= $retour ?>">Annuler</a>
    </div>
  </form>
</main>
</body>
</html>
