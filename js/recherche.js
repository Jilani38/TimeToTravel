// Tableau qui contiendra tous les voyages chargés
const voyages = [];

// Chargement du fichier JSON contenant les voyages, puis déclenche les filtres
fetch('../data/voyages.json')
  .then(response => response.json())
  .then(data => {
    voyages.push(...data); // Ajoute les données dans le tableau
    appliquerFiltres();    // Applique les filtres au chargement
  });

// Sélection des éléments de filtrage et d'affichage
const rechercheInput = document.getElementById('recherche-input');
const filtreTypeTemporel = document.getElementById('filtre-type-temporel');
const filtrePrix = document.getElementById('filtre-prix');
const filtreDuree = document.getElementById('filtre-duree');
const filtreNote = document.getElementById('filtre-note');
const resetFiltresBtn = document.getElementById('reset-filtres');
const resultatsDiv = document.getElementById('resultats');

// Fonction pour appliquer les filtres selon les critères choisis
function appliquerFiltres() {
  let filtres = voyages;

  // Recherche par mot-clé (dans le titre ou le lieu)
  const search = rechercheInput.value.trim().toLowerCase();
  const url = new URL(window.location);
  if (search) {
    url.searchParams.set('q', search);
    filtres = filtres.filter(v =>
      v.titre.toLowerCase().includes(search) || v.lieu.toLowerCase().includes(search)
    );
  } else {
    url.searchParams.delete('q');
  }
  history.replaceState(null, '', url); // Met à jour l'URL sans recharger la page

  // Filtrage par type temporel (passé / futur)
  if (filtreTypeTemporel.value) {
    filtres = filtres.filter(v => v.type_temporel === filtreTypeTemporel.value);
  }

  // Filtrage par tranches de prix
  if (filtrePrix.value) {
    filtres = filtres.filter(v => {
      if (filtrePrix.value === '1') return v.prix_base <= 10000;
      if (filtrePrix.value === '2') return v.prix_base > 10000 && v.prix_base <= 20000;
      if (filtrePrix.value === '3') return v.prix_base > 20000;
    });
  }

  // Filtrage par durée
  if (filtreDuree.value) {
    filtres = filtres.filter(v => {
      if (filtreDuree.value === '1') return v.duree <= 4;
      if (filtreDuree.value === '2') return v.duree >= 5 && v.duree <= 7;
      if (filtreDuree.value === '3') return v.duree >= 8;
    });
  }

  // Filtrage par note minimale
  if (filtreNote.value) {
    filtres = filtres.filter(v => v.note_moyenne >= parseInt(filtreNote.value));
  }

  // Affiche les voyages après filtrage
  afficherVoyages(filtres);
}

// Fonction pour générer dynamiquement les cartes de voyages
function afficherVoyages(voyages) {
  resultatsDiv.innerHTML = ''; // Vide la zone d'affichage

  if (voyages.length === 0) {
    resultatsDiv.innerHTML = '<p>Aucun voyage trouvé.</p>';
    return;
  }

  voyages.forEach(v => {
    resultatsDiv.innerHTML += `
      <a href="http://localhost:8000/php/voyage.php?id=${v.id}" class="carte-voyage">
        <img src="../data/images/${v.image}" alt="${v.titre}">
        <h3>${v.titre}</h3>
        <p>Durée : ${v.duree} jours</p>
        <p>Prix : ${v.prix_base}€</p>
        <p>Note : ${v.note_moyenne} / 5 (${v.nombre_avis} avis)</p>
      </a>
    `;
  });
}

// Gestion des boutons de tri
const triButtons = document.querySelectorAll('.actions-tri button');
triButtons.forEach(button => {
  button.addEventListener('click', () => {
    const critere = button.dataset.tri;

    // Applique les filtres d'abord pour avoir la bonne base
    appliquerFiltres();
    let filtres = Array.from(voyages); // Copie des données filtrées

    // Tri selon le critère choisi
    if (critere === 'prix') {
      filtres.sort((a, b) => a.prix_base - b.prix_base);
    } else if (critere === 'duree') {
      filtres.sort((a, b) => a.duree - b.duree);
    } else if (critere === 'note') {
      filtres.sort((a, b) => b.note_moyenne - a.note_moyenne);
    } else if (critere === 'popularite') {
      filtres.sort((a, b) => b.nombre_avis - a.nombre_avis);
    }

    afficherVoyages(filtres);
  });
});

// Réinitialisation de tous les filtres
resetFiltresBtn.addEventListener('click', () => {
  const url = new URL(window.location);
  url.searchParams.delete('q');
  history.replaceState(null, '', url);

  rechercheInput.value = '';
  filtreTypeTemporel.value = '';
  filtrePrix.value = '';
  filtreDuree.value = '';
  filtreNote.value = '';
  
  afficherVoyages(voyages); // Affiche tous les voyages
});

// Mise à jour automatique à chaque changement de filtre ou recherche
[rechercheInput, filtreTypeTemporel, filtrePrix, filtreDuree, filtreNote].forEach(el => {
  el.addEventListener('input', appliquerFiltres);
});
