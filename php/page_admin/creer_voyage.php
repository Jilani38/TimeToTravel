<?php
if (isset($_POST['submit'])) {
  require_once('../../php_utils/csv.php');
  $voyages = read_csv('../../data/voyages.csv');
  $voyage = [];

  if (!isset($voyage)) {
    header('Location: ./index.php');
    exit;
  }

  $voyage['id'] = max(array_column($voyages, 'id')) + 1;
  $voyage['titre'] = $_POST['titre'];
  $voyage['date'] = $_POST['date'];
  $voyage['lieu'] = $_POST['lieu'];
  if (!empty($_FILES['image']['name'])) {
    $info = pathinfo($_FILES['image']['name']);
    $filename = sprintf('%s.%s', $voyage['id'], $info['extension']);
    move_uploaded_file($_FILES['image']['tmp_name'], '../../data/images/' . $filename);
    $voyage['image'] = $filename;
  }
  $voyages[] = $voyage;
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
              <input type="text" name="titre" />
            </td>
          </tr>
          <tr>
            <th>Date</th>
            <td>
              <input type="text" name="date" />
            </td>
          </tr>
          <tr>
            <th>Lieu</th>
            <td>
              <input type="text" name="lieu" />
            </td>
          </tr>
          <tr>
            <th>Image</th>
            <td>
              <input type="file" name="image" accept="image/*" />
              <img src="" alt="" />
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
