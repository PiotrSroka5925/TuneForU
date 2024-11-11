document.addEventListener("DOMContentLoaded", function() {
    let range = 1;
    let order = "date";
    const postsContainer = document.getElementById("postsContainer");

    const searchBar = document.getElementById("searchBar");
    let search = searchBar.value;

    searchBar.addEventListener("change", () => {
        range = 1;
        search = searchBar.value;
        postsContainer.innerHTML = "";
        getPosts();
    }, false)

    async function getPosts() {
        try {
            const url = `${location.protocol}//${location.hostname}/tuneforu/post/get-posts.php`;
            const response = await $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: { range, order, search }
            });

            if(response){
                postsContainer.innerHTML += response;
                createLoadMoreButton(true);
            }
            else{
                alert("No posts to load!");
            }
            
        } catch (error) {
            console.error("Błąd podczas ładowania postów:", error);
        }

        function createLoadMoreButton(append) {
            let button = document.getElementById("loadMoreButton");
    
            if(button){
                postsContainer.removeChild(button);
            }
    
            if(append){
                button = document.createElement("button");
                button.id = "loadMoreButton";
                button.textContent = "Załaduj więcej";
                button.addEventListener("click", () => {
                    range += 1;
                    getPosts();
                });
    
                postsContainer.appendChild(button);
            }  
        }
    }

    // Ładowanie pierwszych wpisów po załadowaniu strony
    getPosts();
});