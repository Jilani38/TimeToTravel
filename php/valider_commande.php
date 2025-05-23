<?php
session_start(); // Démarre la session pour accéder au panier

// Vérifie que le panier existe et n'est pas vide
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
  header('Location: page_panier.php'); // Redirige vers le panier si vide
  exit;
}

// Charge les données des voyages depuis le fichier JSON
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier']; // Récupère le panier de la session
$total = 0; // Initialisation du total général
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de commande</title>
  <link rel="stylesheet" href="../css/valider_commande.css">
  <script src="../js/base.js" defer></script>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?> <!-- Inclusion de la barre de navigation -->
</header>

<main class="panier-container">
  <div class="container">
    <h1>🎉 Merci pour votre commande !</h1>
    <p>Voici le récapitulatif :</p>

    <?php foreach ($panier as $id => $quantite): ?>
      <?php
        // Recherche du voyage correspondant
        $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
        $voyage = reset($voyage); // Prend le premier résultat du filtre

        // Calcul du prix pour ce voyage
        $sous_total = $voyage['prix_base'] * $quantite;
        $total += $sous_total;
      ?>
      <div class="card carte-voyage">
        <div class="entete">
          <h2><?= htmlspecialchars($voyage['titre']) ?></h2>
          <span class="prix"><?= $sous_total ?> €</span>
        </div>
        <div class="details">
          <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
        </div>
      </div>
    <?php endforeach; ?>

    <hr>
    <h2>Total payé : <?= $total ?> €</h2>

    <a href="page_accueil.php" class="btn-ajouter">Retour à l'accueil</a>
  </div>
</main>

</body>
</html>

<?php
// Vide le panier après validation de la commande
unset($_SESSION['panier']);
?>
