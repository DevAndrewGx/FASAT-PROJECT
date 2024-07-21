// EFECT FOR SIDEBAR ELEMENTS
const arrowAside = document.querySelector(
    ".main-wrapper .left-section .logo .bx.bxs-chevron-left-circle"
);
const sideBar = document.querySelector('.left-section');


arrowAside.addEventListener('click', () => { 
    console.log('axxx')
    sideBar.classList.toggle('close');
});

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

// functions for modals

function openModal()
{
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}