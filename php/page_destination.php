<?php
// Démarre la session
session_start();

// Charge les données des voyages depuis le fichier JSON
$voyages = json_decode(file_get_contents('../data/voyages.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Destinations</title>
    <!-- Feuilles de style principales -->
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/page_destination.css">
    <!-- Script JS général -->
    <script src="../js/base.js" defer></script>
</head>
<body>
    <header>
        <!-- Inclusion de la barre de navigation -->
        <?php require_once './partials/nav.php' ?>
    </header>

    <!-- Colonne de gauche avec le titre et une description -->
    <div class="left-section">
        <h1>Destinations</h1>
        <p class="definition">
            Découvrez toutes les incroyables destinations proposées par Time2Travel. Cliquez sur une destination pour plus de détails et commencer votre voyage à travers le temps et l'espace !
        </p>
    </div>
    
    <!-- Colonne de droite avec l’affichage des bulles de voyages -->
    <div class="right-section">
        <div class="destinations-container">
            <?php foreach ($voyages as $voyage): ?>
                <!-- Carte de voyage sous forme de bulle avec image de fond -->
                <div class="bubble" style="background-image:url('../data/images/<?= htmlspecialchars($voyage['image']) ?>');">
                    <!-- Zone cliquable qui s'affiche au survol -->
                    <div class="overlay">
                        <a href="voyage.php?id=<?= htmlspecialchars($voyage['id']) ?>" class="button">Afficher ce voyage</a>
                    </div>
                    <!-- Titre du voyage affiché en bas de la bulle -->
                    <div class="title"><?= htmlspecialchars($voyage['titre']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

<?php
// Inclusion du pied de page
include './partials/footer.php';
?>
