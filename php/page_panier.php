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
  <script src="../js/base.js" defer></script>
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
          $id = $reservation['id'];
          $quantite = $reservation['nombre'];
          $date_depart = $reservation['date_depart'] ?? 'Non spécifiée';
          $options_selectionnees = $reservation['options'] ?? [];

          $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
          $voyage = reset($voyage);

          $prix_options = 0;
          $texte_options = [];

          foreach ($options_selectionnees as $opt_index) {
            if (isset($voyage['options'][$opt_index])) {
              $opt = $voyage['options'][$opt_index];
              $prix_options += $opt['prix_par_personne'];
              $texte_options[] = htmlspecialchars($opt['nom']) . " (" . $opt['prix_par_personne'] . " €)";
            }
          }

          $prix_unitaire = $voyage['prix_base'] + $prix_options;
          $sous_total = $prix_unitaire * $quantite;
          $total += $sous_total;
        ?>
        <div class="card carte-voyage">
          <div class="entete">
            <h2><?= htmlspecialchars($voyage['titre']) ?></h2>
            <span class="prix"><?= $sous_total ?> €</span>
          </div>
          <div class="details">
            <p><strong>Lieu :</strong> <?= htmlspecialchars($voyage['lieu']) ?></p>
            <p><strong>Durée :</strong> <?= $voyage['duree'] ?> jours</p>
            <p><strong>Date de départ :</strong> <?= htmlspecialchars($date_depart) ?></p>
            <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
            <?php if (!empty($texte_options)): ?>
              <p><strong>Options :</strong><br><?= implode('<br>', $texte_options) ?></p>
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
