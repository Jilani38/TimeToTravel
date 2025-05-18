const input = document.getElementById("recherche-input");
const table = document.querySelector("tbody");

function updateVoyages() {
  const url = new URL(window.location);
  const q = input.value;
  if (q === "") {
    url.searchParams.delete('q');
    for (const row of table.children) {
      row.style.display = "table-row";
    }
  } else {
    url.searchParams.set('q', q);
    for (const row of table.children) {
      if (row.textContent.toLowerCase().includes(q.toLowerCase())) {
        row.style.display = "table-row";
      } else {
        row.style.display = "none";
      }
    }
  }
  history.replaceState(null, '', url);
}

updateVoyages()
input.addEventListener("input", updateVoyages);
