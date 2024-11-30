const arrowLeft = document.querySelector(
    ".main-wrapper .left-section .logo .bx.bxs-chevron-left-circle"
);
const sideBar = document.querySelector(".left-section");
const pageWrapper = document.querySelector(".main-wrapper .page-wrapper");


document.querySelectorAll(".left-section .sidebar .item a").forEach((link) => {
    link.addEventListener("click", (e) => {
        // Mantén el estado de colapsado
        const isCollapsed = sideBar.classList.contains("close");
        localStorage.setItem("sidebar-collapsed", isCollapsed);

        // Deja que la navegación continúe sin afectar la barra lateral
    });
});


// Función para actualizar la interfaz según el estado almacenado
function setSidebarState(collapsed) {
    if (collapsed) {
        document.documentElement.classList.add("sidebar-collapsed");
        sideBar.classList.add("close");
        pageWrapper?.classList.add("close");

        arrowLeft?.classList.replace(
            "bxs-chevron-left-circle",
            "bxs-chevron-right-circle"
        );
    } else {
        document.documentElement.classList.remove("sidebar-collapsed");
        sideBar.classList.remove("close");
        pageWrapper?.classList.remove("close");

        arrowLeft?.classList.replace(
            "bxs-chevron-right-circle",
            "bxs-chevron-left-circle"
        );
    }
}


// Al cargar la página, aplica el estado almacenado lo más pronto posible
function initSidebarState() {
    const isCollapsed = localStorage.getItem("sidebar-collapsed") === "true";

    // Aplica las clases inmediatamente
    if (isCollapsed) {
        document.documentElement.classList.add("sidebar-collapsed");
        sideBar?.classList.add("close");
        pageWrapper?.classList.add("close");
    }

    document.addEventListener("DOMContentLoaded", () => {
        setSidebarState(isCollapsed); // Ajustes finales si es necesario
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
