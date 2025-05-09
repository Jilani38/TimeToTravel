<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier - Time2Travel</title>
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/page_panier.css" />
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<div class="panier-container">
  <div class="container">
    <h1>Votre panier</h1>

    <?php if (empty($panier)): ?>
      <p>Votre panier est vide.</p>
    <?php else: ?>
      <?php foreach ($panier as $id => $quantite): ?>
        <?php
          $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
          $voyage = reset($voyage);
          $sous_total = $voyage['prix_total'] * $quantite;
          $total += $sous_total;
        ?>
        <div class="carte-voyage">
  <div class="entete">
    <h2><?= htmlspecialchars($voyage['titre']) ?></h2>
    <span class="prix"><?= $sous_total ?> €</span>
  </div>
  <div class="details">
    <p><strong>Lieu :</strong> <?= htmlspecialchars($voyage['etapes'][0]['position']['nom_lieu']) ?></p>
    <p><strong>Dates :</strong> du <?= $voyage['etapes'][0]['date_arrivee'] ?> au <?= $voyage['etapes'][0]['date_depart'] ?></p>
    <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>

    <!-- bouton supprimer -->
    <form action="supprimer_du_panier.php" method="post" style="margin-top: 10px;">
      <input type="hidden" name="voyage_id" value="<?= $id ?>">
      <button type="submit" class="btn-supprimer">🗑️ Supprimer</button>
    </form>
  </div>
</div>

      <?php endforeach; ?>
    <?php endif; ?>

  </div>

  <div class="card bulle-total">
    <h3>Détail de la commande</h3>
    <p><strong><?= count($panier) ?> voyage<?= count($panier) > 1 ? 's' : '' ?></strong> <span><?= $total ?> €</span></p>
    <hr>
    <div class="total-commande">
      <strong>Total commande</strong>
      <span class="prix-total"><?= $total ?> €</span>
    </div>
    <form method="POST" action="page_paiement.php">
  <input type="hidden" name="total" value="<?= $total ?>">
      <button class="btn-payer" type="submit">Valider et payer</button>
    </form>
    <a class="btn-ajouter" href="./page_accueil.php">Poursuivre mes achats</a>
  </div>
</div>

</body>
</html>
