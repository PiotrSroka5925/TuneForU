document.getElementById("profile_picture").addEventListener("change", function(event) {
    const fileNamesContainer = document.getElementById("file-names-container");
    fileNamesContainer.innerHTML = ""; // Czyści poprzednie nazwy plików

    const files = event.target.files;
    if (files.length === 0) return; // Jeśli nie wybrano żadnych plików, zakończ

    // Wyświetlanie nazw plików
    Array.from(files).forEach(file => {
        const fileNameElement = document.createElement("span");
        fileNameElement.classList.add("ms-2");
        fileNameElement.textContent = file.name;
        fileNamesContainer.appendChild(fileNameElement);
    });
});

