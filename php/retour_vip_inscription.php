<?php
session_start(); // Démarre la session pour accéder aux infos de l'utilisateur
require('getapikey.php'); // Charge la fonction permettant de récupérer la clé API d’un vendeur

// Vérifie que tous les paramètres nécessaires sont bien présents dans l’URL
if (!isset($_GET['status'], $_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['control'], $_GET['id'])) {
  die("Erreur : paramètres manquants.");
}

// Récupère les paramètres GET de l’URL
$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$statut = $_GET['status'];
$control_recu = $_GET['control'];
$id_utilisateur = $_GET['id'];

// Calcule le contrôle attendu à partir des infos et de la clé API
$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

// Vérifie que le contrôle reçu correspond au contrôle attendu
if ($control_recu !== $control_attendu) {
  die("Erreur : contrôle de sécurité invalide.");
}

// Vérifie si le paiement a été accepté
$paiement_accepte = ($statut === "accepted");

// Si le paiement est accepté, on met à jour le rôle de l’utilisateur dans le JSON
if ($paiement_accepte) {
  $utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);

  foreach ($utilisateurs as &$u) {
    // Si on trouve l'utilisateur correspondant à l’ID transmis
    if ($u['id'] === $id_utilisateur) {
      $u['role'] = 'vip'; // Passe le rôle à VIP

      // Initialise le tableau des commandes si vide
      if (!isset($u['commandes'])) {
        $u['commandes'] = [];
      }

      // Ajoute une commande "Abonnement VIP" en début de liste
      array_unshift($u['commandes'], [
        'titre' => "Abonnement VIP",
        'date' => date("Y-m-d"),
        'date_depart' => date("Y-m-d"),
        'voyageurs' => 1,
        'options' => [],
        'total' => (float)$montant
      ]);

      // Met à jour la session avec les nouvelles données utilisateur
      $_SESSION['id'] = $u['id'];
      $_SESSION['prenom'] = $u['prenom'];
      $_SESSION['nom'] = $u['nom'];
      $_SESSION['role'] = $u['role'];
      break;
    }
  }
  unset($u); // Bonnes pratiques : libérer la référence
  // Sauvegarde les données utilisateurs mises à jour dans le JSON
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
  <?php require_once './partials/nav.php'; ?> <!-- Inclusion du menu de navigation -->
</header>

<main class="panier-container">
  <div class="container card">
    <?php if ($paiement_accepte): ?>
      <!-- Message de succès si le paiement a été accepté -->
      <h1 class="success">🎉 Bienvenue parmi les VIP Travellers !</h1>
      <p class="message">Vous bénéficiez maintenant de -10% sur tous vos futurs voyages.</p>
    <?php else: ?>
      <!-- Message d'erreur si le paiement a échoué -->
      <h1 class="error">❌ Paiement refusé</h1>
      <p class="message">Votre abonnement VIP n’a pas pu être validé.</p>
    <?php endif; ?>

    <div style="text-align:center;">
      <a href="page_accueil.php" class="btn-ajouter">Retour à l'accueil</a>
    </div>
  </div>
</main>

</body>
</html>

<?php include './partials/footer.php'; ?> <!-- Inclusion du footer -->
