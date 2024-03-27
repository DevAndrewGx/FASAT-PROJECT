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

// DATA-TABLES
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("example");
    const dataTable = new DataTable(table, {
        bFilter: true,
        sDom: "fBtlpi",
        pagingType: "numbers",
        ordering: true,
        language: {
            search: " ",
            sLengthMenu: "Mostrar _MENU_ registros", // Personalizado según tu requerimiento
            searchPlaceholder: "Search...",
            info: "_START_ - _END_ de _TOTAL_ items",
        },
        initComplete: function (settings, json) {
            const filterInput = document.querySelector(".dataTables_filter");
            const tableSearch = document.getElementById("tableSearch");
            const searchInput = document.querySelector(".search-input");

            if (filterInput) {
                tableSearch.appendChild(filterInput);
            }

            if (filterInput) {
                const clonedFilterInput = filterInput.cloneNode(true);
                searchInput.appendChild(clonedFilterInput);
            }
        },
    });

    return dataTable;
});
