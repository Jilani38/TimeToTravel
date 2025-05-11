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

  $id = (int) $id;
  $quantite = (int) $quantite;

  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
  }

  $_SESSION['panier'][] = [
    'id' => $id,
    'nombre' => $quantite,
    'options' => $options,
    'date_depart' => $date_depart
  ];

  header("Location: page_panier.php");
  exit();
} else {
  header("Location: page_destination.php");
  exit();
}
