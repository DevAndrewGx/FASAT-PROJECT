$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");

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
