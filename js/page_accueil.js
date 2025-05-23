// Sélectionne les deux sections principales : "past" et "future"
const sectionPast = document.querySelector("section#past");
const sectionFuture = document.querySelector("section#future");

// Définit les seuils de visibilité pour les paragraphes dans les sections (en pourcentage de hauteur)
const positions = [0, 0.1, 0.2, 0.3, 0.4];

// Fonction exécutée à chaque défilement de la page
function onScroll() {
  // Pour chaque section (passé et futur)
  for (const section of [sectionPast, sectionFuture]) {
    const sectionRect = section.getBoundingClientRect(); // Position relative à la fenêtre
    const aside = section.querySelector("aside"); // Récupère l'élément <aside> contenant les paragraphes

    const children = aside.children;
    for (const i in positions) {
      const position = positions[i];
      const element = children[i];

      if (element === undefined) {
        break; // Arrête la boucle si l'élément n'existe pas
      }

      // Affiche ou masque le paragraphe selon la position de la section dans la page
      if (-sectionRect.y >= position * sectionRect.height) {
        element.classList.remove("hidden");
      } else {
        element.classList.add("hidden");
      }
    }
  }
}

// Écoute le défilement pour déclencher l'effet
document.addEventListener("scroll", onScroll);

// Lance une vérification initiale dès le chargement
onScroll();

// Quand la page est chargée, ajoute les redirections sur les images
document.addEventListener("DOMContentLoaded", () => {
  const imgPast = document.getElementById("img-past");
  const imgFuture = document.getElementById("img-future");

  // Clique sur l'image du passé redirige vers la recherche filtrée sur "passé"
  if (imgPast) {
    imgPast.addEventListener("click", () => {
      window.location.href = "page_de_recherche.php?filtre=passé";
    });
  }

  // Clique sur l'image du futur redirige vers la recherche filtrée sur "futur"
  if (imgFuture) {
    imgFuture.addEventListener("click", () => {
      window.location.href = "page_de_recherche.php?filtre=futur";
    });
  }
});
