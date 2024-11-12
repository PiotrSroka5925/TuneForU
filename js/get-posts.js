document.addEventListener("DOMContentLoaded", function() {
    let range = 1;
    let order = "date";
    let offset = 0;
    const postsContainer = document.getElementById("postsContainer");

    const searchBar = document.getElementById("searchBar");
    let search = searchBar.value;

    searchBar.addEventListener("change", () => {
        range = 1;
        search = searchBar.value;
        updateSearchParam(search);
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
                dataType: 'json',
                data: { range, order, search, offset}
            });

            if (response) {
                const { rangeLength, count, content } = response;
            
                if (count > 0) {
                    if(count < rangeLength){
                        offset += count;
                    }
                    else{
                        offset = 0;
                        range += 1;
                    }
                        
                    console.log(`Number of posts: ${count}`);
                    console.log(`Range lenght: ${rangeLength}`);
                    console.log(`Offset: ${offset}`);
                    console.log(`Range: ${range}`);
                    postsContainer.innerHTML += content;
                    createLoadMoreButton(true);
                }
                else{
                    alert("No more posts to load!");
                }
            } else {
                alert("Failed to load posts.");
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
                button.classList.add("btn", "btn-light", "my-3");
                button.id = "loadMoreButton";
                button.textContent = "Załaduj więcej";
                button.addEventListener("click", () => {
                    getPosts();
                });
    
                postsContainer.appendChild(button);
            }  
        }
    }

    // Ładowanie pierwszych wpisów po załadowaniu strony
    getPosts();
});

function updateSearchParam(newSearchValue) {
    const url = new URL(window.location.href);

    if(newSearchValue.length > 0){
        url.searchParams.set('search', newSearchValue);
    }
    else
        url.searchParams.delete('search');
    
    history.replaceState(null, '', url);
}