const optionMenu = document.querySelector(".select-menu");
const selectBtn = document.querySelector(".select-btn");
const options = document.querySelectorAll(".option");
const selectPlaceholder = document.querySelector(".select-placeholder");

// selectBtn.addEventListener("click", () => {
//     optionMenu.classList.toggle("active");
// });
// variables especiales
let id_producto;
// Definimos productoData fuera del alcance para que esté disponible en el evento change
let productoData = null;
let editar = null;
let id_foto = null; 


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

    let dataTableProductos = $("#data-productos").DataTable({
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
                    let imgSrc = row.foto
                        ? baseUrl + "public/imgs/uploads/" + row.foto
                        : baseUrl + "public/imgs/icons/product_default.svg";

                    // Retornar el HTML con la imagen y el nombre del producto
                    return (
                        '<div style="display: flex; align-items: center; gap: 10px;">' +
                        '<img src="' +
                        imgSrc +
                        '" alt="Foto" style="width:45px; height:45px; border-radius:50%;">' +
                        '<span style="font-size: 14px; color: #333;">' +
                        row.nombre_producto +
                        "</span>" +
                        "</div>"
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
        e.preventDefault();
        let form = $(this)[0];

        // let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);

        // validamos si el modal tiene la clase headerUpdate para enviar la petición en modo actualizar
        let editar = $(".modal-header").hasClass("headerUpdate") ? true : false;

        if (editar) {
           
            formData.append("id_producto", id_producto);
            formData.append("id_foto", id_foto);
        }

        $.ajax({
            url: editar ? baseUrl + "productos/actualizarProducto" : baseUrl+"productos/crearProducto",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);

                if (data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Exito",
                        text: data.message,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: "Ok",
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Cerrar el modal y reiniciar el formulario
                            $("#formProduct").closest(".modal").modal("hide");
                            dataTableProductos.ajax.reload(null, false);
                        }
                    });
                } else {
                    console.log("Something is gone wrong");
                }
            },
        });
    });

    // funcion para recuperar la data y setearla en los formularios para actualizar un producto - ADMIN
    $("#data-productos").on("click", ".botonActualizar", function () {
        id_producto = $(this).data("id");
        id_foto = $(this).data("idfoto");

        console.log(id_producto);

        console.log(id_foto);

        // actualizamos la data del modal
        $("#titleModal").html("Actualizar Producto");
        $(".modal-header")
            .removeClass("headerRegister")
            .addClass("headerUpdate");
        $("#btnText").text("Actualizar");

        
        // creamos nuestra petición ajax para traer la data y setearla en el modal
        $.ajax({
            url: baseUrl + "productos/consultarProducto",
            type: "POST",
            dataType: "json",
            data: { id_producto: id_producto },
            success: function (response) {
                if (response.status) {
                    // Verifica que response.data no sea undefined o null
                    if (response.data) {
                        // Asumiendo que necesitas el primer elemento del array data
                        productoData = response.data;
                        console.log(productoData);
                        // seteamos la data en los campos
                        $("#nombreProducto").val(productoData.nombre);
                        // $("#categoriaa").val(productoData.nombre_categoria);
                        // $("#subcategoriaa").val(productoData.nombre_subcategoria);
                        $("#precio").val(productoData.precio);
                        $("#cantidad").val(productoData.cantidad);
                        $("#descripcion").val(productoData.descripcion);

                        // Encuentra y selecciona la opción que tiene el texto de productoData.nombre_categoria
                        $("#categoria option").each(function () {
                            if (
                                $(this).text() === productoData.nombre_categoria
                            ) {
                                $(this).prop("selected", true);
                            }
                        });

                        $("#categoria").trigger("change");

                        // Encuentra y selecciona la opción que tiene el texto de productoData.nombre_subcategoria
                        $("#subcategoria option").each(function () {
                            if (
                                $(this).text() ===
                                productoData.nombre_subcategoria
                            ) {
                                $(this).prop("selected", true);
                            }
                        });
                    } else {
                        console.log("response.data está vacío o es undefined");
                    }
                } else {
                    console.log("No se encontraron datos o hubo un error.");
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Error en la solicitud AJAX: " + status + " - " + error
                );
            },
            complete: function () {
                $("#modalFormCreateProduct").modal("show");
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

                    // validamos que este en modo edicion para traer la subcategoria asociada a la categoria seleconada
                    editar = $(".modal-header").hasClass("headerUpdate") ? true : false;
                    console.log(editar);

                    // Selecciona automáticamente la subcategoría
                    // Añadir un pequeño retraso para asegurar que las opciones estén cargadas antes de seleccionar
                    if (productoData && editar) {
                        setTimeout(function () {
                            console.log(
                                "Seleccionando subcategoría con ID:",
                                productoData.id_sub_categoria
                            ); // Verificación del valor
                            $("#subcategoria").val(
                                productoData.id_sub_categoria
                            );
                            console.log(
                                "Subcategoría seleccionada:",
                                $("#subcategoria").val()
                            ); // Verificar si se aplica el valor
                        }, 100); // 100 ms de espera, ajustable según la necesidad
                    }
                }
            );
        }
    );

    // funcion para eliminar un producto - ADMIN
    $("#data-productos").on("click", ".botonEliminar", function () {
        // desabilitamos el boton despues de un click para que el usuario no le de click varias veces
        $(this).prop("disabled", true);
        console.log("Its workin.........................");
        // obtenemos el id del producto del boton
        id_producto = $(this).data("id");
        // creamos un formdata para agregar el id y evitar utilizar jsonStringfy
        let formData = new FormData();

        formData.append("id_producto", id_producto);

        // Creamos una alerta para avisar al usuario, si esta seguro de realizar esta accion
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + "productos/borrarProducto",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        let data = JSON.parse(response);
                        if (data.status) {
                            Swal.fire({
                                title: "Éxito",
                                text: data.message,
                                icon: "success",
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    dataTableProductos.ajax.reload(null, false);
                                    dataTableProductos.ajax.reload(null, false);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error",
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    //  mantener el modal abierto para que el usuario intente de nuevo
                                }
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: "Error",
                            text: "Hubo un problema con la solicitud.",
                            icon: "error",
                            allowOutsideClick: false,
                            confirmButtonText: "Ok",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // mantener el modal abierto para que el usuario intente de nuevo
                            }
                        });
                    },
                });
            }
        });
    });
});
