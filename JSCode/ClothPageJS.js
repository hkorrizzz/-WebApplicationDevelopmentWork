
function checkIfInFavorites() {
    const productId = '<?php echo $id; ?>'; 
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    const heartIcon = document.getElementById('heartIcon');
    
    if (favorites.includes(productId)) {
        
        heartIcon.src = 'pictures/INfavorite.jpg';
        heartIcon.alt = 'В избранном';
    } else {
        
        heartIcon.src = 'pictures/heart-Photoroom.png';
        heartIcon.alt = 'Добавить в избранное';
    }
}


function toggleFavorite() {
    const productId = '<?php echo $id; ?>';
    const heartIcon = document.getElementById('heartIcon');
    
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    
    if (!favorites.includes(productId)) {
       
        favorites.push(productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        heartIcon.src = 'pictures/INfavorite.jpg';
        heartIcon.alt = 'В избранном';
    } else {

        favorites = favorites.filter(id => id !== productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        heartIcon.src = 'pictures/heart-Photoroom.png';
        heartIcon.alt = 'Добавить в избранное';
    }
    

    if (typeof updateFavoritesCount === 'function') {
        updateFavoritesCount();
    }
}


document.addEventListener('DOMContentLoaded', function() {

    checkIfInFavorites();
    
    // Добавляем обработчик клика на кнопку избранного
    const favoriteBtn = document.getElementById('favoriteBtn');
    if (favoriteBtn) {
        favoriteBtn.addEventListener('click', toggleFavorite);
    }
});