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
// document.addEventListener('DOMContentLoaded', function () {
//     const fileInput = document.getElementById('image-upload');
//     const profileImageContainer = document.querySelector('.profile-image-container');

//     if (fileInput && profileImageContainer) {
//         fileInput.addEventListener('change', function (event) {
//             const file = event.target.files[0];
//             if (file) {
//                 const reader = new FileReader();

//                 // Когда файл загружен, обновляем src для предварительного просмотра
//                 reader.onload = function (e) {
//                     // Создаем элемент <img> для предварительного просмотра
//                     const previewImage = document.createElement('img');
//                     previewImage.src = e.target.result;
//                     previewImage.alt = 'Preview Image';
//                     previewImage.classList.add('profile-image');

//                     // Заменяем текущее содержимое контейнера
//                     profileImageContainer.innerHTML = '';
//                     profileImageContainer.appendChild(previewImage);

//                     // Добавляем label обратно для возможности повторной загрузки
//                     const label = document.createElement('label');
//                     label.setAttribute('for', 'image-upload');
//                     label.classList.add('profile-image-label');
//                     profileImageContainer.appendChild(label);
//                 };

//                 // Читаем файл как Data URL
//                 reader.readAsDataURL(file);
//             }
//         });
//     }
// });