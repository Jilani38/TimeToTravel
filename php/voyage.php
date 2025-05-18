<?php
session_start();
if (!isset($_GET['id'])) {
  die("ID du voyage manquant.");
}
$id = (int) $_GET['id'];

$voyages = json_decode(file_get_contents("../data/voyages.json"), true);

$voyage = null;
foreach ($voyages as $v) {
  if ((int)$v['id'] === $id) {
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
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/voyage.css">
  <script defer src="../js/base.js"></script>
  <script defer src="../js/voyage.js"></script>
</head>

<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="voyage-container">
    <div class="ligne-haut">
      <!-- Colonne gauche : image -->
      <div class="colonne-gauche">
        <div class="image">
          <img src="../data/images/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>">
        </div>

        <!-- Infos en dessous de l’image uniquement -->
        <div class="card infos">
          <h1><?= htmlspecialchars($voyage['titre']) ?></h1>
          <p class="description"><?= htmlspecialchars($voyage['description']) ?></p>
          <p><strong>Lieu :</strong> <?= htmlspecialchars($voyage['lieu']) ?></p>
          <p><strong>Type :</strong> <?= htmlspecialchars($voyage['type_temporel']) ?></p>
          <p><strong>Durée :</strong> <?= $voyage['duree'] ?> jours</p>
          <p><strong>Niveau :</strong> <?= htmlspecialchars($voyage['niveau_difficulte']) ?></p>
          <p><strong>Public :</strong> <?= implode(", ", $voyage['public_cible']) ?></p>
          <p><strong>Note moyenne :</strong> <?= $voyage['note_moyenne'] ?> / 5 (<?= $voyage['nombre_avis'] ?> avis)</p>

          <h2>Programme</h2>
          <ul>
            <?php foreach ($voyage['programme'] as $jour): ?>
              <li><strong><?= htmlspecialchars($jour['titre']) ?>:</strong> <?= htmlspecialchars($jour['activite']) ?></li>
            <?php endforeach; ?>
          </ul>

          <h2>Activités incluses</h2>
          <ul>
            <?php foreach ($voyage['activites_incluses'] as $act): ?>
              <li><strong><?= htmlspecialchars($act['nom']) ?>:</strong> <?= htmlspecialchars($act['description']) ?></li>
            <?php endforeach; ?>
          </ul>

          <h2>Infos pratiques</h2>
          <ul>
            <?php foreach ($voyage['infos_pratiques'] as $info): ?>
              <li><?= htmlspecialchars($info) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Colonne droite : titre + personnalisation -->
      <div class="colonne-droite">
        <h1 class="titre-voyage-reservation"><?= htmlspecialchars($voyage['titre']) ?></h1>

        <div class="card reservation">
          <h2>Personnalisez votre voyage</h2>
          <form method="POST" action="ajouter_panier.php">
            <input type="hidden" name="voyage_id" value="<?= $voyage['id'] ?>">

            <label for="nombre"><strong>Nombre de voyageurs :</strong></label>
            <input type="number" name="nombre" id="nombre" value="1" min="1">

            <label for="date_depart"><strong>Date de départ :</strong></label>
            <input type="date" name="date_depart" id="date_depart" min="<?= date('Y-m-d') ?>" required>

            <h3>Options disponibles</h3>
            <?php foreach ($voyage['options'] as $index => $option): ?>
              <div class="option">
                <label for="option_<?= $index ?>">
                  <?= htmlspecialchars($option['type']) ?> : <?= htmlspecialchars($option['nom']) ?> (<?= $option['prix_par_personne'] ?> € / personne)
                </label>
                <select name="options[<?= $index ?>]" id="option_<?= $index ?>" class="option-select" data-prix="<?= $option['prix_par_personne'] ?>">
                  <option value="0">0</option>
                </select>
              </div>
            <?php endforeach; ?>

            <p class="prix-base"><strong>Tarif de base :</strong> <?= $voyage['prix_base'] ?> € / personne</p>
            <p class="total-prix">Prix total estimé : 
              <span id="prix-total" data-base="<?= $voyage['prix_base'] ?>"><?= $voyage['prix_base'] ?> €</span>
            </p>

            <button type="submit">Je choisis ce voyage</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
