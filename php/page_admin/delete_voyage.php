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

$id = $_GET['id'];
$voyages = json_decode(file_get_contents('../../data/voyages.json'), true);

// Recherche de l'index à supprimer
$index = null;
foreach ($voyages as $key => $v) {
  if ((string)$v['id'] === (string)$id) {
    $index = $key;
    break;
  }
}

if ($index === null) {
  header('Location: ./index.php');
  exit;
}

$voyage = $voyages[$index];

// Suppression de l'image associée (si elle existe)
$image_path = '../../data/images/' . $voyage['image'];
if (!empty($voyage['image']) && file_exists($image_path)) {
  unlink($image_path);
}

// Suppression du voyage du tableau
array_splice($voyages, $index, 1);

// Réécriture du JSON
file_put_contents('../../data/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ./index.php');
exit;
