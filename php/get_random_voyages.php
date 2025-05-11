<?php
// Charger les voyages depuis le JSON
$voyagesData = file_get_contents('../data/voyages.json');
$voyages = json_decode($voyagesData, true);

// Sélectionner 4 voyages aléatoires
shuffle($voyages);
$randomVoyages = array_slice($voyages, 0, 4);

// Générer le HTML des cartes
foreach ($randomVoyages as $voyage) {
    $id = htmlspecialchars($voyage['id']);
    $titre = htmlspecialchars($voyage['titre']);
    $image = htmlspecialchars($voyage['image']);
    $lien = "http://localhost:8000/php/voyage.php?id=$id";

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
