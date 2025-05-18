document.addEventListener("DOMContentLoaded", () => {
  const dureeInput = document.getElementById("duree");
  const programmeContainer = document.getElementById("programme-container");

  // Génère les étapes au chargement si un nombre est déjà rempli
  if (dureeInput.value) {
    genererProgramme(parseInt(dureeInput.value));
  }

  dureeInput.addEventListener("input", () => {
    const nbJours = parseInt(dureeInput.value);
    if (!isNaN(nbJours) && nbJours > 0) {
      genererProgramme(nbJours);
    } else {
      programmeContainer.innerHTML = "";
    }
  });

  function genererProgramme(nbJours) {
    programmeContainer.innerHTML = "";
    for (let i = 1; i <= nbJours; i++) {
      const bloc = document.createElement("div");
      bloc.classList.add("jour-bloc");
      bloc.innerHTML = `
        <h4>Jour ${i}</h4>
        <label><strong>Titre :</strong> <input type="text" name="programme[${i}][titre]" required></label>
        <label><strong>Activité :</strong> <textarea name="programme[${i}][activite]" required></textarea></label>
        <hr>
      `;
      programmeContainer.appendChild(bloc);
    }
  }
});

function ajouterOption() {
  const container = document.getElementById("options-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("option-bloc");
  bloc.innerHTML = `
    <label>Type : <input type="text" name="options[${index}][type]" required></label>
    <label>Nom : <input type="text" name="options[${index}][nom]" required></label>
    <label>Prix : <input type="number" name="options[${index}][prix_par_personne]" min="0" required></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterActivite() {
  const container = document.getElementById("activites-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("activite-bloc");
  bloc.innerHTML = `
    <label>Nom : <input type="text" name="activites_incluses[${index}][nom]" required></label>
    <label>Description : <textarea name="activites_incluses[${index}][description]" required></textarea></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterInfo() {
  const container = document.getElementById("infos-container");
  const bloc = document.createElement("div");
  bloc.classList.add("info-bloc");
  bloc.innerHTML = `
    <label>Info pratique : <input type="text" name="infos_pratiques[]" required></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}
