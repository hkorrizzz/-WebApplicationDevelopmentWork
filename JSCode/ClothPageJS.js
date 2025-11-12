document.getElementById('favoriteBtn').addEventListener('click', function() {
    const heartIcon = document.getElementById('heartIcon');
    const currentSrc = heartIcon.src;
    
    if (currentSrc.includes('heart-Photoroom.png')) {
        heartIcon.src = 'pictures/INfavorite.jpg'; 
    } else {
        heartIcon.src = 'pictures/heart-Photoroom.png'; 
    }
});