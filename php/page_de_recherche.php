<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/page_recherche.css">
  <script src="../js/base.js" defer></script>
  <title>Recherche de voyages temporels</title>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>
  <main>
    <h1>Recherchez votre aventure temporelle</h1>
    <div class="filtres">
      <input type="search" id="recherche-input" placeholder="Rechercher un voyage...">
      <select id="filtre-type-temporel">
        <option value="">Passé & Futur</option>
        <option value="passé">Passé</option>
        <option value="futur">Futur</option>
      </select>
      <select id="filtre-prix">
        <option value="">Tous les prix</option>
        <option value="1">-1000€</option>
        <option value="2">1000€ - 2000€</option>
        <option value="3">+2000€</option>
      </select>
      <select id="filtre-duree">
        <option value="">Toutes les durées</option>
        <option value="1">Court (&le;4j)</option>
        <option value="2">Moyen (5-7j)</option>
        <option value="3">Long (&ge;8j)</option>
      </select>
      <select id="filtre-note">
        <option value="">Toutes les notes</option>
        <option value="4">4+ étoiles</option>
        <option value="3">3+ étoiles</option>
      </select>
      <button id="reset-filtres">Reset</button>
    </div>

    <div class="actions-tri">
      <button data-tri="prix">Trier par Prix</button>
      <button data-tri="duree">Trier par Durée</button>
      <button data-tri="note">Trier par Note</button>
      <button data-tri="popularite">Trier par Popularité</button>
    </div>

    <div class="resultats" id="resultats">
      <!-- Les cartes de voyages seront injectées ici par JS -->
    </div>
  </main>

  <script src="../js/recherche.js"></script>
</body>
</html>
