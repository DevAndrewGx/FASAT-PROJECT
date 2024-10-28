$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    let estado;

    // Creamos datatable y la inicializamos 
    let dataTableMesas = $("#data-mesas").DataTable({
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
            url: baseUrl + "mesas/getMesas",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            { data: "numeroMesa" },
            {
                data: "estado",
                render: function (data) {
                    // Cambia el estilo según el valor de "estado"
                    let badgeClass;
                    switch (data) {
                        case "DISPONIBLE":
                            badgeClass = "bg-lightgreen";
                            break;
                        case "EN SERVICIO":
                            badgeClass = "bg-lightred";
                            break;
                        case "EN VENTA":
                            badgeClass = "bg-lightyellow";
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
                targets: [0, 3],
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
        // creamos la petición para enviar la data al servidor y obtener una respuesta

        $.ajax({
            url: baseUrl + "mesas/createTable",
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
                        title: "Mesa creada exitosamente",
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


    /**Esta funcion nos permitira realizar la peticion 
    para traer las tablas por estado, y asi
    quemar o hacer scripting en el DOM para mostrar las mesas segun el estado**/
    $("#openOrderForm").on('click', function(e) {
        
        // validamos si el modal esta abierto para asignar el estado
        if (!$("#abrirMesaModal").hasClass("show")) {
            estado = "DISPONIBLE";
        } else {
            estado = "EN SERVICIO";
        }
        console.log(estado);
        // cancelamos el efecto por default
        e.preventDefault();

        $.post(`${baseUrl}mesas/getTablasPorEstado`, { estado: estado}, function(response) {
            let mesas = JSON.parse(response);
            console.log(mesas);

            let template = "<option ='#'>Seleccione una mesa</option>";
            
            mesas.data.forEach((mesa)=> { 
                template += `
                <option value="${mesa.id_mesa}">${mesa.numeroMesa}</option>
                `;
            });
            $("#numeroMesa").html(template);
        });
    });
    
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

    
    // FUNCIONES UTILITARIAS PARA VALIDAR SI EL MODAL ESTA ABIERTO O CERRADO PARA CAMBIAR EL ESTADO
    $("#abrirMesaModal").on("shown.bs.modal", function () {
        estado = "DISPONIBLE"; // Cambiamos el estado a "DISPONIBLE" cuando el modal se abre
        console.log("El modal se ha abierto, estado: " + estado);
    });
});
