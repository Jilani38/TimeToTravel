<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Accès réservé aux admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

// Vérifie si un ID est passé en GET
if (!isset($_GET['id'])) {
  header('Location: ./utilisateurs.php');
  exit;
}

require_once('../../php_utils/csv.php');
$utilisateurs = read_csv('../../data/utilisateur.csv');

// Recherche de l'utilisateur à modifier
$index = array_find_key($utilisateurs, fn($u) => $u['id'] == $_GET['id']);
if ($index === null || !isset($utilisateurs[$index])) {
  header('Location: ./utilisateurs.php');
  exit;
}
$utilisateur = $utilisateurs[$index];

// Traitement du formulaire
if (isset($_POST['submit'])) {
  $utilisateurs[$index]['prenom'] = $_POST['prenom'];
  $utilisateurs[$index]['nom'] = $_POST['nom'];
  $utilisateurs[$index]['email'] = $_POST['email'];
  $utilisateurs[$index]['role'] = $_POST['role'];
  $utilisateurs[$index]['telephone'] = $_POST['telephone'];

  write_csv($utilisateurs, '../../data/utilisateur.csv');

  // Redirection propre
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
  <title>Time to Travel - Éditer Utilisateur</title>
</head>
<body>
  <aside>
    <header>
      <a href="../page_accueil.php">
        <img src="../../img/logo.svg" alt="Time to Travel" />
      </a>
    </header>
    <nav>
      <a href="./index.php">Voyages</a>
      <a href="./utilisateur.php">Utilisateurs</a>
    </nav>
  </aside>

  <main>
    <form action="edit_utilisateur.php?id=<?= $_GET['id'] ?>" method="post">
      <table>
        <tr>
          <th>Prénom</th>
          <td><input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']); ?>" required /></td>
        </tr>
        <tr>
          <th>Nom</th>
          <td><input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']); ?>" required /></td>
        </tr>
        <tr>
          <th>Email</th>
          <td><input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']); ?>" required /></td>
        </tr>
        <tr>
          <th>Rôle</th>
          <td>
            <select name="role" required>
              <option value="client" <?= $utilisateur['role'] === 'client' ? 'selected' : '' ?>>Client</option>
              <option value="admin" <?= $utilisateur['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>Téléphone</th>
          <td><input type="text" name="telephone" value="<?= htmlspecialchars($utilisateur['telephone']); ?>" /></td>
        </tr>
      </table>
      <div>
        <input type="submit" name="submit" value="Enregistrer" />
        <a href="./utilisateurs.php">Annuler</a>
      </div>
    </form>
  </main>
</body>
</html>
