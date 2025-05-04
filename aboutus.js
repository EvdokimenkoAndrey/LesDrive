document.querySelectorAll('.director-question').forEach(question => {
    question.addEventListener('click', function () {
        const item = this.closest('.director-question-item');
        item.classList.toggle('active');
    });
});