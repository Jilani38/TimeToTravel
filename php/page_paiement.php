<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('getapikey.php');

if (!isset($_SESSION['id']) || !isset($_POST['total']) || empty($_SESSION['panier'])) {
    header("Location: page_panier.php");
    exit();
}

// Charger les données des voyages
$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'];
$voyage = null;

// On récupère le premier voyage du panier pour l'afficher
foreach ($panier as $id => $qte) {
    foreach ($voyages as $v) {
        if ($v['id'] == $id) {
            $voyage = $v;
            break 2;
        }
    }
}

if (!$voyage) {
    echo "Erreur : voyage introuvable";
    exit();
}

// Infos paiement
$transaction = uniqid();
$montant = number_format((float)$_POST['total'], 2, '.', '');
$vendeur = "MI-5_H";
$session = $_SESSION['id'];
$retour = "http://localhost:8000/php/retour_paiement.php?session=$session";
$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/page_paiement.css">
    <title>Paiement - Time2Travel</title>
</head>
<body>

<header>
    <?php require_once './partials/nav.php'; ?>
</header>

<div class="container card">
    <h2>Paiement sécurisé</h2>

    <div class="bubble" style="background-image: url('../img/<?= $voyage['image'] ?>');">
        <div class="title"><?= htmlspecialchars($voyage['titre']) ?></div>
        <div class="details">
            <p><strong>Date début :</strong> <?= $voyage['etapes'][0]['date_arrivee'] ?></p>
            <p><strong>Date fin :</strong> <?= $voyage['etapes'][0]['date_depart'] ?></p>
            <p><strong>Lieu :</strong> <?= $voyage['etapes'][0]['position']['nom_lieu'] ?></p>
        </div>
    </div>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST" class="payment-form">
        <input type="hidden" name="transaction" value="<?= $transaction ?>">
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
        <input type="hidden" name="retour" value="<?= $retour ?>">
        <input type="hidden" name="control" value="<?= $control ?>">
        <button type="submit">Valider le paiement</button>
    </form>
</div>

</body>
</html>
