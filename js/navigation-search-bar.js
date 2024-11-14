document.addEventListener("DOMContentLoaded", function() { 
    const searchBar = document.getElementById('searchBarNavigation');
    searchBar.addEventListener('change', ()=> {    
        let search = searchBar.value;        
        window.location.href = `${location.protocol}//${location.hostname}/tuneforu/index.php?search=${search}`;
    })
})