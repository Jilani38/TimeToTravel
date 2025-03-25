<?php

function get_csv(string $path): array {
  $rows = file('../../data/voyages.csv');
  $names = str_getcsv($rows[0], ';');
  $csv = [];
  for($i = 1; $i < count($rows); $i++) {
    $row = str_getcsv($rows[$i], ';');
    for ($j = 0; $j < count($names); $j++) {
      $csv[$i - 1][$names[$j]] = $row[$j];
    }
  }
  return $csv;
}

$voyages = get_csv('../../data/voyages.csv');
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
            <td><?php echo $voyage['id']; ?></td>
            <td><?php echo $voyage['titre']; ?></td>
            <td><?php echo $voyage['date']; ?></td>
            <td><?php echo $voyage['lieu']; ?></td>
            <td>
              <button
                href="#"
                title="Voir l'image"
                data-image-modal-src="../../data/images/<?php echo $voyage['image']; ?>"
              >
                <i data-lucide="eye"></i>
              </button>
            </td>
            <td>
              <a href="./edit_voyage.php?id=<?php echo $voyage['id']; ?>" title="Modifier">
                <i data-lucide="pencil"></i>
              </a>
              <a href="#" title="Supprimer">
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
