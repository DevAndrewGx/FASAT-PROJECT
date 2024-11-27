$(document).ready(function() { 
    const baseUrl = $('meta[name="base-url"]').attr("content");
    $.ajax({
        url: baseUrl + "cheff/consultarPedidosCheff",
        type: "GET",
        success: function (response) {
            if (response) {
                let dataResponse = JSON.parse(response);

                if(dataResponse.status && dataResponse.data) { 
                    // guardamos el contenedor de los pedidos en una variable
                    const contenedorPedidos = $('#contenedor-pedidos');
                    // vaciamos el contenedor para evitar la duplicidad de data
                    contenedorPedidos.empty();

                    dataResponse.data.forEach(pedido => {
                        const pedidoHTML = renderizarPedido(pedido);
                        contenedorPedidos.append(pedidoHTML);
                    });

                    // Delegación de eventos para el botón "Iniciar"
                    // Delegación de eventos para el botón "Iniciar"
                contenedorPedidos.on('click', '[data-role="iniciar"]', function () {
                    const iniciarBoton = $(this);
                    const completarBoton = iniciarBoton.siblings('[data-role="completar"]'); // Encuentra el botón "Completar"
                    const pedidoCard = iniciarBoton.closest('.card'); // Encuentra la tarjeta del pedido
                    const pedidoId = pedidoCard.find('#codigo-pedido-cheff').text(); // Identifica el código del pedido

                    // Busca el pedido correspondiente en los datos
                    const pedido = dataResponse.data.find(p => p.codigo_pedido === pedidoId);

                    if (pedido) {
                        cambiarEstadoBotonYPedido(iniciarBoton, completarBoton, pedido.productos_detallados, pedido);
                    }
                });

                // Delegación de eventos para el botón "Completar"
                contenedorPedidos.on('click', '[data-role="completar"]', function () {
                    const completarBoton = $(this);
                    const iniciarBoton = completarBoton.siblings('[data-role="iniciar"]'); // Encuentra el botón "Iniciar"
                    const pedidoCard = completarBoton.closest('.card'); // Encuentra la tarjeta del pedido
                    const pedidoId = pedidoCard.find('#codigo-pedido-cheff').text(); // Identifica el código del pedido

                    // Busca el pedido correspondiente en los datos
                    const pedido = dataResponse.data.find(p => p.codigo_pedido === pedidoId);

                    if (pedido) {
                        cambiarEstadoBotonYPedidoACompletado(iniciarBoton, completarBoton, pedido.productos_detallados, pedido);

                        // Deshabilitar ambos botones
                        iniciarBoton.prop('disabled', true);
                        completarBoton.prop('disabled', true);
                    }
                });

            }else { 
                console.log("No se encontraron datos o hubo un error.");
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
    });  


    // Función para cambiar el estado de los botones y del pedido
    function cambiarEstadoBotonYPedido(iniciarBoton, completarBoton, productos, pedido) {
     // Cambiar el estado localmente
        pedido.estado = "EN PREPARACION";
        console.log("INICIAR");

         // Actualizar en el servidor
        // $.ajax({
        //     url: baseUrl + "cheff/actualizarEstadoPedido",
        //     type: "POST",
        //     data: {
        //         id_pedido: pedido.id_pedido,
        //         estado: pedido.estado,
        //         productos: productos.map(producto => ({
        //             id_producto: producto.id_producto,
        //             estado: "En preparación"
        //         }))
        //     },
        //     success: function(response) {
        //         if (response.status) {
        //             console.log("Estado actualizado correctamente en el servidor");
        //         } else {
        //             console.error("Error al actualizar el estado en el servidor");
        //         }
        //     },
        //     error: function(xhr, status, error) {
        //         console.error("Error en la solicitud AJAX:", error);
        //     }
        // });

        // Selecciona el elemento que muestra el estado del pedido
        const elementoEstado = iniciarBoton.closest('.card').find('.badges');

        // Actualiza visualmente el estado del pedido
        actualizarEstadoVisual(elementoEstado, pedido.estado);

        // Cambiar el estado de los productos
        productos.forEach((producto) => {
            producto.estado = "EN PREPARACION";
            iniciarBoton.closest(".border").find('.badge').text(producto.estado);
        });

        // Actualizar los botones en la interfaz
        iniciarBoton.removeClass('btn-dark').addClass('bg-transparent').prop('disabled', true);
        completarBoton.removeClass('bg-transparent').addClass('btn-dark').prop('disabled', false);
}


    function cambiarEstadoBotonYPedidoACompletado(iniciarBoton, completarBoton, productos, pedido) {
        // Cambiar el estado del pedido a "COMPLETADO"
        // Cambiar el estado localmente
        pedido.estado = "COMPLETADO";
        console.log("COMPLETAR");

        // Actualizar en el servidor
        // $.ajax({
        //     url: baseUrl + "cheff/actualizarEstadoPedido",
        //     type: "POST",
        //     data: {
        //         id_pedido: pedido.id_pedido,
        //         estado: pedido.estado,
        //         productos: productos.map(producto => ({
        //             id_producto: producto.id_producto,
        //             estado: "Completado"
        //         }))
        //     },
        //     success: function(response) {
        //         if (response.status) {
        //             console.log("Estado actualizado correctamente a COMPLETADO en el servidor");
        //         } else {
        //             console.error("Error al actualizar el estado a COMPLETADO en el servidor");
        //         }
        //     },
        //     error: function(xhr, status, error) {
        //         console.error("Error en la solicitud AJAX:", error);
        //     }
        // });

        // Selecciona el elemento que muestra el estado del pedido
        const elementoEstado = completarBoton.closest(".card").find(".badges");

        // Actualiza visualmente el estado del pedido
        actualizarEstadoVisual(elementoEstado, pedido.estado);

        // Cambiar el estado de los productos
        productos.forEach((producto) => {
            producto.estado = "COMPLETADO";
            completarBoton
                .closest(".border")
                .find(".badge")
                .text(producto.estado);
        });

        // Deshabilitar ambos botones
        iniciarBoton.prop("disabled", true);
        completarBoton.prop("disabled", true);
    }

    function actualizarEstadoVisual(elementoEstado, estado) {
        elementoEstado
            .removeClass("bg-lightred bg-lightyellow bg-lightgreen") // Quita todas las clases posibles
            .addClass(
                estado === "PENDIENTE"
                    ? "bg-lightred"
                    : estado === "EN PREPARACION"
                    ? "bg-lightyellow"
                    : estado === "COMPLETADO"
                    ? "bg-lightgreen"
                    : ""
            ); // Agrega la clase correspondiente según el estado
        elementoEstado.text(estado); // Actualiza el texto del estado
    }

    // funcion para renderizar la vista de un pedido ya que es muy grande para mostrarlo solo con scrpting
    function renderizarPedido(pedido) {
        return `
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Pedido - <span id="codigo-pedido-cheff">${pedido.codigo_pedido}</span></h5>
                            <small class="text-muted">Mesa ${pedido.numero_mesa} <big>|</big> ${pedido.fecha_hora || 'Sin hora'}</small>
                        </div>
                        <span class="badges bg-lightred">${pedido.estado}</span>
                    </div>

                    ${renderizarProductos(pedido.productos_detallados)}

                    <div class="card-footer text-muted d-flex align-items-center">
                        <i class="bi bi-clock me-2"></i> Tiempo transcurrido: ${pedido.fecha_hora ? '5 min' : 'N/A'}
                    </div>
                </div>
            </div>
        `;
    }

    // funcion para renderizar la vista de los proudctos relacionados con el pedidos
     function renderizarProductos(productos) {
         return productos
             .map(
                 (producto) => `
            <div class="m-3 p-3 border border-secondary rounded" style="border-color: #ccc !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">${producto.cantidad}x ${
                     producto.nombre_producto
                 }</h6>
                    <span class="badge bg-warning text-light">PENDIENTE</span>
                </div>
                <p class="mb-2">
                    <small class="text-muted">Notas: ${
                        producto.notas_producto || "Sin notas"
                    }</small>
                </p>
                <button class="btn btn-dark btn-sm me-2" data-role="iniciar">Iniciar</button>
                <button class="btn bg-transparent btn-sm" data-role="completar" disabled>Completar</button>
            </div>
        `
             )
             .join("");
     }
});