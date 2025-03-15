document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slides');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const originalSlidesCount = slides.length; 
    let slideWidth; 
    let visibleSlides; 

    function updateSliderParams() {
        if (window.innerWidth <= 600) {
            visibleSlides = 3;
            slideWidth = slides[0].offsetWidth + 10;
        } else {
            visibleSlides = 4;
            slideWidth = slides[0].offsetWidth + (window.innerWidth <= 910 ? 20 : 60); 
        }
    }

    slides.forEach(slide => {
        slider.appendChild(slide.cloneNode(true));
        slider.insertBefore(slide.cloneNode(true), slides[0]);
    });

    const allSlides = document.querySelectorAll('.slides');
    const totalSlides = allSlides.length;

    let index = originalSlidesCount;

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

    window.addEventListener('resize', () => {
        updateSliderParams();
        updateSlider(false); 
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

        const questionItems = document.querySelectorAll(".question-item");

        questionItems.forEach((item) => {
          const toggleIcon = item.querySelector(".toggle-icon");
          const answer = item.querySelector(".answer");
      
          item.querySelector(".question").addEventListener("click", () => {
            answer.classList.toggle("open");
      
            toggleIcon.classList.toggle("rotated");
          });
        });
    });