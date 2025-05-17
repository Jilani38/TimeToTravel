<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../page_accueil.php');
    exit();
}

$voyages = json_decode(file_get_contents('../../data/voyages.json'), true);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../../css/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/index.css" />
  <script src="https://unpkg.com/lucide@latest" defer></script>
  <script src="../../js/page_admin/index.js" defer></script>
  <title>Time to Travel - Admin</title>
</head>

<body>
<dialog id="image-modal">
  <button id="close-modal" title="Fermer">&times;</button>
  <img src="" alt="Aperçu de l'image" />
</dialog>

<?php require_once '../partials/admin-nav.php'; ?>

<main>
  <h1>Tableau de bord - Administration</h1>
  <p>Bienvenue <?= htmlspecialchars($_SESSION['prenom'] ?? 'Admin') ?> 👋</p>
  <a href="./creer_voyage.php" class="btn-ajouter-voyage">+ Créer un nouveau voyage</a>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Lieu</th>
        <th>Durée</th>
        <th>Type</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($voyages as $voyage): ?>
        <tr>
          <td><?= htmlspecialchars($voyage['id']) ?></td>
          <td><?= htmlspecialchars($voyage['titre']) ?></td>
          <td><?= htmlspecialchars($voyage['lieu'] ?? '—') ?></td>
          <td><?= htmlspecialchars($voyage['duree']) ?> jours</td>
          <td><?= htmlspecialchars($voyage['type_temporel'] ?? '—') ?></td>
          <td>
            <button title="Voir l'image"
                    data-image-modal-src="../../data/images/<?= htmlspecialchars($voyage['image']) ?>">
              <i data-lucide="eye"></i>
            </button>
          </td>
          <td>
            <a href="./edit_voyage.php?id=<?= $voyage['id']; ?>" title="Modifier">
              <i data-lucide="pencil"></i>
            </a>
            <a href="./delete_voyage.php?id=<?= $voyage['id']; ?>"
               title="Supprimer"
               onclick="return confirm('⚠️ Es-tu sûr de vouloir supprimer ce voyage ? Cette action est irréversible.');">
              <i data-lucide="trash-2"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
</body>
</html>
