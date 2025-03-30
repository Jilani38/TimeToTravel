<?php
session_start();

// Sécurité : accès réservé aux administrateurs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit;
}

require_once('../../php_utils/csv.php');
$voyages = read_csv('../../data/voyages.csv');
$index = array_find_key($voyages, fn($v) => $v['id'] == $_GET['id']);
$voyage = $voyages[$index];

if (!isset($voyage)) {
  header('Location: ./index.php');
  exit;
}

// Suppression de l'image associée au voyage (optionnel)
$image_path = '../../data/images/' . $voyage['image'];
if (file_exists($image_path)) {
  unlink($image_path);
}

unset($voyages[$index]);
write_csv($voyages, '../../data/voyages.csv');
header('Location: ./index.php');
exit;
