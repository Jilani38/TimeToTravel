<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['voyage_id'] ?? null;
  $quantite = $_POST['nombre'] ?? 1;

  if (!is_numeric($id) || !is_numeric($quantite) || $quantite < 1) {
    die("Erreur dans les données du formulaire.");
  }

  $id = (int) $id;
  $quantite = (int) $quantite;

  // Initialiser le panier si besoin
  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
  }

  // Ajouter ou incrémenter la quantité
  if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id] += $quantite;
  } else {
    $_SESSION['panier'][$id] = $quantite;
  }

  // Redirection vers la page panier
  header("Location: page_panier.php");
  exit();
} else {
  header("Location: page_destination.php");
  exit();
}
