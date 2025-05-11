// Aperçu image modifiée
const imageInput = document.querySelector('input[name="image"]');
const imagePreview = document.querySelector('input[name="image"] + img');

if (imageInput && imagePreview) {
  imageInput.addEventListener("change", () => {
    const file = imageInput.files[0];
    if (!file) return;
    imagePreview.src = URL.createObjectURL(file);
  });
}

// Génération des blocs infos pratiques, programme, options, activités
function ajouterInfo(value = "") {
  const container = document.getElementById("infos-container");
  const bloc = document.createElement("div");
  bloc.classList.add("info-bloc");
  bloc.innerHTML = `
    <input type="text" name="infos_pratiques[]" value="${value}">
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterOption(type = "", nom = "", prix = 0) {
  const container = document.getElementById("options-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("option-bloc");
  bloc.innerHTML = `
    <label>Type : <input type="text" name="options[${index}][type]" value="${type}" required></label>
    <label>Nom : <input type="text" name="options[${index}][nom]" value="${nom}" required></label>
    <label>Prix : <input type="number" name="options[${index}][prix_par_personne]" value="${prix}" required></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterActivite(nom = "", description = "") {
  const container = document.getElementById("activites-container");
  const index = container.children.length;
  const bloc = document.createElement("div");
  bloc.classList.add("activite-bloc");
  bloc.innerHTML = `
    <label>Nom : <input type="text" name="activites[${index}][nom]" value="${nom}" required></label>
    <label>Description : <textarea name="activites[${index}][description]" required>${description}</textarea></label>
    <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
    <hr>
  `;
  container.appendChild(bloc);
}

function ajouterJour(index, titre = "", activite = "") {
  const container = document.getElementById("programme-container");
  const bloc = document.createElement("div");
  bloc.classList.add("jour-bloc");
  bloc.innerHTML = `
    <h4>Jour ${index}</h4>
    <label>Titre : <input type="text" name="programme[${index}][titre]" value="${titre}" required></label><br>
    <label>Activité : <textarea name="programme[${index}][activite]" required>${activite}</textarea></label>
    <hr>
  `;
  container.appendChild(bloc);
}

// Initialisation automatique avec les données JSON intégrées dans les attributs data-
document.addEventListener("DOMContentLoaded", () => {
  const programmeData = document.getElementById("programme-container").dataset.programme;
  const optionsData = document.getElementById("options-container").dataset.options;
  const activitesData = document.getElementById("activites-container").dataset.activites;

  if (programmeData) {
    const programme = JSON.parse(programmeData);
    programme.forEach((j, i) => ajouterJour(i + 1, j.titre, j.activite));
  }

  if (optionsData) {
    const options = JSON.parse(optionsData);
    options.forEach(opt => ajouterOption(opt.type, opt.nom, opt.prix_par_personne));
  }

  if (activitesData) {
    const activites = JSON.parse(activitesData);
    activites.forEach(act => ajouterActivite(act.nom, act.description));
  }
});
