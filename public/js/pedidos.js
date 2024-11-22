
$(document).ready(function() {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    // creamos un arreglo para guardar la data de los items del pedido
    let pedidoProductos = [];
    // creamos la variable total para guardar el total
    let total = null;

    // Creamos datatable y la inicializamos
    let dataTablePedidos = $("#data-pedidos").DataTable({
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
            url: baseUrl + "pedidos/consultarPedidos",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            { data: "numeroMesa" },
            { data: "mesero" },
            { data: "codigoPedido" },
            { data: "total" },
            { data: "estado" },
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
    // funcion para filtrar los pedidoProductos por las categorias
    $("#categoriaPedido").on("change", function (e) {
        // almacenamos el valor del select cuando ejecute el evento en una variable
        const categoriaPedido = e.target.value;
        console.log(categoriaPedido);

        // creamos la peticion
        $.post(
            `${baseUrl}pedidos/getProductsByCategory`,
            { categoria: categoriaPedido },
            function (response) {
                // convertimos la data devuelta por el servidor en un JSON
                let pedidoProductos = JSON.parse(response);

                // creamos un template para concatenar y iterar sobre los valores
                let template = "";

                // validamos primero si el arreglo tiene data
                if (pedidoProductos.data.length === 0) {
                    template += `
                        <option value="">No existen categorías asociadas</option>
                    `;
                    $("#producto").html(template);
                    return;
                }

                template += "<option value=''>Seleccione Producto</option>";
                pedidoProductos.data.forEach((producto) => {
                    template += `
                <option value="${producto.id_pinventario}" data-precio="${producto.precio}">
                    ${producto.nombre_producto} - $${producto.precio}
                </option>
            `;
                });

                // actualizamos el contenido de #producto
                $("#producto").html(template);
            }
        );
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

    // funcion para agregar los items y mostrarlos en el fronted
    $("#agregar-pedido-btn").on("click", function (e) {
        // cancelamos el evento por default ya que lo estamos enviando desde un formulario
        e.preventDefault();
        // guardamos la data que viene de los input
        console.log("working.....");
        const idProducto = $("#producto option:selected").val();
        console.log(idProducto);
        const productoNombre = $("#producto option:selected").text();
        const cantidad = parseInt($("#cantidadItems").val()) || 1;
        const notas = $("#notasItems").val() || "Sin notas";
        const precio = parseFloat(
            $("#producto option:selected").attr("data-precio")
        );

        //validamos que la categoria aya sido seleccionada

        // validamos la data
        if (productoNombre === " " || cantidad <= 0) {
            alert(
                "Selecciona un producto válido y asegúrate de que la cantidad sea mayor a 0."
            );
            return;
        }

        const subtotal = (precio * cantidad).toFixed(2);
        total += parseFloat(subtotal);

        pedidoProductos.push({
            idProducto: parseInt(idProducto),
            nombre: productoNombre,
            cantidad: cantidad,
            precio: precio,
            notas: notas,
            subtotal: subtotal,
        });

        console.log(pedidoProductos);

        // Agregar producto al listado de items
        $("#listaProductos").append(`
            <div class="item-pedido d-flex justify-content-between align-items-center mb-3 p-3 border border-secondary rounded" data-id="${idProducto}" data-subtotal="${subtotal}" style="border-color: #ccc !important;">
                <div class="px-2">
                    <strong>${productoNombre}</strong><br>
                    <span>Cantidad: ${cantidad} x $${precio.toFixed(2)} = $${subtotal}</span><br>
                    <span>Notas: ${notas}</span>
                </div>
                <button id="eliminar-producto" class="btn btn-danger">Eliminar</button>
            </div>
        `);


        // Actualizamos el total de pedido
        $("#totalPedido").text(`$${total.toFixed(2)}`);

        // Limpiamos los campos
        $("#producto").val("#");
        $("#categoriaPedido").val("#");
        $("#cantidadItems").val("");
        $("#notasItems").val("");
    });

    // Creamos un evento para eliminar un producto del pedido
    $(document).on("click", "#eliminar-producto", function (e) {
        e.preventDefault();

        // Obtener el contenedor del producto
        const productoElemento = $(this).closest(".item-pedido");

        // Obtener el ID único del producto desde un atributo data
        const productoID = parseInt(productoElemento.data("id")); 
        console.log(productoID);
        // Eliminamos el elemento del array con filter, si el id del elemento de array es diferente del 
        pedidoProductos = pedidoProductos.filter(
            (producto) => producto.idProducto !== productoID
        );

        // Obtener el subtotal del producto eliminado
        const subtotalEliminado =
            parseFloat(productoElemento.data("subtotal")) || 0;

        // Restar el subtotal del producto eliminado del total general
        let totalActual =
            parseFloat($("#totalPedido").text().replace("$", "")) || 0;
        totalActual -= subtotalEliminado;

        // Actualizar el total en la interfaz
        if (totalActual < 0 || $(".item-pedido").length === 1) {
            totalActual = 0; // Si no quedan pedidoProductos, dejar el total en $0.00
        }
        $("#totalPedido").text(`$${totalActual.toFixed(2)}`);
        console.log(pedidoProductos);
        // Eliminar el producto de la lista
        productoElemento.remove();
        
    });


    // Creamos la funcion para enviar el pedido con los datos completos
    $("#enviar-pedido-btn").on('click', function(e) {
        // quitamos el efecto por default
        e.preventDefault();
        console.log('its working bitch');
        // Obtener los datos generales del pedido
        const codigoPedido = $("#codigo-pedido").text();
        const fechaHora = $("#fecha-hora").text();
        const numeroMesa = $("#numeroMesa").val();
        const idMesero = $("#idMesero").data("id");
        const numeroPersonas = $("#numeroPersonas").val();
        const notasPedido = $("#notasPedido").val();
        const total = parseFloat($("#totalPedido").text().replace("$", ""));

        console.log(total);
        // creamos un JSON con toda la data del pedido
        const pedidoCompleto = { 
            codigoPedido: codigoPedido,
            fechaHora: fechaHora, 
            numeroMesa: numeroMesa,
            idMesero: idMesero,
            numeroPersonas: numeroPersonas, 
            notasPedido: notasPedido, 
            total: total, 
            pedidoProductos: pedidoProductos
        }

        console.log(pedidoCompleto.idMesero);

        // validamos la data antes de ser enviada
        // Validar antes de enviar
        if (!pedidoCompleto.numeroMesa || !pedidoCompleto.numeroPersonas || pedidoCompleto.pedidoProductos.length === 0) {
            alert('Por favor completa todos los campos y agrega al menos un producto.');
            return;
        }

        // Creamos una petición para procesarla y enviarla al servidor
        $.ajax({
            url: baseUrl + "pedidos/crearPedido",
            method: "POST",
            data: { pedido: JSON.stringify(pedidoCompleto) },
            success: function (response) {
                // mostramos la alerta cuando la respuesta del servidor se devuelve correctamente
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
                            $("#generarPedidoModal")
                                .closest(".modal")
                                .modal("hide");
                            $("#generarPedidoModal")[0].reset();
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
                            $("#generarPedidoModal")
                                .closest(".modal")
                                .modal("hide");
                            $("#generarPedidoModal")[0].reset();
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
                    // No cerramos el modal en caso de un error
                    if (result.isConfirmed) {
                        // mantener el modal abierto para que el usuario intente de nuevo
                    }
                });
            },
        });
    });
    
});
