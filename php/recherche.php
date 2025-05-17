<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$mot_cle = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';
$voyages = json_decode(file_get_contents(__DIR__ . '/../data/voyages.json'), true);
if ($voyages === null) die('Erreur de lecture du fichier voyages.json.');

function texte_complet_du_voyage(array $v): string {
    $contenu = [
        $v['titre'] ?? '',
        $v['description'] ?? '',
        $v['lieu'] ?? '',
        $v['type_temporel'] ?? '',
        $v['niveau_difficulte'] ?? '',
        $v['note_moyenne'] ?? '',
        $v['nombre_avis'] ?? '',
        implode(' ', $v['public_cible'] ?? []),
        implode(' ', $v['infos_pratiques'] ?? [])
    ];

    foreach ($v['programme'] ?? [] as $p) {
        $contenu[] = $p['titre'] ?? '';
        $contenu[] = $p['activite'] ?? '';
    }

    foreach ($v['activites_incluses'] ?? [] as $a) {
        $contenu[] = $a['nom'] ?? '';
        $contenu[] = $a['description'] ?? '';
    }

    foreach ($v['options'] ?? [] as $o) {
        $contenu[] = $o['type'] ?? '';
        $contenu[] = $o['nom'] ?? '';
    }

    return strtolower(implode(' ', $contenu));
}

$resultats = [];
if ($mot_cle !== '') {
    foreach ($voyages as $voyage) {
        if (strpos(texte_complet_du_voyage($voyage), $mot_cle) !== false) {
            $resultats[] = $voyage;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Résultats de recherche</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/recherche.css">
  <script src="../js/base.js" defer></script>
</head>
<body>

  <h1>Résultats pour "<?= htmlspecialchars($mot_cle) ?>"</h1>

  <?php if (empty($resultats)): ?>
    <p>Aucun voyage ne correspond à votre recherche.</p>
  <?php else: ?>
    <ul class="resultats-list">
      <?php foreach ($resultats as $voyage): ?>
        <li class="carte-voyage">
          <a href="voyage.php?id=<?= $voyage['id'] ?>">
            <img src="../data/images/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>">
            <div class="texte">
              <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
              <p><?= htmlspecialchars($voyage['description'] ?? '') ?></p>
              <p><strong>Durée :</strong> <?= htmlspecialchars($voyage['duree']) ?> jours</p>
            </div>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</body>
</html>
