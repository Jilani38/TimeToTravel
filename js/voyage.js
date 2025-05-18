const prixBase = parseFloat(document.getElementById('prix-total').dataset.base);
const prixTotal = document.getElementById('prix-total');
const nbInput = document.getElementById('nombre');
const selectOptions = document.querySelectorAll('.option-select');

function remplirSelects(max) {
  selectOptions.forEach(select => {
    const currentValue = parseInt(select.value) || 0;
    select.innerHTML = '<option value="0">0</option>';
    for (let i = 1; i <= max; i++) {
      const opt = document.createElement('option');
      opt.value = i;
      opt.textContent = i;
      select.appendChild(opt);
    }
    if (currentValue <= max) {
      select.value = currentValue;
    }
  });
}

function recalculerPrix() {
  const nb = parseInt(nbInput.value) || 1;
  let total = prixBase * nb;

  selectOptions.forEach(select => {
    const quantite = parseInt(select.value) || 0;
    const prix = parseFloat(select.dataset.prix || 0);
    total += prix * quantite;
  });

  prixTotal.textContent = total.toFixed(2) + ' €';
}

document.addEventListener("DOMContentLoaded", () => {
  remplirSelects(parseInt(nbInput.value) || 1);
  recalculerPrix();

  nbInput.addEventListener('input', () => {
    const max = parseInt(nbInput.value) || 1;
    remplirSelects(max);
    recalculerPrix();
  });

  selectOptions.forEach(select => {
    select.addEventListener('change', recalculerPrix);
  });
});
