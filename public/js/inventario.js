const optionMenu = document.querySelector('.select-menu');
const selectBtn = document.querySelector(".select-btn");
const options = document.querySelectorAll(".option");
const selectPlaceholder = document.querySelector(".select-placeholder");

selectBtn.addEventListener('click', () => { 
    optionMenu.classList.toggle('active');
})

options.forEach(option =>  {
    option.addEventListener('click', () => { 
        let selectedOption = option.querySelector('.option-text').textContent;
        selectPlaceholder.textContent = selectedOption;
        console.log(selectedOption);
    })

    console.log(option);
})


