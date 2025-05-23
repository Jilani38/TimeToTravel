<?php
session_start(); // Démarrage de la session pour accéder aux variables de session
require('getapikey.php'); // Inclusion de la fonction pour récupérer la clé API en fonction du vendeur

// Vérification que tous les paramètres attendus sont bien présents dans l'URL
if (!isset($_GET['status'], $_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['control'], $_GET['id'])) {
  die("Erreur : paramètres manquants."); // Interrompt le script si des données sont manquantes
}

// Récupération des paramètres de l'URL
$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$statut = $_GET['status'];
$control_recu = $_GET['control'];
$id_utilisateur = $_GET['id'];

// Calcul du hash de contrôle attendu pour vérifier l’intégrité de la requête
$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

// Vérification que le contrôle reçu correspond bien au contrôle attendu
if ($control_recu !== $control_attendu) {
  die("Erreur : contrôle de sécurité invalide.");
}

// Vérifie si le paiement a bien été accepté
$paiement_accepte = ($statut === "accepted");

// Si le paiement est validé, on met à jour l'utilisateur dans le fichier JSON
if ($paiement_accepte) {
  $utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);

  foreach ($utilisateurs as &$u) {
    // On cherche l’utilisateur correspondant à l’ID fourni
    if ($u['id'] === $id_utilisateur) {
      $u['role'] = 'vip'; // Mise à jour du rôle : devient VIP

      // Si le tableau des commandes n’existe pas encore, on le crée
      if (!isset($u['commandes'])) {
        $u['commandes'] = [];
      }

      // On ajoute une commande "Abonnement VIP" en tête de liste des commandes
      array_unshift($u['commandes'], [
        'titre' => "Abonnement VIP",
        'date' => date("Y-m-d"),
        'date_depart' => date("Y-m-d"),
        'voyageurs' => 1,
        'options' => [],
        'total' => (float)$montant
      ]);

      break; // On arrête la boucle après avoir mis à jour l'utilisateur
    }
  }
  unset($u); // Libération de la référence

  // Écriture des nouvelles données dans le fichier JSON
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
  <?php require_once './partials/nav.php'; ?> <!-- Inclusion de la barre de navigation -->
</header>

<main class="panier-container">
  <div class="container card">
    <?php if ($paiement_accepte): ?>
      <!-- Message en cas de succès du paiement -->
      <h1 class="success">🎉 Bienvenue parmi les VIP Travellers !</h1>
      <p class="message">Vous bénéficiez maintenant de -10% sur tous vos futurs voyages.</p>
    <?php else: ?>
      <!-- Message en cas d'échec du paiement -->
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

<?php include './partials/footer.php'; ?> <!-- Inclusion du pied de page -->
