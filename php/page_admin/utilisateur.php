<?php
session_start();

$q = isset($_GET['q']) ? $_GET['q'] : '';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../page_accueil.php');
    exit();
}

$utilisateurs = json_decode(file_get_contents('../../data/utilisateurs.json'), true);

// Fonction pour format fr
function formatDateFr($dateIso) {
    $date = DateTime::createFromFormat('Y-m-d', $dateIso);
    return $date ? $date->format('d/m/Y') : '-';
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../../css/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/index.css" />
  <script src="../../js/page_admin/recherche.js" defer></script>
  <title>Time to Travel - Utilisateurs</title>
</head>

<body data-user-id="<?= htmlspecialchars($_SESSION['id']) ?>">
  <?php require_once '../partials/admin-nav.php'; ?>

  <main>
    <h1>Liste des utilisateurs</h1>
    <p>Bienvenue <?= htmlspecialchars($_SESSION['prenom'] ?? 'Admin') ?> 👋</p>

    <input type="search" id="recherche-input" placeholder="Rechercher un utilisateur..." value="<?= htmlspecialchars($q) ?>">

    <?php if (!empty($utilisateurs)): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Date d'inscription</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($utilisateurs as $utilisateur): ?>
          <tr data-user-id="<?= htmlspecialchars($utilisateur['id']) ?>">
            <td><?= htmlspecialchars($utilisateur['id']) ?></td>
            <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
            <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
            <td><?= htmlspecialchars($utilisateur['email']) ?></td>
            <td><span class="role"><?= htmlspecialchars($utilisateur['role']) ?></span></td>
            <td><?= formatDateFr($utilisateur['date_inscription'] ?? '') ?></td>
            <td>
              <a href="./edit_utilisateur.php?id=<?= urlencode($utilisateur['id']) ?>" title="Modifier infos">
                <i data-lucide="pencil"></i>
              </a>
              <?php if ($_SESSION['id'] !== $utilisateur['id']): ?>
                <button class="btn-bannir" title="Bannir ou réactiver">❌</button>
                <button class="btn-changer-role" title="Changer rôle">🔁</button>
              <?php else: ?>
                <span style="opacity: 0.5;">(vous)</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Aucun utilisateur enregistré.</p>
    <?php endif; ?>
  </main>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
  <script src="../../js/page_admin/utilisateur.js"></script>
</body>
</html>
