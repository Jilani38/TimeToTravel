<?php
require('getapikey.php');

$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$statut = $_GET['status'] ?? '';
$control_recu = $_GET['control'] ?? '';

$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control_recu === $control_attendu) {
    if ($statut === "accepted") {
        echo "<h2>Paiement accepté ✅</h2>";
    } else {
        echo "<h2>Paiement refusé ❌</h2>";
    }
} else {
    echo "<h2>Erreur : contrôle invalide (tentative de triche ?) ⚠️</h2>";
}
?>
