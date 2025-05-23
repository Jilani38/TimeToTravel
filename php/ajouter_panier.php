<?php
// Démarrage de la session pour utiliser le panier
session_start();

// Vérifie que le formulaire a été soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Récupération des données du formulaire
  $id = $_POST['voyage_id'] ?? null;
  $quantite = $_POST['nombre'] ?? 1;
  $options = $_POST['options'] ?? [];
  $date_depart = $_POST['date_depart'] ?? null;

  // Vérification de la validité des données
  if (!is_numeric($id) || !is_numeric($quantite) || $quantite < 1 || !$date_depart) {
    die("Erreur dans les données du formulaire.");
  }

  // Conversion des valeurs en entiers
  $id = (int)$id;
  $quantite = (int)$quantite;

  // Chargement de la liste des voyages depuis le fichier JSON
  $voyages = json_decode(file_get_contents("../data/voyages.json"), true);
  $voyage = null;

  // Recherche du voyage correspondant à l'identifiant
  foreach ($voyages as $v) {
    if ((int)$v['id'] === $id) {
      $voyage = $v;
      break;
    }
  }

  // Si aucun voyage correspondant n'a été trouvé
  if (!$voyage) {
    die("Voyage introuvable.");
  }

  // Calcul du prix de base (hors options)
  $prix_total = $voyage['prix_base'] * $quantite;

  // Traitement des options sélectionnées
  $options_details = [];
  foreach ($options as $index => $nb_personnes) {
    $nb_personnes = (int)$nb_personnes;

    // Vérifie que l’option est valide et qu’elle a une quantité > 0
    if ($nb_personnes > 0 && isset($voyage['options'][$index])) {
      $opt = $voyage['options'][$index];
      $total_option = $opt['prix_par_personne'] * $nb_personnes;

      // Ajoute les détails de l’option
      $options_details[] = [
        'type' => $opt['type'],
        'nom' => $opt['nom'],
        'quantite' => $nb_personnes,
        'prix_par_personne' => $opt['prix_par_personne'],
        'total_option' => $total_option
      ];

      // Ajoute le coût de l’option au prix total
      $prix_total += $total_option;
    }
  }

  // Création du panier si c’est la première commande
  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
  }

  // Ajout de la réservation actuelle au panier
  $_SESSION['panier'][] = [
    'id' => $id,
    'titre' => $voyage['titre'],
    'nombre' => $quantite,
    'date_depart' => $date_depart,
    'prix_base' => $voyage['prix_base'],
    'options' => $options_details,
    'prix_total' => $prix_total
  ];

  // Redirection vers la page panier après ajout
  header("Location: page_panier.php");
  exit();

} else {
  // Si on accède à la page sans soumettre le formulaire, redirection
  header("Location: page_destination.php");
  exit();
}
