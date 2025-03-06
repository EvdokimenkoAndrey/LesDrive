document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slides');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const originalSlidesCount = slides.length; // Исходное количество слайдов
    let slideWidth; // Динамическая ширина слайда
    let visibleSlides; // Количество видимых слайдов

    // Функция для обновления параметров слайдера
    function updateSliderParams() {
        if (window.innerWidth <= 600) {
            visibleSlides = 3;
            slideWidth = slides[0].offsetWidth + 10; // gap 10px для 450px и меньше
        } else {
            visibleSlides = 4;
            slideWidth = slides[0].offsetWidth + (window.innerWidth <= 910 ? 20 : 60); // gap зависит от ширины
        }
    }

    // Клонируем слайды для бесконечного эффекта
    slides.forEach(slide => {
        slider.appendChild(slide.cloneNode(true));
        slider.insertBefore(slide.cloneNode(true), slides[0]);
    });

    const allSlides = document.querySelectorAll('.slides'); // Все слайды включая клоны
    const totalSlides = allSlides.length;

    // Начальная позиция
    let index = originalSlidesCount;

    // Инициализация параметров и позиции
    updateSliderParams();
    slider.style.transform = `translateX(-${index * slideWidth}px)`;

    function updateSlider(transition = true) {
        slider.style.transition = transition ? 'transform 0.5s ease' : 'none';
        slider.style.transform = `translateX(-${index * slideWidth}px)`;
    }

    function handleTransitionEnd() {
        if (index >= originalSlidesCount * 2) {
            index = originalSlidesCount + (index % originalSlidesCount);
            updateSlider(false);
        } else if (index < originalSlidesCount) {
            index = originalSlidesCount + (index % originalSlidesCount);
            updateSlider(false);
        }
    }

    slider.addEventListener('transitionend', handleTransitionEnd);

    nextBtn.addEventListener('click', () => {
        index++;
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        index--;
        updateSlider();
    });

    // Обновление при изменении размера окна
    window.addEventListener('resize', () => {
        updateSliderParams();
        updateSlider(false); // Обновляем позицию без анимации
    });
            
    const textContainer = document.getElementById("textContainer");
    const text = textContainer.innerText;
    textContainer.innerText = "";
    
        text.split("").forEach((char, index) => {
            let span = document.createElement("span");
            span.innerText = char;
            span.style.opacity = "0";
            span.style.transition = `opacity 2.5s ease ${index * 50}ms`;
            textContainer.appendChild(span);
        });
    
        function handleScroll() {
            const rect = textContainer.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                textContainer.querySelectorAll("span").forEach(span => {
                    span.style.opacity = "1";
                });
                window.removeEventListener("scroll", handleScroll);
            }
        }
    
        window.addEventListener("scroll", handleScroll);
    });