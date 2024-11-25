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
                <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                <button class="btn bg-transparent btn-sm" disabled>Completar</button>
            </div>
        `
             )
             .join("");
     }
});