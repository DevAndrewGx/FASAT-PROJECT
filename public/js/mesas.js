const baseUrl = $('meta[name="base-url"]').attr("content");
$(document).ready(function () {
    let estado;
    let globalIdMesa;

    // Creamos datatable y la inicializamos
    let dataTableMesas = $("#data-mesas").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pagingType: "full_numbers", // Paginado con flechas y números
        pageLength: 10,
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
            url: baseUrl + "mesas/getMesas",
            type: "GET",
            dataType: "json",
            dataSrc: function (json) {
                // Crear un nuevo array para almacenar mesas únicas
                let mesasUnicas = [];
                // Usar un objeto temporal para verificar duplicados
                let temp = {};

                json.data.forEach(function (item) {
                    // Usar el nombre de la categoría como clave para verificar duplicados
                    if (!temp[item.numeroMesa]) {
                        temp[item.numeroMesa] = true;
                        mesasUnicas.push(item);
                    }
                });

                // Devolver las categorías únicas
                return mesasUnicas;
            },
        },
        columns: [
            { data: "checkmarks" },
            {
                data: "numeroMesa",
                render: function (data) {
                    return `#${data}`;
                },
            },
            {
                data: "capacidad",
                render: function (data) {
                    return `${data} personas`;
                },
            },
            {
                data: "estado",
                render: function (data) {
                    let badgeClass;
                    switch (data) {
                        case "DISPONIBLE":
                            badgeClass = "bg-lightgreen";
                            break;
                        case "EN VENTA":
                            badgeClass = "bg-lightred";
                            break;
                        default:
                            badgeClass = "bg-lightgray";
                    }
                    return `<span class="badges ${badgeClass}">${data}</span>`;
                },
            },
            { data: "options" },
        ],

        columnDefs: [
            {
                targets: [0, 4],
                orderable: false,
            },
        ],
    });

    // validación del formulario de mesas para agrear una mesa con AJAX
    $("#formMesas").on("submit", function (e) {
        // evitamos el evento por defecto, para que no recargue la pagina
        e.preventDefault();
        let form = $(this)[0];
        console.log(form);
        // creamos un formData y le pasamos el formulario
        const formData = new FormData(form);

        // validamos si el modal tiene la clase headerUpdate para enviar la petición en modo actualizar
        let editar = $(".modal-header").hasClass("headerUpdate") ? true : false;

        if (editar) {
            formData.append("id_mesa", globalIdMesa);
        }
        // creamos la petición para enviar la data al servidor y obtener una respuesta
        $.ajax({
            url: editar
                ? baseUrl + "mesas/actualizarMesa"
                : baseUrl + "mesas/createTable",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                // convertirmos la data que viene del servidor en un JSON para manejar de mejor forma
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
                            $("#formMesas").closest(".modal").modal("hide");
                            dataTableMesas.ajax.reload(null, false);
                        }
                    });
                }
            },
            error: function (response) {
                // ERROR EN LA RESPUESTA DEL SERVIDOR
            },
        });
    });

    // vamos a dividir la funcion de cargarMesasPorEstado para utilizar en pedidos y asi poder actualizar un pedido facilmente

    /**Esta funcion nos permitira realizar la peticion 
    para traer las tablas por estado, y asi
    quemar o hacer scripting en el DOM para mostrar las mesas segun el estado**/
    $("#btnCrearPedido").on("click", function (e) {
        let estado = $("#abrirMesaModal").hasClass("show")
            ? "EN SERVICIO"
            : "DISPONIBLE";
        e.preventDefault();
        cargarMesasPorEstado(estado);
    });

    // funcion para abrir una mesa en la interfaz del mesero para crear un nuevo pedido
    $("#abrirMesaForm").on("submit", function (e) {
        estado = "EN SERVICIO";
        // prevenimos el efecto por default
        e.preventDefault();
        console.log("its working bitch");

        // ocultamos el modal para abrir una mesa
        $("#abrirMesaModal").modal("hide");
        // mostramos el modal para generar un pedido.
        $("#generarPedidoModal").modal("show");

        // seleccionamos el formulario del DOM
        let form = $(this)[0];
        const formData = new FormData(form);
        // agregamos el capo de estado
        formData.append("estado", estado);

        $.ajax({
            url: baseUrl + "mesero/abrirMesa",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);

                $("#estado-mesa").text(data.dataMesa.numero_mesa);
            },
        });
    });

    // funcion para actualizar una mesa desde la interfaz del admin
    $("#data-mesas").on("click", ".botonActualizar", function (e) {
        e.preventDefault();

        // Obtenemos los valores del data-id para verificar que elemento actualizar
        globalIdMesa = $(this).data("id");

        // actualizamos la data del modal
        $("#titleModal").html("Actualizar Mesa");
        $(".modal-header")
            .removeClass("headerRegister")
            .addClass("headerUpdate");
        $("#btnText").text("Actualizar");

        // enviamos la peticion para traer la data y establecerla en el modal
        $.ajax({
            url: baseUrl + "mesas/consultarMesa",
            type: "POST",
            dataType: "json",
            data: { id_mesa: globalIdMesa },
            success: function (response) {
                if (response.status) {
                    // Verifica que response.data no sea undefined o null
                    if (response.data) {
                        // Asumiendo que necesitas el primer elemento del array data
                        var mesaData = response.data;
                        // seteamos la data en los campos
                        $("#numeroMesa").val(mesaData.numero_mesa);
                        $("#capacidad").val(mesaData.capacidad);
                        $("#estado").val(mesaData.estado);
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
                $("#modalFormMesas").modal("show");
            },
        });
    });

    // funcion para borrar una mesa desde la interfaz del admin
    $("#data-mesas").on("click", ".botonEliminar", function () {
        // traemos la data del id de la mesa
        globalIdMesa = $(this).data("id");
        let formData = new FormData();

        formData.append("id_mesa", globalIdMesa);

        console.log("something " + globalIdMesa);

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
                    url: baseUrl + "mesas/borrarMesa",
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
                                    dataTableMesas.ajax.reload(null, false);
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

    // FUNCIONES UTILITARIAS PARA VALIDAR SI EL MODAL ESTA ABIERTO O CERRADO PARA CAMBIAR EL ESTADO
    $("#abrirMesaModal").on("shown.bs.modal", function () {
        estado = "DISPONIBLE"; // Cambiamos el estado a "DISPONIBLE" cuando el modal se abre
        console.log("El modal se ha abierto, estado: " + estado);
    });
});

export function cargarMesasPorEstado(
    estado,
    mesaActual = null,
    editar = false
) {
    return $.post(
        `${baseUrl}mesas/getTablasPorEstado`,
        { estado: estado },
        function (response) {
            let mesas = JSON.parse(response);
            console.log(mesas);

            // Limpia las opciones previas
            $("#numeroMesa").empty();

            // Añade la opción por defecto
            let template = "<option value=''>Seleccione una mesa</option>";

            mesas.data.forEach((mesa) => {
                // Genera las opciones correctamente
                template += `
                    <option data-estado="${mesa.estado}" value="${mesa.id_mesa}">
                        ${mesa.numeroMesa}
                    </option>`;
            });

            if (
                mesaActual &&
                editar &&
                !mesas.data.some((mesa) => mesa.id_mesa == mesaActual.id_mesa)
            ) {
                console.log("Entra para actualizar la mesa y seleccionarla bb");
                template += `
                    <option value="${mesaActual.id_mesa}" selected>
                        ${mesaActual.numero_mesa}
                    </option>`;
            }
            console.log("ho hace nada mucho hp :(");
            // Añade las opciones generadas al select
            $("#numeroMesa").append(template);
        }
    );
    // Referencia al campo "Número de mesa"
    const numeroMesaInput = document.getElementById("numeroMesa");

    // Función para validar que el número sea positivo
    function validarNumeroMesa() {
        const valor = parseInt(numeroMesaInput.value, 10); // Convertir a número entero
        const errorDiv = document.getElementById("mesaNameError"); // Div del error

        // Verificar si el valor es menor o igual a 0 o NaN
        if (isNaN(valor) || valor <= 0) {
            numeroMesaInput.classList.add("is-invalid"); // Agregar clase de error
            errorDiv.style.display = "block"; // Mostrar mensaje de error
            errorDiv.textContent =
                "Por favor, ingresa un número positivo mayor que 0.";
        } else {
            numeroMesaInput.classList.remove("is-invalid"); // Quitar clase de error
            errorDiv.style.display = "none"; // Ocultar mensaje de error
        }
    }

    // Evento en tiempo real para validar mientras se escribe
    numeroMesaInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ""); // Eliminar caracteres no numéricos
        validarNumeroMesa(); // Ejecutar validación
    });

    // Referencia al campo "Capacidad"
    const capacidadInput = document.getElementById("capacidad");

    // Función para validar el campo "Capacidad"
    function validarCapacidad() {
        const valor = parseInt(capacidadInput.value, 10); // Convertir a número entero
        const errorDiv = document.getElementById("capacidadError"); // Referencia al mensaje de error

        // Verificar si el valor es inválido (NaN, menor que 1 o mayor que 30)
        if (isNaN(valor) || valor < 1 || valor > 30) {
            capacidadInput.classList.add("is-invalid"); // Agregar clase de error
            errorDiv.style.display = "block"; // Mostrar mensaje de error
            errorDiv.textContent = "Por favor, ingresa un número entre 1 y 30.";
        } else {
            capacidadInput.classList.remove("is-invalid"); // Quitar clase de error
            errorDiv.style.display = "none"; // Ocultar mensaje de error
        }
    }

    // Validación en tiempo real
    capacidadInput.addEventListener("input", function () {
        // Permitir solo números positivos y eliminar ceros iniciales
        this.value = this.value.replace(/^0+/, "").replace(/[^0-9]/g, "");
        validarCapacidad(); // Ejecutar validación
    });
}
