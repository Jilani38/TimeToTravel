<?php
session_start();
require('getapikey.php');

if (!isset($_GET['status'], $_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['control'], $_GET['id'])) {
  die("Erreur : paramètres manquants.");
}

$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$statut = $_GET['status'];
$control_recu = $_GET['control'];
$id_utilisateur = $_GET['id'];

$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control_recu !== $control_attendu) {
  die("Erreur : contrôle de sécurité invalide.");
}

$paiement_accepte = ($statut === "accepted");

if ($paiement_accepte) {
  $utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);
  foreach ($utilisateurs as &$u) {
    if ($u['id'] === $id_utilisateur) {
      $u['role'] = 'vip';

      if (!isset($u['commandes'])) {
        $u['commandes'] = [];
      }

      array_unshift($u['commandes'], [
        'titre' => "Abonnement VIP",
        'date' => date("Y-m-d"),
        'date_depart' => date("Y-m-d"),
        'voyageurs' => 1,
        'options' => [],
        'total' => (float)$montant
      ]);

      break;
    }
  }
  unset($u);
  file_put_contents("../data/utilisateurs.json", json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statut VIP</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/retour.css">
  <script src="../js/base.js" defer></script>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<main class="panier-container">
  <div class="container card">
    <?php if ($paiement_accepte): ?>
      <h1 class="success">🎉 Bienvenue parmi les VIP Travellers !</h1>
      <p class="message">Vous bénéficiez maintenant de -10% sur tous vos futurs voyages.</p>
    <?php else: ?>
      <h1 class="error">❌ Paiement refusé</h1>
      <p class="message">Votre abonnement VIP n’a pas pu être validé.</p>
    <?php endif; ?>

    <div style="text-align:center;">
      <a href="dashboard.php" class="btn-ajouter">Retour à mon tableau de bord</a>
    </div>
  </div>
</main>

</body>
</html>

<?php include './partials/footer.php'; ?>

