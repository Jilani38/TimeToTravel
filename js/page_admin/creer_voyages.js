// JS dynamique pour creer_voyage.php

document.addEventListener("DOMContentLoaded", () => {
  const dureeInput = document.getElementById("duree");
  const programmeContainer = document.getElementById("programme-container");

  dureeInput.addEventListener("change", () => {
    const nbJours = parseInt(dureeInput.value);
    programmeContainer.innerHTML = "";
    for (let i = 1; i <= nbJours; i++) {
      const bloc = document.createElement("div");
      bloc.classList.add("jour-bloc");
      bloc.innerHTML = `
        <h4>Jour ${i}</h4>
        <label>Titre : <input type="text" name="programme[${i}][titre]" required></label><br>
        <label>Activité : <textarea name="programme[${i}][activite]" required></textarea></label>
        <hr>
      `;
      programmeContainer.appendChild(bloc);
    }
  });
});

function ajouterOption() {
  const container = document.getElementById("options-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("option-bloc");
  bloc.innerHTML = `
    <label>Type : <input type="text" name="options[${index}][type]" required></label>
    <label>Nom : <input type="text" name="options[${index}][nom]" required></label>
    <label>Prix : <input type="number" name="options[${index}][prix_par_personne]" required></label>
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
    <label>Nom : <input type="text" name="activites[${index}][nom]" required></label>
    <label>Description : <textarea name="activites[${index}][description]" required></textarea></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterInfo() {
  const container = document.getElementById("infos-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("info-bloc");
  bloc.innerHTML = `
    <label>Info pratique : <input type="text" name="infos_pratiques[]" required></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}
