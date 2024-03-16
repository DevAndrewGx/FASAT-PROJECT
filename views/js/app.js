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
