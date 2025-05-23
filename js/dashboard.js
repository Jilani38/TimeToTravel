document.addEventListener("DOMContentLoaded", () => {
  // Gestion des onglets
  const boutonsOnglets = document.querySelectorAll(".onglets button");
  const sections = document.querySelectorAll(".onglet-section");

  boutonsOnglets.forEach((btn) => {
    btn.addEventListener("click", () => {
      boutonsOnglets.forEach((b) => b.classList.remove("onglet-actif"));
      sections.forEach((sec) => sec.classList.remove("actif"));

      btn.classList.add("onglet-actif");
      const target = document.querySelector(btn.dataset.target);
      if (target) target.classList.add("actif");
    });
  });

  // Gestion édition inline profil
  document.querySelectorAll(".profil-inline li").forEach((champ) => {
    const input = champ.querySelector("input");
    const btnEdit = champ.querySelector(".btn-edit");
    const btnValider = champ.querySelector(".btn-valider");
    const btnAnnuler = champ.querySelector(".btn-annuler");

    const valeurInitiale = input.value;

    btnEdit.addEventListener("click", () => {
      input.readOnly = false;
      btnEdit.style.display = 'none';
      btnValider.style.display = 'inline';
      btnAnnuler.style.display = 'inline';
    });

    btnValider.addEventListener("click", () => {
      input.readOnly = true;
      input.dataset.modifie = "true";
      btnEdit.style.display = 'inline';
      btnValider.style.display = 'none';
      btnAnnuler.style.display = 'none';
      verifierModifications();
    });

    btnAnnuler.addEventListener("click", () => {
      input.value = valeurInitiale;
      input.readOnly = true;
      btnEdit.style.display = 'inline';
      btnValider.style.display = 'none';
      btnAnnuler.style.display = 'none';
    });
  });
});

function verifierModifications() {
  const boutonEnregistrer = document.getElementById('btn-enregistrer');
  const modifications = document.querySelectorAll('input[data-modifie="true"]');
  if (modifications.length > 0) {
    boutonEnregistrer.style.display = 'block';
  } else {
    boutonEnregistrer.style.display = 'none';
  }
}
