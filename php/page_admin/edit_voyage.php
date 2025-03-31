<?php
session_start();

// Sécurité : accès réservé aux administrateurs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit;
}

$voyages = json_decode(file_get_contents('../../data/voyages.json'), true);
$index = array_search($_GET['id'], array_column($voyages, 'id'));

if ($index === false) {
  header('Location: ./index.php');
  exit;
}

$voyage = $voyages[$index];

// Traitement du formulaire
if (isset($_POST['submit'])) {
  $voyages[$index]['titre'] = $_POST['titre'];
  $voyages[$index]['etapes'][0]['date_arrivee'] = $_POST['date'];
  $voyages[$index]['etapes'][0]['position']['nom_lieu'] = $_POST['lieu'];

  // Image
  if (!empty($_FILES['image']['name'])) {
    $info = pathinfo($_FILES['image']['name']);
    $extension = strtolower($info['extension']);

    if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
      $filename = sprintf('%s.%s', $voyage['id'], $extension);
      move_uploaded_file($_FILES['image']['tmp_name'], '../../data/images/' . $filename);
      $voyages[$index]['image'] = $filename;
    } else {
      exit('Erreur : format invalide. Veuillez charger une image PNG ou JPEG.');
    }
  }

  // Sauvegarde
  file_put_contents('../../data/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: ./index.php');
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
  <title>Time to Travel - Edit Voyage</title>
</head>

<body>
  <aside>
    <header>
      <a href="./index.php">
        <img src="../../img/logo.svg" alt="Time to Travel" />
      </a>
    </header>
    <nav>
      <a href="./index.php">Voyages</a>
      <a href="./utilisateur.php">Utilisateurs</a>
    </nav>
  </aside>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <table>
        <tr>
          <th>Titre</th>
          <td>
            <input type="text" name="titre" value="<?= htmlspecialchars($voyage['titre']); ?>" />
          </td>
        </tr>
        <tr>
          <th>Date</th>
          <td>
            <input type="text" name="date" value="<?= htmlspecialchars($voyage['etapes'][0]['date_arrivee']); ?>" />
          </td>
        </tr>
        <tr>
          <th>Lieu</th>
          <td>
            <input type="text" name="lieu" value="<?= htmlspecialchars($voyage['etapes'][0]['position']['nom_lieu']); ?>" />
          </td>
        </tr>
        <tr>
          <th>Image</th>
          <td>
            <input type="file" name="image" accept="image/*" />
            <img src="../../data/images/<?= htmlspecialchars($voyage['image']); ?>" alt="<?= htmlspecialchars($voyage['titre']); ?>" />
          </td>
        </tr>
      </table>
      <div>
        <input type="submit" name="submit" value="Enregistrer" />
        <a href="./index.php">Annuler</a>
      </div>
    </form>
  </main>
</body>
</html>
