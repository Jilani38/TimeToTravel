<?php
// Démarre la session
session_start();

// Récupère la requête de recherche depuis l'URL (GET)
$q = isset($_GET['q']) ? $_GET['q'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Feuilles de style principales -->
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/page_recherche.css">
  <!-- Script JS général -->
  <script src="../js/base.js" defer></script>
  <title>Recherche de voyages temporels</title>
</head>
<body>
  <header>
    <!-- Inclusion de la barre de navigation -->
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main>
    <!-- Titre principal de la page -->
    <h1>Recherchez votre aventure temporelle</h1>

    <!-- Filtres de recherche (type, prix, durée, note) -->
    <div class="filtres">
      <!-- Champ de recherche, valeur pré-remplie avec la requête q -->
      <input type="search" id="recherche-input" placeholder="Rechercher un voyage..." value="<?= htmlspecialchars($q) ?>">

      <!-- Filtre sur le type temporel -->
      <select id="filtre-type-temporel">
        <option value="">Passé & Futur</option>
        <option value="passé">Passé</option>
        <option value="futur">Futur</option>
      </select>

      <!-- Filtre sur le prix -->
      <select id="filtre-prix">
        <option value="">Tous les prix</option>
        <option value="1">-10000€</option>
        <option value="2">10000€ - 20000€</option>
        <option value="3">+20000€</option>
      </select>

      <!-- Filtre sur la durée -->
      <select id="filtre-duree">
        <option value="">Toutes les durées</option>
        <option value="1">Court (≤4j)</option>
        <option value="2">Moyen (5-7j)</option>
        <option value="3">Long (≥8j)</option>
      </select>

      <!-- Filtre sur la note -->
      <select id="filtre-note">
        <option value="">Toutes les notes</option>
        <option value="4">4+ étoiles</option>
        <option value="3">3+ étoiles</option>
      </select>

      <!-- Bouton pour réinitialiser tous les filtres -->
      <button id="reset-filtres">Reset</button>
    </div>

    <!-- Boutons de tri -->
    <div class="actions-tri">
      <button data-tri="prix">Trier par Prix</button>
      <button data-tri="duree">Trier par Durée</button>
      <button data-tri="note">Trier par Note</button>
      <button data-tri="popularite">Trier par Popularité</button>
    </div>

    <!-- Conteneur des résultats de recherche (rempli dynamiquement en JS) -->
    <div class="resultats" id="resultats">
      <!-- Les cartes de voyages seront injectées ici par JS -->
    </div>
  </main>

  <!-- Script spécifique à la recherche -->
  <script src="../js/recherche.js"></script>
</body>
</html>

<?php
// Pied de page
include './partials/footer.php';
?>
