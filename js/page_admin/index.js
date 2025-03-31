document.addEventListener("DOMContentLoaded", () => {
	console.log("✅ JS chargé !");
  
	if (window.lucide) {
	  lucide.createIcons();
	  console.log("✅ Lucide chargé !");
	} else {
	  console.error("❌ Lucide non chargé !");
	}
  
	const dialog = document.querySelector("dialog");
	const image = dialog?.querySelector("img");
	const close = document.getElementById("close-modal");
  
	document.querySelectorAll("[data-image-modal-src]").forEach(button => {
	  button.addEventListener("click", () => {
		image.src = button.dataset.imageModalSrc;
		dialog.showModal();
	  });
	});
  
	if (close) {
	  close.addEventListener("click", () => dialog.close());
	}
  });
  