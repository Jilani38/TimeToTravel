<?php
session_start();
require('getapikey.php');

if (!isset($_GET['status']) || !isset($_GET['transaction']) || !isset($_GET['montant']) || !isset($_GET['vendeur']) || !isset($_GET['control'])) {
  die("Erreur : paramètres manquants.");
}

// Récupération des données
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

// On vérifie si le paiement est accepté
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
</head>
<body>

<header>
  <nav>
    <a href="./page_accueil.php">
      <img src="../img/accueil_logo.svg" alt="Time to Travel" />
    </a>
  </nav>
</header>

<main class="panier-container">
  <div class="container">

    <?php if ($paiement_accepte && !empty($panier)): ?>
      <h1>🎉 Merci pour votre commande !</h1>
      <p>Voici le récapitulatif :</p>

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
            <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
          </div>
        </div>
      <?php endforeach; ?>

      <hr>
      <h2>Total payé : <?= $total ?> €</h2>

    <?php else: ?>
      <h1>❌ Paiement refusé</h1>
      <p>Votre commande n'a pas pu être validée.</p>
    <?php endif; ?>

    <a href="page_accueil.php" class="btn-ajouter">Retour à l'accueil</a>
  </div>
</main>

</body>
</html>

<?php
if ($paiement_accepte) {
  unset($_SESSION['panier']);
}
?>
