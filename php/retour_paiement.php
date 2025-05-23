<?php
session_start();
require('getapikey.php');

// Vérifie que tous les paramètres nécessaires sont présents
if (!isset($_GET['status'], $_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['control'])) {
  die("Erreur : paramètres manquants.");
}

// Récupération des paramètres GET
$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$statut = $_GET['status'];
$control_recu = $_GET['control'];

// Recalcul de la valeur de contrôle attendue
$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

// Vérifie l'intégrité du paiement
if ($control_recu !== $control_attendu) {
  die("Erreur : contrôle de sécurité invalide.");
}

$paiement_accepte = ($statut === "accepted");

// Récupération des données nécessaires
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'] ?? [];
$total = 0;
$isVIP = false;

// Si le paiement est accepté et qu'on a une session valide avec panier
if ($paiement_accepte && isset($_SESSION['id']) && !empty($panier)) {
  $utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);
  foreach ($utilisateurs as &$u) {
    if ($u['id'] === $_SESSION['id']) {

      // Vérifie si l'utilisateur est VIP
      if (isset($u['role']) && $u['role'] === 'vip') {
        $isVIP = true;
      }

      // Crée la section commandes si elle n'existe pas
      if (!isset($u['commandes'])) $u['commandes'] = [];

      // Traite chaque réservation du panier
      foreach ($panier as $reservation) {
        $id = $reservation['id'];
        $quantite = $reservation['nombre'];
        $options = $reservation['options'] ?? [];

        // Recherche du voyage par ID
        $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
        $voyage = reset($voyage);

        $prix_options = 0;
        $options_detail = [];

        // Calcule le coût total des options
        foreach ($options as $opt) {
          $prix_options += $opt['total_option'];
          $options_detail[] = [
            'type' => $opt['type'],
            'nom' => $opt['nom'],
            'quantite' => $opt['quantite'],
            'prix_par_personne' => $opt['prix_par_personne'],
            'total_option' => $opt['total_option']
          ];
        }

        // Calcule le prix total de cette réservation
        $sous_total = $voyage['prix_base'] * $quantite + $prix_options;
        if ($isVIP) {
          $sous_total *= 0.9; // Réduction de 10%
        }

        $total += $sous_total;

        // Enregistre la commande dans l'historique de l'utilisateur
        $u['commandes'][] = [
          'titre' => $voyage['titre'],
          'date' => date("Y-m-d"),
          'date_depart' => $reservation['date_depart'] ?? date("Y-m-d"),
          'voyageurs' => $quantite,
          'options' => $options_detail,
          'total' => round($sous_total, 2)
        ];
      }
      break;
    }
  }

  // Sauvegarde les données dans le fichier utilisateurs.json
  unset($u);
  file_put_contents("../data/utilisateurs.json", json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

  // Vide le panier
  unset($_SESSION['panier']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de commande</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/retour.css">
  <script src="../js/base.js" defer></script>
</head>
<body>

<header>
  <?php require_once './partials/nav.php'; ?>
</header>

<main class="panier-container">
  <div class="container">

    <?php if ($paiement_accepte && !empty($panier)): ?>
      <h1 class="success">🎉 Merci pour votre commande !</h1>
      <p class="message">Voici le récapitulatif de vos voyages :</p>

      <?php foreach ($panier as $reservation): ?>
        <?php
          $titre = $reservation['titre'];
          $quantite = $reservation['nombre'];
          $options = $reservation['options'] ?? [];
          $prix_base = $reservation['prix_base'];
          $prix_total = $reservation['prix_total'];

          $prix_total_reduit = $prix_total;
          if ($isVIP) {
            $prix_total_reduit *= 0.9;
          }
        ?>
        <div class="card carte-voyage">
          <div class="entete">
            <h2><?= htmlspecialchars($titre) ?></h2>
            <span class="prix"><?= number_format($prix_total_reduit, 2, ',', ' ') ?> €</span>
          </div>
          <div class="details">
            <p><strong>Nombre de voyageurs :</strong> <?= $quantite ?></p>
            <p><strong>Prix de base :</strong> <?= $prix_base ?> € × <?= $quantite ?> = <?= $prix_base * $quantite ?> €</p>

            <?php if (!empty($options)): ?>
              <p><strong>Options :</strong></p>
              <div class="options-lignes">
                <?php foreach ($options as $opt): ?>
                  <div class="opt-ligne">
                    <?= htmlspecialchars($opt['nom']) ?> · Qté <?= $opt['quantite'] ?> · <?= $opt['total_option'] ?> €
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <hr>
      <h2 style="text-align:center;">Total payé : <?= number_format($total, 2, ',', ' ') ?> €</h2>
      <?php if ($isVIP): ?>
        <p style="text-align:center; font-weight:bold; color:green;">✅ Vous avez bénéficié d'une réduction VIP de 10% !</p>
      <?php endif; ?>

    <?php else: ?>
      <h1 class="error">❌ Paiement refusé</h1>
      <p class="message">Votre commande n'a pas pu être validée.</p>
    <?php endif; ?>

    <div style="text-align:center;">
      <a href="page_accueil.php" class="btn-ajouter">Retour à l'accueil</a>
    </div>
  </div>
</main>

</body>
</html>

<?php include './partials/footer.php'; ?>
