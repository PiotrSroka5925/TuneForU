document.getElementById("post_picture").addEventListener("change", function(event) {
    const previewContainer = document.getElementById("preview-container");
    previewContainer.innerHTML = ""; 
    
    const files = event.target.files;
    if (files.length === 0) return; 
    
    Array.from(files).forEach(file => {
       
        if (!file.type.startsWith("image/")) return;

        
        const imgElement = document.createElement("img");
        imgElement.src = URL.createObjectURL(file);
        imgElement.classList.add("img-thumbnail", "me-2", "mb-2");
        imgElement.style.width = "100px"; 
        imgElement.style.height = "100px";
        
    
        previewContainer.appendChild(imgElement);
    });
});
