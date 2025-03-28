const imageInput = document.querySelector('input[name="image"]');
const imagePreview = document.querySelector('input[name="image"] + img');

imageInput.addEventListener("change", () => {
	const file = imageInput.files[0];
	if (!file) {
		return;
	}
	imagePreview.src = URL.createObjectURL(file);
});
