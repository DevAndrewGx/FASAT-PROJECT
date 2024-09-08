$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");


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
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            processing: "Procesando...",
        },
        ajax: {
            url: baseUrl + "categorias/getCategories",
            type: "GET",
            dataType: "json",
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
    $("#formCategories").submit(function (e) {
        
        e.preventDefault();
        // evitamos el comportamiento por default
        const categoryName = $("#nombreCategoria").val().trim();
        const categoryType = $("#tipoCategoria").val();
        // realizamos las respectivas validaciones de los campos
        if (categoryName === "" && categoryType === '') {
            $("#nombreCategoria").addClass("is-invalid");
            $("#categoryNameError").show();
        } else {
            $("#nombreCategoria").removeClass("is-invalid");
            $("#categoryNameError").hide();

            // Mostrar modal de subcategoría si el checkbox está marcado y enviar la data con el mismo funcionalmiento 
            if ($("#hasSubcategory").is(":checked")) {
                console.log('its checked');
                // ocultamos el modal anterior y mostramos el nuevo
                $("#modalFormCategories").modal("hide");
                $("#subcategoryModal").modal("show");

                // Caso #2 donde le usuario crea una categoria con una subcategoria
                $("#formSubcategory").submit(function (e) {
                    e.preventDefault();
                    // se hacen las respectivas validaciones de los campos
                    const subcategoryName = $("#subCategoriaNombre").val().trim();
                    if (subcategoryName === "") {
                        $("#subCategoriaNombre").addClass("is-invalid");
                        $("#subcategoryNameError").show();  
                    } else {
                        $("#subCategoriaNombre").removeClass("is-invalid");
                        $("#subcategoryNameError").hide();  

                        // hacemos la petición para insertar la data
                        let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
                        const formData = new FormData(form);

                        // agregamos los datos de categorias para realizar la asociacíon
                        formData.append('nombreCategoria', categoryName);
                        formData.append("tipoCategoria", categoryType);                                          

                        $.ajax({
                            url: baseUrl+"categorias/createCategory",
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
                                            $("#formCategories").closest(".modal").modal("hide");
                                            $("#formSubcategory").closest(".modal").modal("hide");
                                            $("#formCategories")[0].reset();
                                            $("#formSubcategory")[0].reset();
                                            dataTableCategorias.ajax.reload(null, false);
                                            dataTableSubcategorias.ajax.reload(null,false);
                                       }
                                    });
                                }else { 
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
                                            dataTableCategorias.ajax.reload(null, false);
                                            dataTableSubcategorias.ajax.reload(null,false);
                                        }
                                    });
                                }
                            },
                        });
                    }
                })

            }else {
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
                               if(result.isConfirmed) {
                                    // Cerrar el modal y reiniciar el formulario
                                    $("#formCategories").closest(".modal").modal("hide");
                                    $("#formSubcategory").closest(".modal").modal("hide");
                                    $("#formCategories")[0].reset();
                                    $("#formSubcategory")[0].reset();
                                    dataTableCategorias.ajax.reload(null, false);
                                    dataTableSubcategorias.ajax.reload(null,false);
                               }
                            });
                        }else { 
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
                                    dataTableCategorias.ajax.reload(null, false);
                                    dataTableSubcategorias.ajax.reload(null,false);
                                }
                            });
                        }
                    },
                });
            }
            $("#nombreCategoria").val("");
        }
    });
    
    // funcion para eliminar una categoria
    $("#data-categorias").on("click", ".botonEliminar", function (e) {
         e.preventDefault();
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
                                    dataTableCategorias.ajax.reload(null, false);
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
