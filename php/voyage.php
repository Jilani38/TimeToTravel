<?php
// voyage.php : Affichage complet d'un voyage

// Récupération de l'ID depuis l'URL
if (!isset($_GET['id'])) {
  die("ID du voyage manquant.");
}
$id = (int) $_GET['id'];

// Chargement du JSON des voyages
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);

// Recherche du voyage correspondant
$voyage = null;
foreach ($voyages as $v) {
  if ($v['id'] === $id) {
    $voyage = $v;
    break;
  }
}

if (!$voyage) {
  die("Voyage introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($voyage['titre']) ?></title>
  <link rel="stylesheet" href="../css/voyage.css">
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="voyage-container">
    <div class="image">
      <img src="../data/images/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>">
    </div>

    <div class="infos">
      <h1><?= htmlspecialchars($voyage['titre']) ?></h1>
      <p class="specificites"><?= htmlspecialchars($voyage['specificites']) ?></p>
      <h2>Programme</h2>
      <?php foreach ($voyage['etapes'] as $etape): ?>
        <div class="etape">
          <h3><?= htmlspecialchars($etape['titre']) ?> (<?= $etape['date_arrivee'] ?> au <?= $etape['date_depart'] ?>)</h3>
          <p><strong>Lieu :</strong> <?= htmlspecialchars($etape['position']['nom_lieu']) ?></p>
          <ul>
            <?php foreach ($etape['options'] as $option): ?>
              <li><?= $option['type'] ?> : <?= htmlspecialchars($option['nom']) ?> - <?= $option['prix_par_personne'] ?> €</li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>

      <h2>Activités</h2>
      <ul>
        <?php foreach ($voyage['activites'] as $act): ?>
          <li><strong><?= htmlspecialchars($act['nom']) ?>:</strong> <?= htmlspecialchars($act['description']) ?> (<?= $act['prix'] ?> €)</li>
        <?php endforeach; ?>
      </ul>

      <h2>Tarif</h2>
      <p class="prix"><?= $voyage['prix_total'] ?> € / personne</p>

      <form method="POST" action="ajouter_panier.php">
        <input type="hidden" name="voyage_id" value="<?= $voyage['id'] ?>">
        <label for="nombre">Nombre de voyageurs :</label>
        <input type="number" name="nombre" id="nombre" value="1" min="1">
        <button type="submit">Je choisis ce voyage</button>
      </form>
    </div>
  </main>
</body>
</html>
