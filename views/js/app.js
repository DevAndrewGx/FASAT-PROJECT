const sidebarItems = document.querySelectorAll(
    ".container .left-section .sidebar .item"
);

let activeItem = sidebarItems[0];

sidebarItems.forEach((element) => {
    element.addEventListener("click", () => {
        if (activeItem) {
            activeItem.removeAttribute("id");
        }

        element.setAttribute("id", "active");
        activeItem = element;
    });
});


const navegationItems = document.querySelectorAll('main .nav-sections nav ul li');

let activeNavItem = navegationItems[0];

navegationItems.forEach((element) => {
    element.addEventListener("click", () => {
        if (activeNavItem) {
            activeNavItem.removeAttribute("id");
        }

        element.setAttribute("id", "active");
        activeItem = element;
    });
})