document.addEventListener('DOMContentLoaded', function () {
    var questionLinks = document.querySelectorAll('.question-text');

    questionLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            var answer = this.parentNode.nextElementSibling;
            var arrowIcon = this.parentNode.querySelector('.arrow-icon');

            if (answer.style.display === 'none' || !answer.style.display) {
                answer.style.display = 'block';
                arrowIcon.classList.add('rotate'); 
            } else {
                answer.style.display = 'none';
                arrowIcon.classList.remove('rotate'); 
            }
        });
    });
});
