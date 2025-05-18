<?php
session_start();

// Vérifie que l'utilisateur est admin et que la méthode est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

// Récupération des données JSON envoyées
$donnees = json_decode(file_get_contents('php://input'), true);
$id = $donnees['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit;
}

$fichier = '../../../data/utilisateurs.json';
$utilisateurs = json_decode(file_get_contents($fichier), true);

// Recherche de l'utilisateur
foreach ($utilisateurs as &$utilisateur) {
    if ((string)$utilisateur['id'] === (string)$id) {

        // Inversion de l'état : banni <-> client
        $nouveau_role = $utilisateur['role'] === 'banni' ? 'client' : 'banni';
        $utilisateur['role'] = $nouveau_role;

        file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));

        echo json_encode(['success' => true, 'nouveau_role' => $nouveau_role]);
        exit;
    }
}

// Si l'utilisateur n'est pas trouvé
echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
