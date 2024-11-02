function searchItems() {
    const query = document.getElementById("search-query").value;

    if (query === "") return;

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?query=" + encodeURIComponent(query), true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("search-result").innerHTML = xhr.responseText;
        }
    };

    xhr.send();
}