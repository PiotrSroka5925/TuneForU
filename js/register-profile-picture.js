let imgInp = document.getElementById("profile_picture");

imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        document.getElementById("profilePicturePreview").src = URL.createObjectURL(file);
        document.getElementById("profilePictureFileName").innerHTML = file.name;
    }
}