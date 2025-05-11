const sectionPast = document.querySelector("section#past");
const sectionFuture = document.querySelector("section#future");
const positions = [0, 0.1, 0.2, 0.3, 0.4];

function onScroll() {
	for (const section of [sectionPast, sectionFuture]) {
		const sectionRect = section.getBoundingClientRect();
		const aside = section.querySelector("aside");

		const children = aside.children;
		for (const i in positions) {
			const position = positions[i];
			const element = children[i];
			if (element === undefined) {
				break;
			}
			if (-sectionRect.y >= position * sectionRect.height) {
				element.classList.remove("hidden");
			} else {
				element.classList.add("hidden");
			}
		}
	}
}
document.addEventListener("scroll", onScroll);
onScroll();

