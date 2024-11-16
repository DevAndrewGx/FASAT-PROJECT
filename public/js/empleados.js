$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");

    // Variables globales para datos específicos 
    let globalIdUsuario;
    let globalIdFoto;

    let dataTable = $("#data-empleados").DataTable({
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
            url: baseUrl + "users/getUsers",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        '<div style="display: flex;  align-items: center; gap: 10px;">' +
                        '<img src="' +
                        baseUrl +
                        "public/imgs/uploads/" +
                        row.foto +
                        '" alt="Foto" style="width:45px; height:45px; border-radius:50%;">' +
                        '<span style="font-size: 14px; color: #333;">' +
                        row.nombres +
                        "</span>" +
                        "</div>"
                    );   
                },
            },
            { data: "apellidos" },
            { data: "documento" },
            { data: "telefono" },
            { data: "correo" },
            { data: "estado" },
            { data: "rol" },
            { data: "fechaCreacion" },
            { data: "options" },
        ],
        order: [[2, "asc"]], // Ordenar por la columna nombre_categoria (segunda columna, índice 1)
        columnDefs: [
            {
                targets: [0, 9],
                orderable: false,
            },
        ],
    });

    // Validación del formulario
    $("#formUsuario").submit(function (e) {
        e.preventDefault();

        // Limpiar los mensajes de error
        $(".invalid-feedback").hide();
        $(".form-control").removeClass("is-invalid");

        let valid = true;
        const identificacion = $("#identificacion").val().trim();
        const nombres = $("#nombres").val().trim();
        const apellidos = $("#apellidos").val().trim();
        const telefono = $("#telefono").val().trim();
        const email = $("#email").val().trim();
        const rol = $("#rol").val();
        const estado = $("#estado").val();
        const password = $("#password").val().trim();
        const validarPassword = $("#validarPassword").val().trim();
        const foto = $("#foto")[0].files.length; // Verificar si se ha seleccionado una foto

        // Validación de campos
        if (identificacion === '') {
            $("#identificacion").addClass("is-invalid");
            $("#identificacionError").show();
            valid = false;
        }

        if (nombres === '') {
            $("#nombres").addClass("is-invalid");
            $("#nombresError").show();
            valid = false;
        }

        if (apellidos === '') {
            $("#apellidos").addClass("is-invalid");
            $("#apellidosError").show();
            valid = false;
        }

        if (telefono === '') {
            $("#telefono").addClass("is-invalid");
            $("#telefonoError").show();
            valid = false;
        }

        if (email === '') {
            $("#email").addClass("is-invalid");
            $("#emailError").show();
            valid = false;
        }

        if (rol === 'Seleccione') {
            $("#rol").addClass("is-invalid");
            $("#rolError").show();
            valid = false;
        }

        if (estado === 'Seleccione') {
            $("#estado").addClass("is-invalid");
            $("#estadoError").show();
            valid = false;
        }

        // Validar contraseña
        if (password === '') {
            $("#password").addClass("is-invalid");
            $("#passwordError").show();
            valid = false;
        } else if (password.length < 8) {
            $("#password").addClass("is-invalid");
            $("#passwordError").text('La contraseña debe tener al menos 8 caracteres.').show();
            valid = false;
        } else {
            $("#passwordError").hide();
        }

        // Validar confirmar contraseña
        if (validarPassword === '') {
            $("#validarPassword").addClass("is-invalid");
            $("#validarPasswordError").show();
            valid = false;
        } else if (validarPassword.length < 8) {
            $("#validarPassword").addClass("is-invalid");
            $("#validarPasswordError").text('La contraseña debe tener al menos 8 caracteres.').show();
            valid = false;
        } else {
            $("#validarPasswordError").hide();
        }

        // Verificar coincidencia de contraseñas
        if (password !== validarPassword) {
            $("#password").addClass("is-invalid");
            $("#passwordError").text('Las contraseñas no coinciden.').show();
            $("#validarPassword").addClass("is-invalid");
            $("#validarPasswordError").text('Las contraseñas no coinciden.').show();
            valid = false;
        }

        // Verificar si se ha seleccionado una foto
        if (foto === 0) {
            Swal.fire({
                title: "Advertencia",
                text: "Por favor, selecciona una foto de perfil.",
                icon: "warning",
                allowOutsideClick: false,
                confirmButtonText: "Ok",
            });
            valid = false;
        }

        if (!valid) return; // Si no es válido, no continuar con la solicitud

        let form = $(this)[0]; // Selecciona el formulario como un elemento DOM
        const formData = new FormData(form);
        var editar = $(".modal-header").hasClass("headerUpdate") ? true : false;

        if (editar) {
            // Cuando estamos en el modo editar agregamos la data del id y la foto al formData
            formData.append("id_usuario", globalIdUsuario);
            formData.append("id_foto", globalIdFoto);
        }

        $.ajax({
            url: editar === false ? baseUrl + "users/createUser" : baseUrl + "users/actualizarUsuario",
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
                            $("#formUsuario").closest(".modal").modal("hide");
                            $("#formUsuario")[0].reset();
                            dataTable.ajax.reload(null, false);
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
                        // No cerrar el modal en caso de error
                        if (result.isConfirmed) {
                           
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
                    // No cerrar el modal en caso de error
                    if (result.isConfirmed) {
                        // mantener el modal abierto para que el usuario intente de nuevo
                    }
                });
            },
        });
    });

    // Function para borrar un usuario
    $("#data-empleados").on("click", ".botonEliminar", function (e) {
        e.preventDefault();
        const id_usuario = $(this).data("id");
        const id_foto = $(this).data("idfoto");
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
                    url: baseUrl + "users/borrar",
                    type: "POST",
                    processData: false,
                    contentType: "application/json",
                    data: JSON.stringify({
                        id_usuario: id_usuario,
                        id_foto: id_foto,
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
                                    dataTable.ajax.reload(null, false);
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



    // Función para abrir el modal en modo de creación o edición
     $("#data-empleados").on("click", ".botonActualizar", function (e) {
         e.preventDefault();

         // Obtener los valores de data-id y data-idfoto del botón clicado y almacenarlos en variables globales
         globalIdUsuario = $(this).data("id");
         globalIdFoto = $(this).data("idfoto");

         $("#titleModal").html("Actualizar usuario");
         $(".modal-header")
             .removeClass("headerRegister")
             .addClass("headerUpdate");
         $("#btnText").text("Actualizar");

         // enviamos la peticion para traer la data y establecerla en el modal
         $.ajax({
             url: baseUrl + "users/getUser",
             type: "POST",
             dataType: "json",
             data: JSON.stringify({ id_usuario: globalIdUsuario }),
             success: function (response) {
                 if (response.status) {
                     // Verifica que response.data no sea undefined o null
                     if (response.data) {
                        // Asumiendo que necesitas el primer elemento del array data
                        var userData = response.data;

                        // seteamos la data en los campos
                        $("#identificacion").val(userData.documento);
                        console.log(userData.documento);
                        $("#nombres").val(userData.nombres);
                        $("#apellidos").val(userData.apellidos);
                        $("#telefono").val(userData.telefono);
                        $("#email").val(userData.correo);
                        $("#estado").val(userData.id_estado);
                        $("#rol").val(userData.id_rol);
                        $("#fechaCreacion").val(userData.fechaCreacion);
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
                 $("#modalFormUsuario").modal("show");
             },
         });    
     });

    // Función para abrir el modal en modo de creación
    $("#btnCrear").click(function () {
        $("#formUsuario")[0].reset(); // Limpiar el formulario
        $("#modalUsuario .modal-header").removeClass("headerUpdate");
        $("#modalUsuario").modal("show");
    });
});
