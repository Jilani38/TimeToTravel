<?php
session_start();
require('getapikey.php');

if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

$montant = 1500.00;
$transaction = uniqid();
$vendeur = "MI-5_H";
$id = $_SESSION['id'];
$retour = "http://localhost:8000/php/retour_vip.php?id=$id";
$api_key = getAPIKey($vendeur);

// ✅ Calcule la vraie valeur de control
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paiement VIP</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/page_paiement.css">
  <script src="../js/base.js" defer></script>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<div class="container card">
  <h2>Abonnement VIP - Récapitulatif</h2>
  <p>👑 En devenant VIP Traveller, vous bénéficierez de <strong>-10% sur toutes vos futures commandes</strong>.</p>
  <p>Le montant de l'abonnement est de <strong>1500 €</strong>.</p>

  <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST" class="payment-form">
    <input type="hidden" name="transaction" value="<?= $transaction ?>">
    <input type="hidden" name="montant" value="<?= $montant ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <input type="hidden" name="retour" value="<?= $retour ?>">
    <input type="hidden" name="control" value="<?= $control ?>">
    <button type="submit">Valider et devenir VIP</button>
  </form>
</div>

</body>
</html>

<?php include './partials/footer.php'; ?>
