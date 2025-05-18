<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

$panier = $_SESSION['panier'] ?? [];
$total = 0;
$role = $_SESSION['role'] ?? 'client';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier - Time2Travel</title>
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/page_panier.css" />
  <script src="../js/base.js" defer></script>
  <style>
    .options-lignes {
      margin-top: 8px;
      font-size: 0.88em;
      line-height: 1.6;
      padding-left: 5px;
    }

    .options-lignes .opt-ligne {
      margin-bottom: 2px;
    }
  </style>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<h1>Votre panier</h1>
<div class="panier-container">
  <div class="container">

    <?php if (empty($panier)): ?>
      <p>Votre panier est vide.</p>
    <?php else: ?>
      <?php foreach ($panier as $index => $reservation): ?>
        <?php
          $titre = $reservation['titre'];
          $quantite = $reservation['nombre'];
          $date_depart = $reservation['date_depart'] ?? 'Non spécifiée';
          $options = $reservation['options'] ?? [];
          $prix_base = $reservation['prix_base'] ?? 0;
          $prix_total = $reservation['prix_total'] ?? 0;

          $total += $prix_total;
        ?>
        <div class="card carte-voyage">
          <div class="entete">
            <h2><?= htmlspecialchars($titre) ?></h2>
            <span class="prix"><?= number_format($prix_total, 2, ',', ' ') ?> €</span>
          </div>
          <div class="details">
            <p><strong>Date de départ :</strong> <?= htmlspecialchars($date_depart) ?></p>
            <p><strong>Nombre de voyageurs :</strong> <?= $quantite ?></p>
            <p><strong>Prix de base :</strong> <?= $prix_base ?> € × <?= $quantite ?> = <?= $prix_base * $quantite ?> €</p>

            <?php if (!empty($options)): ?>
              <p><strong>Options sélectionnées :</strong></p>
              <div class="options-lignes">
                <?php foreach ($options as $opt): ?>
                  <div class="opt-ligne">
                    <?= htmlspecialchars($opt['nom']) ?> · Qté <?= $opt['quantite'] ?> · <?= $opt['total_option'] ?> €
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <form action="supprimer_du_panier.php" method="post" style="margin-top: 10px;">
              <input type="hidden" name="index" value="<?= $index ?>">
              <button type="submit" class="btn-supprimer">🗑️ Supprimer</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>

  <?php
    $remise = 0;
    if ($role === 'vip' || $role === 'admin') {
      $remise = 0.10 * $total;
    }
    $total_final = $total - $remise;
  ?>

  <div class="card bulle-total">
    <h3>Détail de la commande</h3>
    <p><strong><?= count($panier) ?> voyage<?= count($panier) > 1 ? 's' : '' ?></strong> <span><?= number_format($total, 2, ',', ' ') ?> €</span></p>
    <hr>
    <?php if ($remise > 0): ?>
      <p><strong>Remise VIP (-10%) :</strong> -<?= number_format($remise, 2, ',', ' ') ?> €</p>
      <div class="total-commande">
        <strong>Total remise : </strong>
        <span class="prix-total"><?= number_format($total_final, 2, ',', ' ') ?> €</span>
      </div>
    <?php else: ?>
      <div class="total-commande">
        <strong>Total commande</strong>
        <span class="prix-total"><?= number_format($total, 2, ',', ' ') ?> €</span>
      </div>
    <?php endif; ?>

    <form method="POST" action="page_paiement.php">
      <input type="hidden" name="total" value="<?= number_format($total_final, 2, '.', '') ?>">
      <button class="btn-payer" type="submit">Valider et payer</button>
    </form>
    <a class="btn-ajouter" href="./page_accueil.php">Poursuivre mes achats</a>
  </div>
</div>

</body>
</html>
