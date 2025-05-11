<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

$utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);
$utilisateur = null;
foreach ($utilisateurs as $u) {
  if ($u['id'] === $_SESSION['id']) {
    $utilisateur = $u;
    break;
  }
}

if (!$utilisateur) {
  die("Utilisateur non trouvé.");
}

$commandes = $utilisateur['commandes'] ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon tableau de bord</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <script defer src="../js/dashboard.js"></script>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="dashboard">
    <h1>Bienvenue, <?= htmlspecialchars($utilisateur['prenom']) ?> !</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <p class="success-message">✅ Profil mis à jour avec succès.</p>
    <?php endif; ?>

    <div class="onglets">
      <button class="onglet-actif" data-target="#profil">Mon profil</button>
      <button data-target="#commandes">Mes commandes</button>
    </div>

    <section id="profil" class="onglet-section actif">
      <h2>Informations personnelles</h2>
      <ul id="profil-statique">
        <li><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['nom']) ?></li>
        <li><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['prenom']) ?></li>
        <li><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email']) ?></li>
        <li><strong>Téléphone :</strong> <?= htmlspecialchars($utilisateur['telephone']) ?></li>
        <li><strong>Date de naissance :</strong> <?= htmlspecialchars($utilisateur['date_naissance']) ?></li>
        <li><strong>Genre :</strong> <?= htmlspecialchars($utilisateur['genre']) ?></li>
        <li><strong>Inscrit depuis :</strong> <?= htmlspecialchars($utilisateur['date_inscription']) ?></li>
        <li><strong>Dernière connexion :</strong> <?= htmlspecialchars($utilisateur['derniere_connexion']) ?></li>
      </ul>

      <button id="btn-editer-profil" class="btn-secondary">✏️ Modifier mes informations</button>

      <form id="form-profil" class="profil-formulaire" method="POST" action="update_profil.php" style="display: none;">
        <label>Prénom :
          <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']) ?>" required>
        </label>

        <label>Nom :
          <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>
        </label>

        <label>Email :
          <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" readonly>
        </label>

        <label>Téléphone :
          <input type="tel" name="telephone" value="<?= htmlspecialchars($utilisateur['telephone']) ?>">
        </label>

        <label>Date de naissance :
          <input type="date" name="date_naissance" value="<?= htmlspecialchars($utilisateur['date_naissance']) ?>">
        </label>

        <label>Genre :
          <select name="genre">
            <option value="Homme" <?= $utilisateur['genre'] === 'Homme' ? 'selected' : '' ?>>Homme</option>
            <option value="Femme" <?= $utilisateur['genre'] === 'Femme' ? 'selected' : '' ?>>Femme</option>
          </select>
        </label>

        <div class="profil-actions">
          <button type="submit" class="btn-primary">💾 Enregistrer</button>
          <button type="button" onclick="annulerEdition()" class="btn-error">Annuler</button>
        </div>
      </form>
    </section>

    <section id="commandes" class="onglet-section">
      <h2>Mes voyages réservés</h2>
      <?php if (empty($commandes)): ?>
        <p>Vous n'avez pas encore passé de commande.</p>
      <?php else: ?>
        <div class="cartes-commandes">
          <?php foreach ($commandes as $c): ?>
            <div class="carte-commande">
              <h3><?= htmlspecialchars($c['titre']) ?></h3>
              <p><strong>Date de commande :</strong> <?= htmlspecialchars($c['date']) ?></p>
              <?php if (!empty($c['date_depart'])): ?>
                <p><strong>Date de départ :</strong> <?= htmlspecialchars($c['date_depart']) ?></p>
              <?php endif; ?>
              <p><strong>Voyageurs :</strong> <?= (int)$c['voyageurs'] ?></p>
              <?php if (!empty($c['options'])): ?>
                <p><strong>Options :</strong><br><?= implode(", ", array_map(fn($opt) => htmlspecialchars($opt['nom']), $c['options'])) ?></p>
              <?php endif; ?>
              <p><strong>Montant total :</strong> <?= $c['total'] ?> €</p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
