const optionMenu = document.querySelector(".select-menu");
const selectBtn = document.querySelector(".select-btn");
const options = document.querySelectorAll(".option");
const selectPlaceholder = document.querySelector(".select-placeholder");

// selectBtn.addEventListener("click", () => {
//     optionMenu.classList.toggle("active");
// });

options.forEach((option) => {
    option.addEventListener("click", () => {
        let selectedOption = option.querySelector(".option-text").textContent;
        selectPlaceholder.textContent = selectedOption;
        console.log(selectedOption);
    });
    console.log(option);
});

// funciones para el crud
$(document).ready(function () {
    
    const baseUrl = $('meta[name="base-url"]').attr("content");

    let dataTable = $("#data-productos").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 10, // Muestra 10 registros por página
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            processing: "Procesando...",
        },
        ajax: {
            url: baseUrl + "productos/getProducts",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            // { data: "nombre_producto" },
            {
            data: null,
                render: function (data, type, row) {
                    // Definir la ruta de la imagen y el texto del producto
                    let imgSrc = row.foto ? 
                        baseUrl + "public/imgs/uploads/" + row.foto : 
                        baseUrl + "public/imgs/icons/product_default.svg";

                    // Retornar el HTML con la imagen y el nombre del producto
                    return (
                        '<div style="display: flex; align-items: center; gap: 10px;">' +
                            '<img src="' + imgSrc + '" alt="Foto" style="width:45px; height:45px; border-radius:50%;">' +
                            '<span style="font-size: 14px; color: #333;">' + row.nombre_producto + '</span>' +
                        '</div>'
                    );
                },
            },

            { data: "nombre_categoria" },
            { data: "precio" },
            { data: "options" },
        ],
        columnDefs: [
            {
                targets: [0, 4],
                orderable: false,
            },
        ],
    });


    let dataTableProductsOnStok = $("#data-stock-productos").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 10, // Muestra 10 registros por página
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            processing: "Procesando...",
        },
        ajax: {
            url: baseUrl + "stock/getProductsOnStock",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            { data: "nombre_producto" },
            { data: "cantidad" },
            { data: "cantidad_disponible" },
            { data: "options" },
        ],
        columnDefs: [
            {
                targets: [0, 4],
                orderable: false,
            },  
        ],
    });

    $("#formProduct").submit(function (e) {
        console.log("It's here");
        e.preventDefault();
        let form = $(this)[0];
        console.log(form);
        // let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        $.ajax({
            url: baseUrl + "productos/createProduct",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);

                if (data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Producto creado exitosamente",
                        text: data.message,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: "Ok",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Cerrar el modal y reiniciar el formulario
                            $("#formProduct").closest(".modal").modal("hide");
                            dataTable.ajax.reload(null, false);
                        }
                    });
                } else {
                    console.log("Something is gone wrong");
                }
            },
        });
    });

    // funcion para filtrar categorias segun la categoria seleccionada con el evento change
    $("#modalFormCreateProduct #formProduct #categoria").on(
        "change",
        function (e) {
            // cancelamos el evento por default
            e.preventDefault();
            console.log("it's changing");
            // creamos la variable para almacenar el valor que viene del formulario
            const categoriaNombre = e.target.value;
            console.log(categoriaNombre);
            // Cambiado a la variable correcta
            // Enviamos los datos mediante $.post
            $.post(
                `${baseUrl}productos/getSubcategoriesByCategory`,
                { categoria: categoriaNombre },
                function (response) {
                    let subcategories = JSON.parse(response);
                    console.log(subcategories);

                    console.log(subcategories);
                    let template = "";
                    if (subcategories.data.length === 0) {
                        template += `
                        <option value="">No existen categorías asociadas</option>
                    `;
                        $("#subcategoria").html(template);
                        return;
                    }

                    template += "<option ='#'>Seleccione subcategoria</option>";
                    subcategories.data.forEach((subcategory) => {
                        template += `
                            <option value="${subcategory.id_sub_categoria}">${subcategory.nombre_subcategoria}</option>
                        `;
                    });
                    // $("#subcategoria").html(template);
                    $("#subcategoria").html(template); 
                    console.log("Data enviada correctamente");
                    console.log(response);
                    return;
                }
            );
        }
    );
});
