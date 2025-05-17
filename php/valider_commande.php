<?php
session_start();

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
  header('Location: page_panier.php');
  exit;
}

$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'];
$total = 0;
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
  <?php require_once './partials/nav.php'; ?>
</header>

<main class="panier-container">
  <div class="container">
    <h1>🎉 Merci pour votre commande !</h1>
    <p>Voici le récapitulatif :</p>

    <?php foreach ($panier as $id => $quantite): ?>
      <?php
        $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
        $voyage = reset($voyage);
        $sous_total = $voyage['prix_base'] * $quantite;
        $total += $sous_total;
      ?>
      <div class="carte-voyage">
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
// Nettoyage du panier
unset($_SESSION['panier']);
?>
