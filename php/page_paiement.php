<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('getapikey.php');

if (!isset($_SESSION['id']) || !isset($_POST['total']) || empty($_SESSION['panier'])) {
    header("Location: page_panier.php");
    exit();
}

$voyages = json_decode(file_get_contents("../data/voyages.json"), true);
$panier = $_SESSION['panier'];
$total = number_format((float)$_POST['total'], 2, '.', '');

$transaction = uniqid();
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
    <title>Paiement - Time2Travel</title>
</head>
<body>

<header>
    <?php require_once './partials/nav.php'; ?>
</header>

<div class="container card">
    <h2>Récapitulatif de votre commande</h2>

    <?php foreach ($panier as $reservation): ?>
        <?php
            $id = $reservation['id'];
            $quantite = $reservation['nombre'];
            $options_selectionnees = $reservation['options'] ?? [];
            $voyage = array_filter($voyages, fn($v) => $v['id'] == $id);
            $voyage = reset($voyage);

            $prix_options = 0;
            $texte_options = [];
            foreach ($options_selectionnees as $opt_index) {
                if (isset($voyage['options'][$opt_index])) {
                    $opt = $voyage['options'][$opt_index];
                    $prix_options += $opt['prix_par_personne'];
                    $texte_options[] = htmlspecialchars($opt['nom']) . " (" . $opt['prix_par_personne'] . " €)";
                }
            }
            $prix_unitaire = $voyage['prix_base'] + $prix_options;
            $sous_total = $prix_unitaire * $quantite;
        ?>
        <div class="bubble" style="--bg-url: url('../img/<?= $voyage['image'] ?>');">
           <div class="title"><?= htmlspecialchars($voyage['titre']) ?></div>
            <div class="details">
                <p><strong>Durée :</strong> <?= $voyage['duree'] ?> jours</p>
                <p><strong>Lieu :</strong> <?= htmlspecialchars($voyage['lieu']) ?></p>
                <p><strong>Quantité :</strong> <?= $quantite ?> voyageur<?= $quantite > 1 ? 's' : '' ?></p>
                <?php if (!empty($texte_options)): ?>
                    <p><strong>Options choisies :</strong><br><?= implode('<br>', $texte_options) ?></p>
                <?php endif; ?>
                <p><strong>Total :</strong> <?= $sous_total ?> €</p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="recap-final">
        <h3>Total global : <?= $total ?> €</h3>

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
