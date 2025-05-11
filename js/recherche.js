

const voyages = [];

// Charger les données JSON au chargement de la page
fetch('../data/voyages.json')
  .then(response => response.json())
  .then(data => {
    voyages.push(...data);
    afficherVoyages(voyages);
  });

// Gestion des filtres et tri
const rechercheInput = document.getElementById('recherche-input');
const filtreTypeTemporel = document.getElementById('filtre-type-temporel');
const filtrePrix = document.getElementById('filtre-prix');
const filtreDuree = document.getElementById('filtre-duree');
const filtreNote = document.getElementById('filtre-note');
const resetFiltresBtn = document.getElementById('reset-filtres');
const resultatsDiv = document.getElementById('resultats');

function appliquerFiltres() {
  let filtres = voyages;

  const search = rechercheInput.value.trim().toLowerCase();
  if (search) {
    filtres = filtres.filter(v => v.titre.toLowerCase().includes(search) || v.lieu.toLowerCase().includes(search));
  }

  if (filtreTypeTemporel.value) {
    filtres = filtres.filter(v => v.type_temporel === filtreTypeTemporel.value);
  }

  if (filtrePrix.value) {
    filtres = filtres.filter(v => {
      if (filtrePrix.value === '1') return v.prix_base <= 1000;
      if (filtrePrix.value === '2') return v.prix_base > 1000 && v.prix_base <= 2000;
      if (filtrePrix.value === '3') return v.prix_base > 2000;
    });
  }

  if (filtreDuree.value) {
    filtres = filtres.filter(v => {
      if (filtreDuree.value === '1') return v.duree <= 4;
      if (filtreDuree.value === '2') return v.duree >= 5 && v.duree <= 7;
      if (filtreDuree.value === '3') return v.duree >= 8;
    });
  }

  if (filtreNote.value) {
    filtres = filtres.filter(v => v.note_moyenne >= parseInt(filtreNote.value));
  }

  afficherVoyages(filtres);
}

function afficherVoyages(voyages) {
  resultatsDiv.innerHTML = '';
  if (voyages.length === 0) {
    resultatsDiv.innerHTML = '<p>Aucun voyage trouvé.</p>';
    return;
  }
  voyages.forEach(v => {
    resultatsDiv.innerHTML += `
      <div class="carte-voyage">
        <img src="../data/images/${v.image}" alt="${v.titre}">
        <h3>${v.titre}</h3>
        <p>Durée : ${v.duree} jours</p>
        <p>Prix : ${v.prix_base}€</p>
        <p>Note : ${v.note_moyenne} / 5 (${v.nombre_avis} avis)</p>
      </div>
    `;
  });
}

// Gestion des tris
const triButtons = document.querySelectorAll('.actions-tri button');
triButtons.forEach(button => {
  button.addEventListener('click', () => {
    const critere = button.dataset.tri;
    let voyagesActuels = Array.from(resultatsDiv.querySelectorAll('.carte-voyage')).map(v => v.dataset.id);
    let filtres = voyages;
    appliquerFiltres();
    filtres = Array.from(voyages);

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

// Reset filtres
resetFiltresBtn.addEventListener('click', () => {
  rechercheInput.value = '';
  filtreTypeTemporel.value = '';
  filtrePrix.value = '';
  filtreDuree.value = '';
  filtreNote.value = '';
  afficherVoyages(voyages);
});

// Rafraîchir à chaque changement de filtre
[rechercheInput, filtreTypeTemporel, filtrePrix, filtreDuree, filtreNote].forEach(el => {
  el.addEventListener('input', appliquerFiltres);
});
