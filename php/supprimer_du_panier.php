<?php
session_start(); // On démarre la session pour accéder au panier

// Vérifie que la requête est bien envoyée en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $index = $_POST['index'] ?? null; // Récupère l’index de l’élément à supprimer

  // Vérifie que l’index est valide et existe dans le panier
  if (is_numeric($index) && isset($_SESSION['panier'][(int)$index])) {
    array_splice($_SESSION['panier'], (int)$index, 1); // Supprime l’élément à l’index donné
  }
}

// Redirige l'utilisateur vers la page du panier après suppression
header("Location: page_panier.php");
exit;
