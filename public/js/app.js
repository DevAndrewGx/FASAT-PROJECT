// EFECT FOR SIDEBAR ELEMENTS

const activeAside = () => {
    const actual = document.getElementById("actual").getAttribute("data-navegation");
    console.log(actual);

    if (actual != "#admin") {
        // Remueve la clase 'active' de todos los elementos
        const items = document.querySelectorAll('.item');
        items.forEach(item => {
            item.classList.remove("active");
        });

        // Añade la clase 'active' al elemento actual
        const seccion = document.querySelector(actual);
        console.log(seccion);
        seccion.classList.add("active");
    }
};



document.addEventListener("DOMContentLoaded", () => {
   activeAside();
});




// EFECT FOR STOCK NAVBAR ELEMENTS
const navegationItems = document.querySelectorAll(
    "main .nav-sections nav ul li"
);
let activeNavItem = navegationItems[0];
navegationItems.forEach((element) => {
    element.addEventListener("click", () => {
        if (activeNavItem) {
            activeNavItem.removeAttribute("id");
        }

        element.setAttribute("id", "active");
        activeItem = element;
    });
});

// document
//     .getElementById("profile-picture")
//     .addEventListener("change", function () {
//         const file = this.files[0];
//         if (file) {
//             const reader = new FileReader();
//             reader.onload = function () {
//                 document.getElementById("profile-image").src = reader.result;
//             };
//             reader.readAsDataURL(file);
//         }
//     });
