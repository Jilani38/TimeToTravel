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
  <script src="../js/base.js" defer></script>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="voyage-container">
    <div class="image">
      <img src="../data/images/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>">
    </div>

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

      <h2>Options disponibles</h2>
      <form method="POST" action="ajouter_panier.php">
        <input type="hidden" name="voyage_id" value="<?= $voyage['id'] ?>">
        <?php foreach ($voyage['options'] as $index => $option): ?>
          <div class="option">
            <label for="option_<?= $index ?>">
              <?= htmlspecialchars($option['type']) ?> : <?= htmlspecialchars($option['nom']) ?> (<?= $option['prix_par_personne'] ?> € / personne)
            </label>
            <select name="options[<?= $index ?>]" id="option_<?= $index ?>" class="option-select" data-prix="<?= $option['prix_par_personne'] ?>">
              <option value="0">0</option>
              <!-- autres options générées par JS -->
            </select>
          </div>
        <?php endforeach; ?>

        <h2>Infos pratiques</h2>
        <ul>
          <?php foreach ($voyage['infos_pratiques'] as $info): ?>
            <li><?= htmlspecialchars($info) ?></li>
          <?php endforeach; ?>
        </ul>

        <h2>Tarif de base</h2>
        <p class="prix"><?= $voyage['prix_base'] ?> € / personne</p>

        <p><strong>Prix total estimé :</strong> <span id="prix-total"><?= $voyage['prix_base'] ?> €</span></p>

        <label for="date_depart">Date de départ :</label>
        <input type="date" name="date_depart" id="date_depart" min="<?= date('Y-m-d') ?>" required>

        <label for="nombre">Nombre de voyageurs :</label>
        <input type="number" name="nombre" id="nombre" value="1" min="1">

        <button type="submit">Je choisis ce voyage</button>
      </form>
    </div>
  </main>

  <script>
    const prixBase = <?= $voyage['prix_base'] ?>;
    const prixTotal = document.getElementById('prix-total');
    const nbInput = document.getElementById('nombre');
    const selectOptions = document.querySelectorAll('.option-select');

    function remplirSelects(max) {
      selectOptions.forEach(select => {
        const currentValue = parseInt(select.value) || 0;
        select.innerHTML = '<option value="0">0</option>';
        for (let i = 1; i <= max; i++) {
          const opt = document.createElement('option');
          opt.value = i;
          opt.textContent = i;
          select.appendChild(opt);
        }
        // Réappliquer l'ancienne valeur si possible
        if (currentValue <= max) {
          select.value = currentValue;
        }
      });
    }

    function recalculerPrix() {
      const nb = parseInt(nbInput.value) || 1;
      let total = prixBase * nb;

      selectOptions.forEach(select => {
        const quantite = parseInt(select.value) || 0;
        const prix = parseFloat(select.dataset.prix || 0);
        total += prix * quantite;
      });

      prixTotal.textContent = total.toFixed(2) + ' €';
    }

    nbInput.addEventListener('input', () => {
      const max = parseInt(nbInput.value) || 1;
      remplirSelects(max);
      recalculerPrix();
    });

    selectOptions.forEach(select => {
      select.addEventListener('change', recalculerPrix);
    });

    window.addEventListener('DOMContentLoaded', () => {
      remplirSelects(parseInt(nbInput.value) || 1);
      recalculerPrix();
    });
  </script>
</body>
</html>
