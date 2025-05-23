<?php
// Charge le contenu du fichier JSON contenant les voyages
$voyagesData = file_get_contents('../data/voyages.json');

// Décode les données JSON en tableau associatif
$voyages = json_decode($voyagesData, true);

// Mélange les voyages pour obtenir un ordre aléatoire
shuffle($voyages);

// Sélectionne les 4 premiers voyages après le mélange
$randomVoyages = array_slice($voyages, 0, 4);

// Génère le HTML pour chaque voyage sélectionné
foreach ($randomVoyages as $voyage) {
    // Sécurise les données pour éviter les injections HTML
    $id = htmlspecialchars($voyage['id']);
    $titre = htmlspecialchars($voyage['titre']);
    $image = htmlspecialchars($voyage['image']);

    // Crée le lien vers la page du voyage avec l'identifiant en paramètre
    $lien = "http://localhost:8000/php/voyage.php?id=$id";

    // Affiche une carte contenant le titre et un lien
    echo <<<HTML
<aside class="voyage-carte" style="background-image: url('/data/images/$image')">
  <span class="titre-visible">$titre</span>
  <div>
    <span class="titre-hover">$titre</span>
    <a href="$lien">Plus d'infos</a>
  </div>
</aside>
HTML;
}
