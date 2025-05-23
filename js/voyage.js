// Récupère le prix de base depuis l'attribut data-base de l'élément #prix-total
const prixBase = parseFloat(document.getElementById('prix-total').dataset.base);

// Récupère les éléments nécessaires dans le DOM
const prixTotal = document.getElementById('prix-total');        // Élément où afficher le prix total
const nbInput = document.getElementById('nombre');              // Champ du nombre de voyageurs
const selectOptions = document.querySelectorAll('.option-select'); // Tous les <select> pour les options

// Fonction pour remplir dynamiquement les <select> avec un nombre de valeurs adapté
function remplirSelects(max) {
  selectOptions.forEach(select => {
    const currentValue = parseInt(select.value) || 0; // Garde la valeur sélectionnée actuelle
    select.innerHTML = '<option value="0">0</option>'; // Réinitialise avec l'option "0"

    // Ajoute les options jusqu'à la valeur max
    for (let i = 1; i <= max; i++) {
      const opt = document.createElement('option');
      opt.value = i;
      opt.textContent = i;
      select.appendChild(opt);
    }

    // Rétablit la valeur précédente si elle est encore valide
    if (currentValue <= max) {
      select.value = currentValue;
    }
  });
}

// Fonction pour recalculer le prix total en fonction du nombre de voyageurs et des options choisies
function recalculerPrix() {
  const nb = parseInt(nbInput.value) || 1; // Nombre de voyageurs
  let total = prixBase * nb;              // Total initial basé sur le prix de base

  // Ajout du coût des options sélectionnées
  selectOptions.forEach(select => {
    const quantite = parseInt(select.value) || 0;
    const prix = parseFloat(select.dataset.prix || 0);
    total += prix * quantite;
  });

  // Mise à jour de l'affichage du prix
  prixTotal.textContent = total.toFixed(2) + ' €';
}

// Une fois le DOM chargé
document.addEventListener("DOMContentLoaded", () => {
  // Initialise les options avec la valeur actuelle du nombre de voyageurs
  remplirSelects(parseInt(nbInput.value) || 1);

  // Calcule le prix initial
  recalculerPrix();

  // Met à jour les options et le prix à chaque changement du nombre de voyageurs
  nbInput.addEventListener('input', () => {
    const max = parseInt(nbInput.value) || 1;
    remplirSelects(max);
    recalculerPrix();
  });

  // Met à jour le prix dès qu'une option est changée
  selectOptions.forEach(select => {
    select.addEventListener('change', recalculerPrix);
  });
});
