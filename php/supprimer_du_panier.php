<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['voyage_id'] ?? null;

  if (isset($_SESSION['panier'][$id])) {
    unset($_SESSION['panier'][$id]);
  }

  header("Location: page_panier.php");
  exit;
} else {
  header("Location: page_panier.php");
  exit;
}
