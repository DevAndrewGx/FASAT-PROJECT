const arrowLeft = document.querySelector(
    ".main-wrapper .left-section .logo .bx.bxs-chevron-left-circle"
);
const sideBar = document.querySelector(".left-section");
const pageWrapper = document.querySelector(".main-wrapper .page-wrapper");

// Función para actualizar la interfaz según el estado almacenado
function setSidebarState(collapsed) {
    // Añadir un pequeño retraso para evitar el parpadeo
    setTimeout(() => {
        if (collapsed) {
            // Añadir clase de colapsado inmediatamente
            document.documentElement.classList.add("sidebar-collapsed");
            sideBar.classList.add("close");

            if (pageWrapper) {
                pageWrapper.classList.add("close");
            }

            // Cambiar la clase de la flecha
            if (arrowLeft) {
                arrowLeft.classList.remove("bxs-chevron-left-circle");
                arrowLeft.classList.add("bxs-chevron-right-circle");
            }
        } else {
            // Lógica para estado expandido si es necesario
            document.documentElement.classList.remove("sidebar-collapsed");
            sideBar.classList.remove("close");

            if (pageWrapper) {
                pageWrapper.classList.remove("close");
            }

            if (arrowLeft) {
                arrowLeft.classList.remove("bxs-chevron-right-circle");
                arrowLeft.classList.add("bxs-chevron-left-circle");
            }
        }
    }, 50); // Pequeño retraso de 50ms para evitar el parpadeo
}

// Al cargar la página, aplica el estado almacenado lo más pronto posible
function initSidebarState() {
    const isCollapsed = localStorage.getItem("sidebar-collapsed") === "true";

    // Añadir clase de colapsado antes de que la página termine de cargar
    if (isCollapsed) {
        document.documentElement.classList.add("sidebar-collapsed");
        if (sideBar) sideBar.classList.add("close");
        if (pageWrapper) pageWrapper.classList.add("close");
    }

    // Esperar a que el DOM esté completamente cargado para ajustes finales
    document.addEventListener("DOMContentLoaded", () => {
        setSidebarState(isCollapsed);
    });
}

// Iniciar el estado de la sidebar lo antes posible
initSidebarState();

// Evento para colapsar/expandir (si el elemento existe)
if (arrowLeft) {
    arrowLeft.addEventListener("click", () => {
        const isCurrentlyCollapsed = sideBar.classList.contains("close");
        localStorage.setItem("sidebar-collapsed", !isCurrentlyCollapsed);
        setSidebarState(!isCurrentlyCollapsed);
    });
}

// EFECT FOR SIDEBAR ELEMENTS
const activeAside = () => {
    const actual = document
        .getElementById("actual")
        .getAttribute("data-navegation");
    const rol = document.getElementById("actual").getAttribute("data-rol");
    console.log("Rol: " + rol);
    console.log("Actual: " + actual);

    if (actual != "#admin" && rol == "admin") {
        // Remueve la clase 'active' de todos los elementos
        const items = document.querySelectorAll(".item");
        items.forEach((item) => {
            item.classList.remove("active");
        });
        // Añade la clase 'active' al elemento actual
        const seccion = document.querySelector(actual);
        console.log(seccion);
        seccion.classList.add("active");
    }

    if (actual != "#mesero" && rol == "mesero") {
        // Remueve la clase 'active' de todos los elementos
        const items = document.querySelectorAll(".item");
        console.log("its hereeee");
        items.forEach((item) => {
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

function openModalCreateUser() {
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $("#modalFormUsuario").modal("show");
}

function openModalCreateProduct() {
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nuevo Producto";
    document.querySelector("#formProduct").reset();
    $("#modalFormCreateProduct").modal("show");
}

function openModalCreateCategory() {
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    // document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    // document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector("#titleModal").innerHTML = "Nueva categoria";
    document.querySelector("#formCategories").reset();
    $("#modalFormCategories").modal("show");
}

function openModalCreateMesas() {
    rowTable = "";
    // document.querySelector('#idUsuario').value ="";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nueva Mesa";
    document.querySelector("#formMesas").reset();
    $("#modalFormMesas").modal("show");
}
