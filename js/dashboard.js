// js/dashboard.js

document.addEventListener("DOMContentLoaded", () => {
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

  // Gestion du bouton "Modifier mes informations"
  const btnEdit = document.getElementById("btn-editer-profil");
  const formProfil = document.getElementById("form-profil");
  const ulProfil = document.getElementById("profil-statique");

  if (btnEdit && formProfil && ulProfil) {
    btnEdit.addEventListener("click", () => {
      formProfil.style.display = "block";
      ulProfil.style.display = "none";
      btnEdit.style.display = "none";
    });
  }
});

function annulerEdition() {
  document.getElementById("form-profil").style.display = "none";
  document.getElementById("profil-statique").style.display = "block";
  document.getElementById("btn-editer-profil").style.display = "inline-block";
}
