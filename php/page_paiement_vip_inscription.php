<?php
// Démarre la session
session_start();

// Importe la fonction pour obtenir la clé API
require('getapikey.php');

// Vérifie que l'identifiant utilisateur est présent dans l'URL
if (!isset($_GET['id'])) {
  die("ID utilisateur manquant.");
}

// Préparation des données pour le paiement
$id_utilisateur = $_GET['id'];
$montant = 1500.00;
$vendeur = "MI-5_H";
$transaction = uniqid(); // identifiant unique de transaction
$retour = "http://localhost:8000/php/retour_vip_inscription.php?id=$id_utilisateur";

// Génère le contrôle de sécurité attendu
$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paiement VIP - Time2Travel</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/page_paiement.css">
  <script src="../js/base.js" defer></script>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="card vip-container">
    <div class="vip-header">
      <h2>👑 Abonnement VIP Traveleur</h2>
      <p>Profitez de -10% sur tous vos voyages pendant un an pour seulement <strong>1500 €</strong>.</p>
    </div>

    <!-- Formulaire vers la plateforme CY Bank -->
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST" class="payment-form">
      <!-- Données de la transaction à envoyer -->
      <input type="hidden" name="transaction" value="<?= $transaction ?>">
      <input type="hidden" name="montant" value="<?= $montant ?>">
      <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
      <input type="hidden" name="retour" value="<?= $retour ?>">
      <input type="hidden" name="control" value="<?= $control ?>">

      <!-- Case à cocher pour accepter les CGU -->
      <label class="cgu">
        <input type="checkbox" id="checkbox-cgu" required>
        J'accepte les <a href="#" target="_blank">conditions générales d'utilisation</a>
      </label>

      <!-- Bouton de paiement désactivé tant que la case n'est pas cochée -->
      <button type="submit" id="btn-payer" class="btn-primary submit-disabled" disabled>Payer 1500 €</button>
    </form>
  </main>

  <!-- Activation du bouton seulement si CGU cochée -->
  <script>
    const cgu = document.getElementById('checkbox-cgu');
    const bouton = document.getElementById('btn-payer');

    cgu.addEventListener('change', () => {
      bouton.disabled = !cgu.checked;
      bouton.classList.toggle('submit-disabled', !cgu.checked);
    });
  </script>
</body>
</html>

<?php
// Pied de page
include './partials/footer.php';
?>
