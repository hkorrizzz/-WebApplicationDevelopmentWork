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

let favoriteProducts = [];

function addToFavorites(button) {
    const productId = button.getAttribute('data-product-id');
    
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

    if (!favorites.includes(productId)) {
        favorites.push(productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        button.textContent = 'В ИЗБРАННОМ';
        button.style.backgroundColor = '#4CAF50'; 
    } else {
        favorites = favorites.filter(id => id !== productId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        button.textContent = 'В ИЗБРАННОЕ';
        button.style.backgroundColor = '';
    }
    
    updateFavoritesCount();
}

function updateFavoritesCount() {
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    const favoritesCount = favorites.length;
    
    const favoritesButton = document.querySelector('button[title="Избранные товары"]');
    if (favoritesButton) {
        let badge = favoritesButton.querySelector('.favorites-badge');
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'favorites-badge';
            badge.style.cssText = 'position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 12px; display: flex; align-items: center; justify-content: center;';
            favoritesButton.style.position = 'relative';
            favoritesButton.appendChild(badge);
        }
        
        if (favoritesCount > 0) {
            badge.textContent = favoritesCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', updateFavoritesCount);

document.addEventListener('DOMContentLoaded', function() {
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    
    // Для каждой кнопки проверяем, есть ли товар в избранном
    document.querySelectorAll('.add-to-favorites').forEach(button => {
        const productId = button.getAttribute('data-product-id');
        
        if (favorites.includes(productId)) {
            button.textContent = 'В ИЗБРАННОМ ✓';
            button.style.backgroundColor = '#4CAF50';
        }
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const registerButton = document.getElementById('registerButton');
    const registerModal = document.getElementById('registerModal');
    const closeRegister = document.getElementById('closeRegister');
    const registerForm = document.getElementById('registerForm');
    
    // Открытие модального окна
    registerButton.addEventListener('click', function() {
        registerModal.classList.add('active');
    });
    
    // Закрытие модального окна
    closeRegister.addEventListener('click', function() {
        registerModal.classList.remove('active');
    });
    
    // Закрытие при клике вне окна
    registerModal.addEventListener('click', function(e) {
        if (e.target === registerModal) {
            registerModal.classList.remove('active');
        }
    });
    



    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const login = this.querySelector('input[type="text"]').value;
        const password = this.querySelector('input[type="password"]').value;
        
        if (login === 'qwerty' && password === '12345') {

            registerModal.classList.remove('active');
            
            const successModal = document.createElement('div');
            successModal.className = 'success-modal';
            successModal.innerHTML = `
                <div class="success-container">
                    <div class="success-header">
                        <button class="close-success">&times;</button>
                    </div>  
                    <div class="success-content">
                        <div class="success-subtitle">Вы вошли в аккаунт!</div>
                    </div>
                </div>
            `;
            
            const style = document.createElement('style');
            style.textContent = `
                .success-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1001;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .success-container {
                    background-color: white;
                    width: 90%;
                    max-width: 300px;
                    border-radius: 0;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                }
                .success-header {
                    display: flex;
                    justify-content: flex-end;
                    padding: 10px 15px;
                }
                .close-success {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #999;
                    padding: 0;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .close-success:hover {
                    color: #333;
                }
                .success-content {
                    padding: 30px 20px;
                    text-align: center;
                }
                .success-subtitle {
                    text-align: center;
                    color: #666;
                    margin-bottom: 10px;
                    font-size: 20px;
                }
            `;
            
            document.head.appendChild(style);
            document.body.appendChild(successModal);
            
            // Закрытие окна успеха
            const closeSuccess = successModal.querySelector('.close-success');
            closeSuccess.addEventListener('click', function() {
                document.body.removeChild(successModal);
            });
            
            // Закрытие при клике вне окна
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    document.body.removeChild(successModal);
                }
            });
            

            
        } else {
            // Неправильные данные - показываем сообщение об ошибке
            showErrorMessage('Неверный логин или пароль');
        }
    });
    
    // Функция для показа сообщения об ошибке
    function showErrorMessage(message) {
        // Создаем сообщение об ошибке
        const errorModal = document.createElement('div');
        errorModal.className = 'error-modal';
        errorModal.innerHTML = `
            <div class="error-container">
                <div class="error-header">
                    <button class="close-error">&times;</button>
                </div>  
                <div class="error-content">
                    <div class="error-subtitle">${message}</div>
                </div>
            </div>
        `;
        
        // Добавляем стили
        const style = document.createElement('style');
        style.textContent = `
            .error-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1001;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .error-container {
                background-color: white;
                width: 90%;
                max-width: 300px;
                border-radius: 0;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
            .error-header {
                display: flex;
                justify-content: flex-end;
                padding: 10px 15px;
            }
            .close-error {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: #999;
                padding: 0;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .close-error:hover {
                color: #333;
            }
            .error-content {
                padding: 30px 20px;
                text-align: center;
            }
            .error-subtitle {
                text-align: center;
                color: #666;
                margin-bottom: 10px;
                font-size: 20px;
            }
        `;
        
        document.head.appendChild(style);
        document.body.appendChild(errorModal);
        
        // Закрытие окна ошибки
        const closeError = errorModal.querySelector('.close-error');
        closeError.addEventListener('click', function() {
            document.body.removeChild(errorModal);
        });
        

        errorModal.addEventListener('click', function(e) {
            if (e.target === errorModal) {
                document.body.removeChild(errorModal);
            }
        });
        
        
    }
});

