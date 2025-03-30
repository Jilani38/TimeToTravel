<?php
session_start();

// Sécurité : admin uniquement
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../page_accueil.php');
    exit();
}


require_once('../../php_utils/csv_utilisateur.php');

$utilisateurs = read_utilisateur_csv('../../data/utilisateur.csv');



?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../../css/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/base.css" />
  <link rel="stylesheet" href="../../css/page_admin/index.css" />
  <script src="../../js/page_admin/index.js" defer></script>
  <title>Time to Travel - Utilisateur</title>
</head>

<body>
  <dialog id="image-modal">
    <button id="close-modal" title="Fermer">&times;</button>
    <img src="" alt="" />
  </dialog>

  <aside>
    <header>
      <a href="./index.php">
        <img src="../../img/logo.svg" alt="Time to Travel" />
      </a>
    </header>
    <nav>
      <a href="./index.php">Voyages</a>
      <a href="./utilisateur.php">Utilisateurs</a>
      <a href="../page_accueil.php">Retour au site</a>
      <a href="../deconnexion.php">Déconnexion</a>
    </nav>
  </aside>

  <main>
    <h1>Liste des utilisateurs</h1>
    <p>Bienvenue <?= htmlspecialchars($_SESSION['prenom'] ?? 'Admin') ?> 👋</p>

    <?php if (count($utilisateurs) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Prénom</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Date inscription</th>
          <th>Dern. connexion</th>
          <th>Tél</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
          <td><?= $utilisateur['id']; ?></td>
          <td><?= $utilisateur['prenom']; ?></td>
          <td><?= $utilisateur['nom']; ?></td>
          <td><?= $utilisateur['email']; ?></td>
          <td><?= $utilisateur['role']; ?></td>
          <td><?= $utilisateur['date_inscription']; ?></td>
          <td><?= $utilisateur['derniere_connexion']; ?></td>
          <td><?= $utilisateur['telephone']; ?></td>
          <td>
            <a href="./edit_utilisateur.php?id=<?= $utilisateur['id']; ?>" title="Modifier">
              <i data-lucide="pencil"></i>
            </a>
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

    const modal = document.querySelector("dialog");
    const closeBtn = document.getElementById("close-modal");

    if (modal && closeBtn) {
      closeBtn.addEventListener("click", () => modal.close());
    }
  </script>
</body>
</html>
