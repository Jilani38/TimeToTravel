<?php
if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit;
}

require_once('../../php_utils/csv.php');
$voyages = read_csv('../../data/voyages.csv');
$index = array_find_key($voyages, fn($v) => $v['id'] == $_GET['id']);
$voyage = $voyages[$index];

if (!isset($voyage)) {
  header('Location: ./index.php');
  exit;
}

if (isset($_POST['submit'])) {
  $voyages[$index]['titre'] = $_POST['titre'];
  $voyages[$index]['date'] = $_POST['date'];
  $voyages[$index]['lieu'] = $_POST['lieu'];
  if (!empty($_FILES['image']['name'])) {
    $info = pathinfo($_FILES['image']['name']);
    $filename = sprintf('%s.%s', $voyage['id'], $info['extension']);
    move_uploaded_file($_FILES['image']['tmp_name'], '../../data/images/' . $filename);
    $voyages[$index]['image'] = $filename;
  }
  write_csv($voyages, '../../data/voyages.csv');
  header('Location: ./index.php');
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
        <a href="./voyages.php">Voyages</a>
        <a href="./utilisateurs.php">Utilisateurs</a>
      </nav>
    </aside>
    <main>
      <form action="" method="post" enctype="multipart/form-data">
        <table>
          <tr>
            <th>Titre</th>
            <td>
              <input type="text" name="titre" value="<?= $voyage['titre']; ?>" />
            </td>
          </tr>
          <tr>
            <th>Date</th>
            <td>
              <input type="text" name="date" value="<?= $voyage['date']; ?>" />
            </td>
          </tr>
          <tr>
            <th>Lieu</th>
            <td>
              <input type="text" name="lieu" value="<?= $voyage['lieu']; ?>" />
            </td>
          </tr>
          <tr>
            <th>Image</th>
            <td>
              <input type="file" name="image" accept="image/*" />
              <img
                src="../../data/images/<?= $voyage['image']; ?>"
                alt="Prise de la Bastille"
              />
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
