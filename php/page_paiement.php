<?php
// Démarrage de la session utilisateur
session_start();

// Active l'affichage des erreurs pour le debug (à retirer en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclusion de la fonction pour récupérer la clé API
require('getapikey.php');

// Vérifie que l'utilisateur est connecté, que le total est fourni et que le panier existe
if (!isset($_SESSION['id']) || !isset($_POST['total']) || empty($_SESSION['panier'])) {
    header("Location: page_panier.php");
    exit();
}

// Récupération des voyages disponibles et du panier de l'utilisateur
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'];

// Calcul du montant total brut (avant remise)
$role = $_SESSION['role'] ?? 'client';
$total_brut = 0;

foreach ($panier as $reservation) {
    $total_brut += $reservation['prix_total'] ?? 0;
}

// Application de la remise si l'utilisateur est VIP ou admin
$est_vip = in_array($role, ['vip', 'admin']);
$remise = $est_vip ? $total_brut * 0.10 : 0;
$total = $total_brut - $remise;

// Préparation des données pour le formulaire de paiement
$transaction = uniqid(); // identifiant unique de transaction
$vendeur = "MI-5_H";
$session = $_SESSION['id'];
$retour = "http://localhost:8000/php/retour_paiement.php?session=$session";
$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction . "#" . $total . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/page_paiement.css">
    <script src="../js/base.js" defer></script>
    <title>Paiement - Time2Travel</title>
    <style>
      /* Style interne spécifique aux options */
      .options-lignes {
        margin-top: 8px;
        font-size: 0.88em;
        line-height: 1.6;
        padding-left: 5px;
      }

      .opt-ligne {
        margin-bottom: 2px;
      }
    </style>
</head>
<body>

<!-- En-tête avec navigation -->
<header>
    <?php require_once './partials/nav.php'; ?>
</header>

<!-- Contenu principal : récapitulatif du panier et formulaire de paiement -->
<div class="container card">
    <h2>Récapitulatif de votre commande</h2>

    <!-- Affichage de chaque voyage du panier -->
    <?php foreach ($panier as $reservation): ?>
        <?php
            $titre = $reservation['titre'];
            $quantite = $reservation['nombre'];
            $options = $reservation['options'] ?? [];
            $prix_base = $reservation['prix_base'] ?? 0;
            $prix_total = $reservation['prix_total'] ?? 0;
        ?>
        <div class="bubble" style="--bg-url: url('../img/<?= $reservation['id'] ?>.jpg');">
            <div class="title"><?= htmlspecialchars($titre) ?></div>
            <div class="details">
                <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
                <p><strong>Prix de base :</strong> <?= $prix_base ?> € × <?= $quantite ?> = <?= $prix_base * $quantite ?> €</p>

                <?php if (!empty($options)): ?>
                    <p><strong>Options choisies :</strong></p>
                    <div class="options-lignes">
                      <?php foreach ($options as $opt): ?>
                        <div class="opt-ligne">
                          <?= htmlspecialchars($opt['nom']) ?> · Qté <?= $opt['quantite'] ?> · <?= $opt['total_option'] ?> €
                        </div>
                      <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <p><strong>Sous-total :</strong> <?= number_format($prix_total, 2, ',', ' ') ?> €</p>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Affichage du total et du formulaire de paiement -->
    <div class="recap-final">
        <h3>Sous-total global : <?= number_format($total_brut, 2, ',', ' ') ?> €</h3>
        <?php if ($est_vip): ?>
            <p><strong>Remise VIP (-10%) :</strong> -<?= number_format($remise, 2, ',', ' ') ?> €</p>
        <?php endif; ?>
        <h3>Total à régler : <?= number_format($total, 2, ',', ' ') ?> €</h3>

        <!-- Formulaire d'envoi vers la plateforme CY Bank -->
        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST" class="payment-form">
            <input type="hidden" name="transaction" value="<?= $transaction ?>">
            <input type="hidden" name="montant" value="<?= $total ?>">
            <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
            <input type="hidden" name="retour" value="<?= $retour ?>">
            <input type="hidden" name="control" value="<?= $control ?>">
            <button type="submit">Valider le paiement</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
// Inclusion du pied de page
include './partials/footer.php';
?>
