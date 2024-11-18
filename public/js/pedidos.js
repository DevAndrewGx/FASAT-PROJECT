
$(document).ready(function() {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    let globalIdMesa;

    // Creamos datatable y la inicializamos
    let dataTableMesasPedidos = $("#data-mesas-pedidos").DataTable({
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
                data: "codigoPedido", // Cambia 'pedidoAsociado' por 'codigo_pedido'
                render: function (data) {
                    return data ? data : "<strong>SIN PEDIDO ASOCIADO</strong>";
                },
            },
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
        order: [[3, "asc"]], // Ordenar por la columna nombre_categoria (segunda columna, índice 1)
        columnDefs: [
            {
                targets: [0, 3],
                orderable: false,
            },
        ],
    });

    // Evento de clic en la fila de la tabla
    $("#data-mesas-pedidos tbody").on("click", "tr", function () {
        console.log("Clic en la fila");

        // Obtén los datos de la fila seleccionada
        const rowData = dataTableMesasPedidos.row(this).data();

        // Verificamos que exista el id_mesa y llamamos a la función abrirModalMesa
        if (rowData && rowData.id_mesa) {
            abrirModalMesa(rowData.id_mesa);
        } else {
            console.error(
                "No se encontró el id_mesa en los datos de la fila seleccionada."
            );
        }
    });

    // Evento de clic en el botón con el ícono
    $("#data-mesas-pedidos tbody").on(
        "click",
        ".botonVisualizar",
        function (e) {
            e.stopPropagation(); // Evita que el clic se propague a la fila
            console.log("Clic en el ícono");

            // Obtén el id_mesa desde el atributo data-id del enlace
            const id_mesa = $(this).data("id");

            if (id_mesa) {
                abrirModalMesa(id_mesa);
            } else {
                console.error("No se encontró el id_mesa en el enlace.");
            }
        }
    );

    $("#btnCrearPedido").on("click", function (e) {
    
        $.ajax({  
            url: baseUrl + "pedidos/crearCodigoPedido", // Ruta para generar el código del pedido
            method: "GET", // Usamos GET para solo obtener el código
            success: function (response) {
                let data = JSON.parse(response);
                console.log(data.codigo);
                if (data.codigo) {
                    
                    // Asignar el código generado en el modal
                    $("#codigo-pedido").text(data.codigo); 
                    $("#fecha-hora").text(data.fecha); 
            
                } else {
                    alert("Error al generar el código del pedido.");
                }
            },
            error: function () {
                alert("Error al comunicarse con el servidor.");
            },
        });
    });
    // funcion para filtrar los productos por las categorias
    $("#categoriaPedido").on("change", function(e) { 
        // almacenamos el valor del select cuando ejecute el evento en una variable
        const categoriaPedido = e.target.value;
        console.log(categoriaPedido);
    
        // creamos la peticion
        $.post(`${baseUrl}pedidos/getProductsByCategory`, {categoria: categoriaPedido}, function(response) { 
            // convertimos la data devuelta por el servidor en un JSON
            let productos = JSON.parse(response);

            // creamos un template para concatenar y iterar sobre los valores
            let template = "";
            
            // validamos primero si el arreglo tiene data 
            if (productos.data.length === 0) { 
                template += `
                        <option value="">No existen categorías asociadas</option>
                    `;
                $("#producto").html(template);
                return;
            }

            template += "<option value=''>Seleccione Producto</option>";
            productos.data.forEach((producto) => {
                template += `
                            <option value="${producto.nombre_producto}">${producto.nombre_producto} - $${producto.precio}</option>
                `;
            });
            
            // actualizamos el contenido de #producto
            $("#producto").html(template);
        });
    });


    // Función para abrir el modal y cargar los datos de la mesa
    function abrirModalMesa(id_mesa) {
        const formData = new FormData();
        formData.append("id_mesa", id_mesa);

        $.ajax({
            url: baseUrl + "mesas/consultarMesa",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status) {
                    console.log(data);
                    const mesa = data.data;

                    // Seteamos la data en los campos
                    $("#numeroPedidoMesa").html(mesa.numero_mesa);
                    console.log(mesa.numero_mesa);

                    if (mesa.codigo_pedido) {
                        $("#codigoPedido").html(mesa.codigo_pedido);
                    } else {
                        $("#codigoPedido").html(`
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>SIN PEDIDO ASOCIADO</strong>
                            <button id="agregarPedidoBtn" class="btn btn-primary btn-sm">Agregar Pedido</button>
                        </div>
                    `);
                    }
                    $("#estado").html(mesa.estado);

                    // Mostramos el modal
                    $("#detallesPedidoMesaModal").modal("show");

                    // Agregamos el evento de clic para el botón Agregar Pedido
                    $("#agregarPedidoBtn").on("click", function () {
                        // Ocultamos el modal actual
                        $("#detallesPedidoMesaModal").modal("hide");
                        // Mostramos el nuevo modal para generar el pedido
                        $("#generarPedidoModal").modal("show");

                        //seteamos el valor dinamico para cada vez que se consulte una mesa a travez del //registro del datatable
                        $("#estado-mesa").text(mesa.numero_mesa);
                    });
                }
            },
            error: function (response) {
                console.error("Error en la respuesta del servidor:", response);
            },
        });
    }
});
