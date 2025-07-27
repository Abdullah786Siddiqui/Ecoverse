let searchTimeout;

function searchFunc(query) {
  const resultCard = document.getElementById("resultCard");
  const output = document.getElementById("output");

  if (query.trim() === "") {
    clearTimeout(searchTimeout);
    resultCard.classList.add("d-none");
    output.innerHTML = `<div class="text-muted">Start typing to search</div>`;
    return;
  } 

  resultCard.classList.remove("d-none");
  output.innerHTML = `  <div class="d-flex justify-content-center my-2">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading…</span>
      </div>
    </div>`;

  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    fetch("../Server/Process/search-process.php?query=" + encodeURIComponent(query))
      .then(res => {
        return res.text();
      })
      .then(data => {
        if (data.trim()) {
          output.innerHTML = data;
        } else {
          output.innerHTML = `<div class="text-warning">No results found</div>`;
        }
      })
      .catch(err => {
        output.innerHTML = `<div class="text-danger">Error: ${err.message}</div>`;
      });
  }, 500);
}
