<?php
// On lit les voyages depuis le JSON
$voyages = json_decode(file_get_contents('../data/voyages.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Destinations</title>
    <link rel="stylesheet" href="../css/page_destination.css">
</head>
<body>

    <header>
        <nav>
          <!-- <h1>Time to Travel</h1> -->
          <a href="./page_accueil.php">
            <img src="../img/accueil_logo.svg" alt="Time to Travel" />
          </a>
      
          <div>
            <a href="./page_de_recherche.php">Rechercher </a>
            
            <a href="./page_a_propos.php">À propos de nous</a>
            <a href="./page_profil.php">Mon profil</a>
            <a href="./page_connexion.php">Connexion</a>
            <a href="./page_inscription.php">Inscription</a>
            <a href="./page_panier.php">
                <img src="../img/panier_blanc.png" alt="panier" class="icone-panier" />
            </a>
            
          </div>
        </nav>
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
