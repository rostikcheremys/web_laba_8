function searchItems() {
    const query = document.getElementById("search-query").value;

    if (query === "") return;

    fetch("search.php?query=" + encodeURIComponent(query))
        .then(response => {
            if (!response.ok) {
                throw new Error("Помилка завантаження даних");
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("search-result").innerHTML = data;
        })
        .catch(error => {
            console.error("Помилка:", error);
        });
}
