function likePost(postId) {
    fetch('post/like-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ post_id: postId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const likeCountElement = document.getElementById(`like-count-${postId}`);
            const likeIconElement = document.getElementById(`like-icon-${postId}`);

            likeCountElement.textContent = data.like_count;

            if (data.liked) {
                likeIconElement.classList.remove('bi-hand-thumbs-up');
                likeIconElement.classList.add('bi-hand-thumbs-up-fill');
            } else {
                likeIconElement.classList.remove('bi-hand-thumbs-up-fill');
                likeIconElement.classList.add('bi-hand-thumbs-up');
            }
        } else {
            alert(data.message);
        }
    })
}
