<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $index = $_POST['index'] ?? null;

  if (is_numeric($index) && isset($_SESSION['panier'][(int)$index])) {
    array_splice($_SESSION['panier'], (int)$index, 1);
  }
}

header("Location: page_panier.php");
exit;
