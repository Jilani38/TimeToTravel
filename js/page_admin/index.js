const dialog = document.querySelector("dialog");
const dialogImage = dialog.querySelector("img");
const dialogOpeners = document.querySelectorAll("[data-image-modal-src]");

for (const dialogOpener of dialogOpeners) {
	dialogOpener.addEventListener("click", () => {
		dialogImage.src = dialogOpener.dataset.imageModalSrc;
		dialog.showModal();
	});
}

const modal = document.querySelector("dialog");
const closeBtn = document.getElementById("close-modal");

closeBtn.addEventListener("click", () => {
  modal.close();
});

