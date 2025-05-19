<?php
session_start();
// On lit les voyages depuis le JSON
$voyages = json_decode(file_get_contents('../data/voyages.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Destinations</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/page_destination.css">
    <script src="../js/base.js" defer></script>
</head>
<body>
    <header>
        <?php require_once './partials/nav.php' ?>
    </header>
    <div class="left-section">
        <h1>Destinations</h1>
        <p class="definition">
            Découvrez toutes les incroyables destinations proposées par Time2Travel. Cliquez sur une destination pour plus de détails et commencer votre voyage à travers le temps et l'espace !
        </p>
    </div>
    
        <div class="right-section">
        <div class="destinations-container">
  <?php foreach ($voyages as $voyage): ?>
    <div class="bubble" style="background-image:url('../data/images/<?= htmlspecialchars($voyage['image']) ?>');">
        <div class="overlay">
            <a href="voyage.php?id=<?= htmlspecialchars($voyage['id']) ?>" class="button">Afficher ce voyage</a>
        </div>
        <div class="title"><?= htmlspecialchars($voyage['titre']) ?></div>
    </div>
  <?php endforeach; ?>
</div>

        </div>
    </div>
</body>
</html>

<?php include './partials/footer.php'; ?>

