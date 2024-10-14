$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");

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
                        case "ABIERTA":
                            badgeClass = "bg-lightgreen";
                            break;
                        case "CERRADA":
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
                            dataTable.ajax.reload(null, false);
                        }
                    });
                }
            },
            error: function (response) {
                // ERROR EN LA RESPUESTA DEL SERVIDOR
            },
        });
    });
});
