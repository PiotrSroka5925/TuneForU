const fullPage = document.querySelector('#fullpage');

fullPage.addEventListener("click", () => {
    fullPage.style.display='none'; 
    document.body.style.overflow = 'auto'
});

function displayFullPageImage(img){
    document.body.style.overflow = "hidden";
    fullPage.style.backgroundImage = 'url(' + img.src + ')';
    fullPage.style.display = 'block';
}