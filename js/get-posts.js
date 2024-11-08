document.addEventListener("DOMContentLoaded", function() {
    let range = 1;
    const order = "date";
    const postsContainer = document.getElementById("postsContainer");

    async function getPosts() {
        try {
            const url = `${location.protocol}//${location.hostname}/tuneforu/post/get-posts.php`;
            const response = await $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: { range, order }
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
    }

    // Ładowanie pierwszych wpisów po załadowaniu strony
    getPosts();
});