<?php
session_start();

if (!isset($_SESSION['id'])) {
  header('Location: page_connexion.php');
  exit();
}

// Charger les utilisateurs
$chemin = '../data/utilisateurs.json';
$utilisateurs = json_decode(file_get_contents($chemin), true);

if (!is_array($utilisateurs)) {
  die("Erreur : le fichier utilisateurs.json est vide ou corrompu.");
}

$id = $_SESSION['id'];
$trouve = false;

// Recherche et mise à jour
foreach ($utilisateurs as &$u) {
  if ($u['id'] === $id) {
    $u['nom'] = trim($_POST['nom'] ?? $u['nom']);
    $u['prenom'] = trim($_POST['prenom'] ?? $u['prenom']);
    $u['email'] = trim($_POST['email'] ?? $u['email']);
    $u['telephone'] = trim($_POST['telephone'] ?? $u['telephone']);
    $u['date_naissance'] = trim($_POST['date_naissance'] ?? $u['date_naissance']);
    $u['genre'] = trim($_POST['genre'] ?? $u['genre']);

    // Mettre à jour la session
    $_SESSION['nom'] = $u['nom'];
    $_SESSION['prenom'] = $u['prenom'];
    $trouve = true;
    break;
  }
}
unset($u); // casser la référence

if ($trouve) {
  // Enregistrer dans le fichier
  file_put_contents($chemin, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header("Location: dashboard.php?success=1");
  exit();
} else {
  die("Utilisateur introuvable.");
}
