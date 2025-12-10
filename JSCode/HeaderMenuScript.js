document.getElementById('menuButton').addEventListener('click', function(event) {
    event.stopPropagation();
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('active');
});

document.addEventListener('click', function(event) {
    const menu = document.getElementById('dropdownMenu');
    const button = document.getElementById('menuButton');
    
    if (!menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.remove('active');
    }
});