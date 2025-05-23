<?php
session_start();
session_destroy(); // détruit toutes les données de session
header("Location: page_accueil.php");
exit();
?>
<?php
// Démarre la session pour pouvoir la détruire
session_start();

// Détruit toutes les données stockées en session (déconnexion)
session_destroy();

// Redirige vers la page d'accueil
header("Location: page_accueil.php");
exit();
?>
