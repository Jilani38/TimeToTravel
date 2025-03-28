<?php
require_once('../../php_utils/csv.php');
$voyages = read_csv('../../data/voyages.csv');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../css/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/index.css" />
    <script src="../../js/page_admin/index.js" defer></script>
    <title>Time to Travel - Admin</title>
  </head>

  <body>
    <dialog>
      <img src="" alt="" />
    </dialog>
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
      <h1>Admin</h1>
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Titre</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($voyages as $voyage): ?>
          <tr>
            <td><?= $voyage['id']; ?></td>
            <td><?= $voyage['titre']; ?></td>
            <td><?= $voyage['date']; ?></td>
            <td><?= $voyage['lieu']; ?></td>
            <td>
              <button
                href="#"
                title="Voir l'image"
                data-image-modal-src="../../data/images/<?= $voyage['image']; ?>"
              >
                <i data-lucide="eye"></i>
              </button>
            </td>
            <td>
              <a href="./edit_voyage.php?id=<?= $voyage['id']; ?>" title="Modifier">
                <i data-lucide="pencil"></i>
              </a>
              <a href="./delete_voyage.php?id=<?= $voyage['id']; ?>" title="Supprimer">
                <i data-lucide="trash-2"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </main>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();
    </script>
  </body>
</html>
