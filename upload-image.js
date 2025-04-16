document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('new_image');
    const container = document.getElementById('profile-image-container');
    const currentImage = document.getElementById('current-profile-image');

    input.addEventListener('change', function(event) {
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Если есть текущее изображение - заменяем его
                if (currentImage) {
                    currentImage.src = e.target.result;
                } else {
                    // Если изображения не было - создаем новый элемент img
                    const newImage = document.createElement('img');
                    newImage.src = e.target.result;
                    newImage.alt = "Profile Image";
                    newImage.className = "profile-image clickable";
                    
                    // Очищаем контейнер и добавляем новое изображение
                    container.innerHTML = '';
                    container.appendChild(newImage);
                }
            }
            
            reader.readAsDataURL(file);
        }
    });
});