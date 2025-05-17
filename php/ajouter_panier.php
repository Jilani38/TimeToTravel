<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['voyage_id'] ?? null;
  $quantite = $_POST['nombre'] ?? 1;
  $options = $_POST['options'] ?? [];
  $date_depart = $_POST['date_depart'] ?? null;

  if (!is_numeric($id) || !is_numeric($quantite) || $quantite < 1 || !$date_depart) {
    die("Erreur dans les données du formulaire.");
  }

  $id = (int)$id;
  $quantite = (int)$quantite;

  // Récupération des données du voyage
  $voyages = json_decode(file_get_contents("../data/voyages.json"), true);
  $voyage = null;
  foreach ($voyages as $v) {
    if ((int)$v['id'] === $id) {
      $voyage = $v;
      break;
    }
  }

  if (!$voyage) {
    die("Voyage introuvable.");
  }

  // Prix de base
  $prix_total = $voyage['prix_base'] * $quantite;

  // Traitement des options
  $options_details = [];
  foreach ($options as $index => $nb_personnes) {
    $nb_personnes = (int)$nb_personnes;
    if ($nb_personnes > 0 && isset($voyage['options'][$index])) {
      $opt = $voyage['options'][$index];
      $total_option = $opt['prix_par_personne'] * $nb_personnes;

      $options_details[] = [
        'type' => $opt['type'],
        'nom' => $opt['nom'],
        'quantite' => $nb_personnes,
        'prix_par_personne' => $opt['prix_par_personne'],
        'total_option' => $total_option
      ];

      $prix_total += $total_option;
    }
  }

  // Ajout au panier
  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
  }

  $_SESSION['panier'][] = [
    'id' => $id,
    'titre' => $voyage['titre'],
    'nombre' => $quantite,
    'date_depart' => $date_depart,
    'prix_base' => $voyage['prix_base'],
    'options' => $options_details,
    'prix_total' => $prix_total
  ];

  header("Location: page_panier.php");
  exit();
} else {
  header("Location: page_destination.php");
  exit();
}
