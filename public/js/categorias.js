$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    const submitButton = $(this).find('button[type="submit"]');

    let globalIdCategoria;
    let isDisableButton = false;


    // creamos la variable para iniciar la datatable para mostrar los datos
    let dataTableCategorias = $("#data-categorias").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 10, // Muestra 10 registros por página
        language: {
            lengthMenu: "Mostrar _MENU_ Registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            processing: "Procesando...",
        },
        ajax: {
            url: baseUrl + "categorias/getCategories",
            type: "GET",
            dataType: "json",
            dataSrc: function (json) {
                // Crear un nuevo array para almacenar categorías únicas
                let uniqueCategories = [];
                // Usar un objeto temporal para verificar duplicados
                let temp = {};

                json.data.forEach(function (item) {
                    // Usar el nombre de la categoría como clave para verificar duplicados
                    if (!temp[item.nombre_categoria]) {
                        temp[item.nombre_categoria] = true;
                        uniqueCategories.push(item);
                    }
                });

                // Devolver las categorías únicas
                return uniqueCategories;
            },
        },
        columns: [
            { data: "checkmarks" },
            { data: "nombre_categoria" },
            { data: "tipo_categoria" },
            { data: "options" },
        ],
        columnDefs: [
            {
                targets: [0, 3],
                orderable: false,
            },
        ],
    });
   let dataTableSubcategorias = $("#data-categorias-subcategorias").DataTable({
       responsive: true,
       processing: true,
       serverSide: true,
       pageLength: 10, // Muestra 10 registros por página
       language: {
           lengthMenu: "Mostrar _MENU_ Registros",
           zeroRecords: "No se encontraron subcategorias asociadas",
           info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
           infoEmpty:
               "Mostrando registros del 0 al 0 de un total de 0 registros",
           infoFiltered: "(filtrado de un total de _MAX_ registros)",
           search: "Buscar:",
           processing: "Procesando...",
       },
       ajax: {
           url: baseUrl + "categorias/getCategories",
           type: "GET",
           dataType: "json",
           dataSrc: function (json) {
               // Filtrar las filas que tienen `nombre_subcategoria` null o vacío
               return json.data.filter(function (item) {
                   return (
                       item.nombre_subcategoria !== null &&
                       item.nombre_subcategoria !== ""
                   );
               });
           },
       },
       columns: [
           { data: "checkmarks" },
           { data: "nombre_subcategoria" },
           { data: "nombre_categoria" },
           { data: "options" },
       ],
       columnDefs: [
           {
               targets: [0, 3],
               orderable: false,
           },
       ],
   });

    // Funcion para agregar una nueva categoria
    $("#formCategories").off("submit").on("submit", function (e) {
        e.preventDefault();


        // Deshabilitar el botón de envío de este formulario
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop("disabled", true);
        
        // submitButton.prop("disabled", true);

        // evitamos el comportamiento por default
        const categoryName = $("#nombreCategoria").val().trim();
        const categoryType = $("#tipoCategoria").val();
        // realizamos las respectivas validaciones de los campos
        if (categoryName === "" && categoryType === "") {
            $("#nombreCategoria").addClass("is-invalid");
            $("#categoryNameError").show();
        } else {
            $("#nombreCategoria").removeClass("is-invalid");
            $("#categoryNameError").hide();

            // Mostrar modal de subcategoría si el checkbox está marcado y enviar la data con el mismo funcionalmiento
            if ($("#hasSubcategory").is(":checked")) {
                console.log("its checked");
                // ocultamos el modal anterior y mostramos el nuevo
                $("#modalFormCategories").modal("hide");
                $("#subcategoryModal").modal("show");

                // Caso #2 donde le usuario crea una categoria con una subcategoria
                $("#formSubcategory").off("submit").on("submit",function (e) {

                    e.preventDefault();
                       // Deshabilitar el botón de envío de este formulario
                    const submitSubcategoryButton = $(this).find('button[type="submit"]');
                    submitSubcategoryButton.prop("disabled", true);

                    // se hacen las respectivas validaciones de los campos
                    const subcategoryName = $("#subCategoriaNombre")
                        .val()
                        .trim();
                    if (subcategoryName === "") {
                        $("#subCategoriaNombre").addClass("is-invalid");
                        $("#subcategoryNameError").show();
                        submitSubcategoryButton.prop("disable", false);
                        return;
                    } else {
                        $("#subCategoriaNombre").removeClass("is-invalid");
                        $("#subcategoryNameError").hide();
                    }
                    // hacemos la petición para insertar la data
                    let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
                    const formData = new FormData(form);

                    // agregamos los datos de categorias para realizar la asociacíon
                    formData.append("nombreCategoria", categoryName);
                    formData.append("tipoCategoria", categoryType);

                    $.ajax({
                        url: baseUrl + "categorias/createCategory",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (response) {
                            let data = JSON.parse(response);

                            if (data.status) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Categoria y subcategoria creadas",
                                    text: data.message,
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                }).then(function (result) {
                                    // Cerrar el modal y reiniciar el formulario
                                    if (result.isConfirmed) {
                                        // Cerrar el modal y reiniciar el formulario
                                        $("#formCategories")
                                            .closest(".modal")
                                            .modal("hide");
                                        $("#formSubcategory")
                                            .closest(".modal")
                                            .modal("hide");
                                        $("#formCategories")[0].reset();
                                        $("#formSubcategory")[0].reset();
                                        dataTableCategorias.ajax.reload(
                                            null,
                                            false
                                        );
                                        dataTableSubcategorias.ajax.reload(
                                            null,
                                            false
                                        );
                                        submitSubcategoryButton.prop("disabled", false);
                                        submitButton.prop("disabled", false);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "No se pudo guardar la categoria",
                                    text: data.message,
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    confirmButtonText: "Ok",
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        // Cerrar el modal y reiniciar el formulario
                                        $("#formCategories")
                                            .closest(".modal")
                                            .modal("hide");
                                        $("#formSubcategory")
                                            .closest(".modal")
                                            .modal("hide");
                                        $("#formCategories")[0].reset();
                                        $("#formSubcategory")[0].reset();
                                        dataTableCategorias.ajax.reload(
                                            null,
                                            false
                                        );
                                        dataTableSubcategorias.ajax.reload(
                                            null,
                                            false
                                        );
                                        submitSubcategoryButton.prop("disabled", false);
                                        submitButton.prop("disabled", false);
                                    }
                                });
                            }
                        },
                    });
                    
                });
            } else {
                // Caso #1 donde le usuario solo crea categoria pero sin subcategoria
                let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
                console.log(form);
                const formData = new FormData(form);

                $.ajax({
                    url: baseUrl + "categorias/createCategory",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        let data = JSON.parse(response);

                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Categoria creada",
                                text: data.message,
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    // Cerrar el modal y reiniciar el formulario
                                    $("#formCategories")
                                        .closest(".modal")
                                        .modal("hide");
                                    $("#formSubcategory")
                                        .closest(".modal")
                                        .modal("hide");
                                    $("#formCategories")[0].reset();
                                    $("#formSubcategory")[0].reset();
                                    dataTableCategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                    dataTableSubcategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                    console.log('El boton se habilita nuevamente');
                                    // habilitamos el boton nuevamente cuando el usuario acepta
                                    submitButton.prop("disabled", false);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "No se pudo guardar la categoria",
                                text: data.message,
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    // Cerrar el modal y reiniciar el formulario
                                    $("#formCategories")
                                        .closest(".modal")
                                        .modal("hide");
                                    $("#formSubcategory")
                                        .closest(".modal")
                                        .modal("hide");
                                    $("#formCategories")[0].reset();
                                    $("#formSubcategory")[0].reset();
                                    dataTableCategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                    dataTableSubcategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                }
                            });
                        }
                    },
                });
            }
        }
    });
    
    // funcion para eliminar una categoria
    $("#data-categorias").on("click", ".botonEliminar", function (e) {
        e.preventDefault();
        $(this).prop("disabled", true); // Deshabilitar el botón para que el usuario no di click como
        const id_categoria = $(this).data("id");
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
                    url: baseUrl + "categorias/delete",
                    type: "POST",
                    processData: false,
                    contentType: "application/json",
                    data: JSON.stringify({
                        id_categoria: id_categoria,
                    }),
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
                                    dataTableCategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                    dataTableSubcategorias.ajax.reload(
                                        null,
                                        false
                                    );
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


    // funcion para eliminar una subcategorias
    $("#data-categorias-subcategorias").on("click", ".botonEliminar", function(e) {
        console.log('its inside');
        // cancelamos el evento por default
        e.preventDefault();
        // creamos la variable para almacenar el id que viene del fomulario
        const idSubCategoria = $(this).data("id-s");
        console.log(idSubCategoria);
        // creamos la alerta para la confirmación del usuario
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
                    url: baseUrl + "categorias/deleteSubCategoria",
                    type: "POST",
                    processData: false,
                    contentType: "application/json",
                    data: JSON.stringify({
                        idSubCategoria: idSubCategoria,
                    }),
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
                                    dataTableCategorias.ajax.reload(
                                        null,
                                        false
                                    );
                                    dataTableSubcategorias.ajax.reload(
                                        null,
                                        false
                                    );
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

    // funcion para actualizar subcategorias y categorias con el modo edición
    $("#data-categorias").on("click", ".botonActualizar", function(e) {
        // prevenimos el efecto por defecto
        e.preventDefault();

        // obtenemos el id de la categoria del formulario
        globalIdCategoria = $(this).data("id");
        console.log(globalIdCategoria);

        // cambiamos la clase del title modal para actualizar data
        $("#titleModal").html("Actualizar categoria");
        $(".modal-header")
            .removeClass("headerRegister")
            .addClass("headerUpdate");
        $("#addCategory").text("Actualizar categoria");

        // ocultamos la opcion de subCategoria
        $("#subCategoryOption").hide();

        // Enviamos la peteción para traer la data de la categoria y mostrarla en el formulario

        $.ajax({
            url: baseUrl + "categorias/getCategory",
            type: "POST",
            dataType: "json",
            data: JSON.stringify({ id_categoria: globalIdCategoria}),
            // respuesta del servidor
            success: function (response) {
                // validamos si la respuesta del servidor es correcta
                if (response.status) {
                    // verificamos que la data no este nulla
                    if (response.data) {
                        // tomamos los datos del arreglo para setearlos al formulario
                        var categoriaData = response.data;

                        $("#nombreCategoria").val(
                            categoriaData.nombre_categoria
                        );
                        $("#tipoCategoria").val(categoriaData.tipo_categoria);
                    } else {
                        console.log("Data isn't exist or is undefined");
                    }
                } else {
                    console.log("Data no exist");
                }
            },
            error: function (response) {},
            complete: function () {
                $("#modalFormCategories").modal("show");
            },
        });
    });

    

    // Funcion para habilitar nuevamente el boton
    $("#modalFormCategories").on("hidden.bs.modal", function () {
        // Habilita el botón al cerrar el modal
        $(submitButton).prop("disable", false);
    });

});
