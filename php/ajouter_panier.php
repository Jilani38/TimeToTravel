<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['voyage_id'] ?? null;
  $quantite = $_POST['nombre'] ?? 1;
  $options = $_POST['options'] ?? []; // tableau d'index

  if (!is_numeric($id) || !is_numeric($quantite) || $quantite < 1) {
    die("Erreur dans les données du formulaire.");
  }

  $id = (int) $id;
  $quantite = (int) $quantite;

  // Initialiser le panier si besoin
  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
  }

  // Nouvelle entrée dans le panier
  $_SESSION['panier'][] = [
    'id' => $id,
    'nombre' => $quantite,
    'options' => $options
  ];

  // Redirection vers la page panier
  header("Location: page_panier.php");
  exit();
} else {
  header("Location: page_destination.php");
  exit();
}
