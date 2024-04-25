// EFECT FOR SIDEBAR ELEMENTS
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



document.getElementById('profile-picture').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profile-image').src = reader.result;
        };
        reader.readAsDataURL(file);
    }
  });