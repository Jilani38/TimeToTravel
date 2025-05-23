// Si le thème sauvegardé dans le localStorage est "dark"
if (localStorage.getItem("theme") === "dark") {
	// Ajoute la classe "dark" au body dès le chargement
	document.body.classList.add("dark");
}

// Récupère l’élément avec l’ID "toggle-dark-mode" (le bouton ou switch)
const toggle = document.getElementById("toggle-dark-mode");

// Lorsqu’on clique sur le bouton de changement de thème :
toggle.addEventListener("click", () => {
	// Alterne la classe "dark" sur le body (si elle y est, on la retire, sinon on l’ajoute)
	document.body.classList.toggle("dark");

	// Met à jour la valeur dans le localStorage pour conserver le choix
	localStorage.setItem(
		"theme",
		document.body.classList.contains("dark") ? "dark" : "light"
	);
});
