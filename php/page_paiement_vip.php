<?php
// Démarre la session pour accéder à l'utilisateur connecté
session_start();

// Importe la fonction pour obtenir la clé API en fonction du vendeur
require('getapikey.php');

// Vérifie que l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

// Définition des paramètres du paiement
$montant = 1500.00;
$transaction = uniqid(); // identifiant unique de transaction
$vendeur = "MI-5_H";
$id = $_SESSION['id'];
$retour = "http://localhost:8000/php/retour_vip.php?id=$id";

// Génère la clé API et calcule la valeur de contrôle attendue
$api_key = getAPIKey($vendeur);
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

<!-- En-tête avec barre de navigation -->
<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<!-- Contenu principal : récapitulatif de l'abonnement VIP -->
<div class="container card">
  <h2>Abonnement VIP - Récapitulatif</h2>
  <p>👑 En devenant VIP Traveller, vous bénéficierez de <strong>-10% sur toutes vos futures commandes</strong>.</p>
  <p>Le montant de l'abonnement est de <strong>1500 €</strong>.</p>

  <!-- Formulaire de paiement vers la plateforme CY Bank -->
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

<?php
// Pied de page
include './partials/footer.php';
?>
