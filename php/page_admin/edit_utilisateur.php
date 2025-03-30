<?php
session_start();

// Sécurité : accès réservé aux administrateurs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

if (!isset($_GET['id'])) {
  header('Location: ./utilisateurs.php');
  exit;
}

require_once('../../php_utils/csv.php');
$utilisateurs = read_csv('../../data/utilisateur.csv');
$index = array_find_key($utilisateurs, fn($u) => $u['id'] == $_GET['id']);
$utilisateur = $utilisateurs[$index];

if (!isset($utilisateur)) {
  header('Location: ./utilisateurs.php');
  exit;
}

if (isset($_POST['submit'])) {
  $utilisateurs[$index]['prenom'] = $_POST['prenom'];
  $utilisateurs[$index]['nom'] = $_POST['nom'];
  $utilisateurs[$index]['email'] = $_POST['email'];
  $utilisateurs[$index]['role'] = $_POST['role'];
  $utilisateurs[$index]['telephone'] = $_POST['telephone'];

  write_csv($utilisateurs, '../../data/utilisateur.csv');
  header('Location: ./utilisateurs.php');
  exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../css/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/edit_voyage.css" />
    <script src="../../js/page_admin/edit_voyage.js" defer></script>
    <title>Time to Travel - Edit Utilisateur</title>
  </head>

  <body>
    <aside>
      <header>
        <a href="./index.php">
          <img src="../../img/logo.svg" alt="Time to Travel" />
        </a>
      </header>
      <nav>
        <a href="./voyages.php">Voyages</a>
        <a href="./utilisateurs.php">Utilisateurs</a>
      </nav>
    </aside>
    <main>
      <form action="" method="post">
        <table>
          <tr>
            <th>Prénom</th>
            <td>
              <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']); ?>" />
            </td>
          </tr>
          <tr>
            <th>Nom</th>
            <td>
              <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']); ?>" />
            </td>
          </tr>
          <tr>
            <th>Email</th>
            <td>
              <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']); ?>" />
            </td>
          </tr>
          <tr>
            <th>Rôle</th>
            <td>
              <select name="role">
                <option value="client" <?= $utilisateur['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                <option value="admin" <?= $utilisateur['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
              </select>
            </td>
          </tr>
          <tr>
            <th>Téléphone</th>
            <td>
              <input type="text" name="telephone" value="<?= htmlspecialchars($utilisateur['telephone']); ?>" />
            </td>
          </tr>
        </table>
        <div>
          <input type="submit" name="submit" value="Enregistrer" />
          <a href="./utilisateur.php">Annuler</a>
        </div>
      </form>
    </main>
  </body>
</html>
