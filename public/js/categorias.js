$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    const categoriesTable = $("#categoriesTable tbody");
    const subcategoryTable = $("#subcategoryTable tbody");


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
                        console.log(form);
                        const formData = new FormData(form);

                        // agregamos los datos de categorias para realizar la asociacíon
                        formData.append('nombreCategoria', categoryName);
                        formData.append("tipoCategoria", categoryType);
                        console.log(formData.append('nombreCategoria', categoryName));
                        console.log(categoryType);                                          

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
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        timer: 5000,
                                    }).then(function () {
                                        // Cerrar el modal y reiniciar el formulario
                                        $("#formCategories")
                                            .closest(".modal")
                                            .modal("hide");
                                        $("#formCategories")[0].reset();
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
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 5000,
                            }).then(function () {
                                // Cerrar el modal y reiniciar el formulario
                                $("#formCategories").closest(".modal").modal("hide");
                                $("#formCategories")[0].reset();
                            });
                        }
                    },
                });
            }
            $("#nombreCategoria").val("");
        }
    });

    // Editar categoría
    // categoriesTable.on("click", ".edit-category", function () {
    //     const row = $(this).closest("tr");
    //     const categoryName = row.find("td").eq(0).text();

    //     $("#categoryName").val(categoryName);
    //     row.remove();
    // });

    // Eliminar categoría
    // categoriesTable.on("click", ".delete-category", function () {
    //     $(this).closest("tr").remove();
    // });

    // Funcion para agregar una subcategoria
    // $("#addSubcategory").click(function () {
    //     const subcategoryName = $("#subcategoryName").val().trim();

    //     // se hacen las respectivas validaciones de los campos
    //     if (subcategoryName === "") {   
    //         $("#subcategoryName").addClass("is-invalid");
    //         $("#subcategoryNameError").show();

            
    //     } else {
    //         $("#subcategoryName").removeClass("is-invalid");
    //         $("#subcategoryNameError").hide();

    //         // Añadir nueva subcategoría a la tabla
    //         // const newRow = `<tr>
    //         //                         <td>${subcategoryName}</td>
    //         //                         <td class="text-center">
    //         //                             <button class="btn btn-warning btn-sm edit-subcategory">Editar</button>
    //         //                             <button class="btn btn-danger btn-sm delete-subcategory">Eliminar</button>
    //         //                         </td>
    //         //                     </tr>`;
    //         // subcategoryTable.append(newRow);
    //         // $("#subcategoryName").val("");
    //     }
    // });

    // Editar subcategoría
    // subcategoryTable.on("click", ".edit-subcategory", function () {
    //     const row = $(this).closest("tr");
    //     const subcategoryName = row.find("td").eq(0).text();

    //     $("#subcategoryName").val(subcategoryName);
    //     row.remove();
    // });

    // Eliminar subcategoría
    // subcategoryTable.on("click", ".delete-subcategory", function () {
    //     $(this).closest("tr").remove();
    // });
    // Creamos la funcion para enviar la peticion para crear una categoria
});
