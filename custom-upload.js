document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image-upload');
    const previewContainer = document.querySelector('.custom-upload');

    input.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = "Profile Image";
                img.className = "profile-image profile-image-product";

                previewContainer.innerHTML = '';
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
});