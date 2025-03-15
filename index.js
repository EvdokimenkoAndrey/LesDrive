document.addEventListener("DOMContentLoaded", function () {
    const sliderWrapper = document.querySelector(".slider-wrapper");
    let index = 0;

    function nextSlide() {
        index = (index + 1) % 2; 
        sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
    }

    setInterval(nextSlide, 10000);
});

