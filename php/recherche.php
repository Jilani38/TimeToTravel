<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$mot_cle = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

// Charger le JSON
$voyages = json_decode(file_get_contents(__DIR__ . '/../data/voyages.json'), true);

// Sécurité en cas d'erreur de lecture
if ($voyages === null) {
    die('Erreur de lecture du fichier voyages.json.');
}

$resultats = [];

if ($mot_cle !== '') {
    foreach ($voyages as $voyage) {
        $titre = $voyage['titre'] ?? '';
        $duree = $voyage['duree'] ?? '';
        $specs = $voyage['specificites'] ?? '';

        // Étapes > noms de lieux
        $etapes_texte = '';
        if (!empty($voyage['etapes']) && is_array($voyage['etapes'])) {
            $noms_lieux = array_map(function ($etape) {
                return $etape['position']['nom_lieu'] ?? '';
            }, $voyage['etapes']);
            $etapes_texte = implode(' ', $noms_lieux);
        }

        // Activités > noms et descriptions
        $activites_texte = '';
        if (!empty($voyage['activites']) && is_array($voyage['activites'])) {
            foreach ($voyage['activites'] as $activite) {
                $activites_texte .= ' ' . ($activite['nom'] ?? '') . ' ' . ($activite['description'] ?? '');
            }
        }

        // Regrouper tout le texte
        $texte = strtolower("$titre $duree $specs $etapes_texte $activites_texte");

        if (strpos($texte, $mot_cle) !== false) {
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
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/recherche.css" />

</head>
<body>
    <h1>Résultats pour "<?= htmlspecialchars($mot_cle) ?>"</h1>

    <?php if (empty($resultats)): ?>
        <p>Aucun voyage ne correspond à votre recherche.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($resultats as $voyage): ?>
            <li>
                <a href="voyage.php?id=<?= $voyage['id'] ?>" style="text-decoration: none; color: inherit;">
                    <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
                    <img src="../img/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>" width="200" />
                    <p><?= htmlspecialchars($voyage['specificites']) ?></p>
                    <p>Durée : <?= htmlspecialchars($voyage['duree']) ?> jours</p>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
