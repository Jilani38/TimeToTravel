document.addEventListener("DOMContentLoaded", function () {
	const form = document.getElementById("profil");
	const inputs = document.querySelectorAll("#profil input");
	const editButton = document.createElement("button");
	editButton.textContent = "Modifier";
	editButton.classList.add("btn-primary");
	editButton.type = "button";
	form.appendChild(editButton);

	const saveButton = document.querySelector(".btn-primary");
	const cancelButton = document.querySelector(".btn-secondary");

	editButton.addEventListener("click", function () {
		inputs.forEach((input) => (input.disabled = false));
		saveButton.style.display = "block";
		cancelButton.style.display = "block";
		editButton.style.display = "none";
	});

	form.addEventListener("submit", function (event) {
		event.preventDefault(); // Empêche la soumission réelle du formulaire
		inputs.forEach((input) => (input.disabled = true));
		saveButton.style.display = "none";
		cancelButton.style.display = "none";
		editButton.style.display = "block";
		alert("Modifications enregistrées !");
	});

	cancelButton.addEventListener("click", function (event) {
		event.preventDefault();
		inputs.forEach((input) => (input.disabled = true));
		saveButton.style.display = "none";
		cancelButton.style.display = "none";
		editButton.style.display = "block";
	});
});

document.addEventListener("DOMContentLoaded", () => {
	lucide.createIcons();
  });
  

