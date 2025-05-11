<?php
session_start();
require('getapikey.php');

if (!isset($_GET['status']) || !isset($_GET['transaction']) || !isset($_GET['montant']) || !isset($_GET['vendeur']) || !isset($_GET['control'])) {
  die("Erreur : paramètres manquants.");
}

$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$statut = $_GET['status'];
$control_recu = $_GET['control'];

$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control_recu !== $control_attendu) {
  die("Erreur : contrôle de sécurité invalide.");
}

$paiement_accepte = ($statut === "accepted");
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de commande</title>
  <link rel="stylesheet" href="../css/valider_commande.css">
  <style>
    body {
      font-family: sans-serif;
      background-color: #f9f9f9;
      margin: 0;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: <?= $paiement_accepte ? '#2ecc71' : '#e74c3c' ?>;
    }
    .carte-voyage {
      background-color: #f0f0f0;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
    }
    .entete {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .prix {
      font-weight: bold;
      color: #2d89ef;
    }
    .btn-ajouter {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #2d89ef;
      color: white;
      border-radius: 8px;
      text-decoration: none;
    }
    .btn-ajouter:hover {
      background-color: #1b65b9;
    }
  </style>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<main class="panier-container">
  <div class="container">

    <?php if ($paiement_accepte && !empty($panier)): ?>
      <h1>🎉 Merci pour votre commande !</h1>
      <p style="text-align:center;">Voici le récapitulatif de vos voyages :</p>

      <?php foreach ($panier as $reservation): ?>
        <?php
          $id = $reservation['id'];
          $quantite = $reservation['nombre'];
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
        <div class="carte-voyage">
          <div class="entete">
            <h2><?= htmlspecialchars($voyage['titre']) ?></h2>
            <span class="prix"><?= $sous_total ?> €</span>
          </div>
          <div class="details">
            <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
            <?php if (!empty($texte_options)): ?>
              <p><strong>Options choisies :</strong><br><?= implode('<br>', $texte_options) ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <hr>
      <h2 style="text-align:center;">Total payé : <?= $total ?> €</h2>

    <?php else: ?>
      <h1>❌ Paiement refusé</h1>
      <p style="text-align:center;">Votre commande n'a pas pu être validée.</p>
    <?php endif; ?>

    <div style="text-align:center;">
      <a href="page_accueil.php" class="btn-ajouter">Retour à l'accueil</a>
    </div>
  </div>
</main>

</body>
</html>

<?php
if ($paiement_accepte) {
  unset($_SESSION['panier']);
}
?>