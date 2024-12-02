// Importa la función desde mesas.js
import { cargarMesasPorEstado } from "./mesas.js";

$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr("content");
    // utilizamos una bandera para indicar cuando esta en modo edicion y cuando no
    let editar = false; 
    // creamos un arreglo para guardar la data de los items del pedido
    let pedidoProductos = [];
    let pedidoCompleto = {};
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
            url: baseUrl + "pedidos/cargarDatosPedidos",
            type: "GET",
            dataType: "json",
        },
        columns: [
            { data: "checkmarks" },
            { data: "numero_mesa" },
            { data: "nombre_mesero" },
            {
                data: "codigo_pedido",
                render: function (data) {
                    if (data) {
                        return `<a href="#" 
                                class="visualizar-pedido-btn text-dark text-decoration-underline hover:text-body" 
                                data-pedido="${data}">
                                ${data}
                            </a>`;
                    }
                    return "<strong>SIN PEDIDO ASOCIADO</strong>";
                },
            },
            { data: "total" },
            {
                data: "estado",
                render: function (data) {
                    // Cambia el estilo según el valor de "estado"
                    let badgeClass;
                    switch (data) {
                        case "PENDIENTE":
                            badgeClass = "bg-lightred";
                            break;
                        case "COMPLETADO":
                            badgeClass = "bg-lightgreen";
                            break;
                        default:
                            badgeClass = "bg-lighgray";
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
            dataSrc: function (json) {
                let mesasFiltradas = [];
                let numerosMesasUnicos = new Set(); // Usar Set para evitar duplicados de numeroMesa

                json.data.forEach(function (mesa) {
                    // Validar si el numeroMesa ya fue agregado al Set
                    if (numerosMesasUnicos.has(mesa.numeroMesa)) {
                        console.warn(
                            `Mesa duplicada ignorada: ${mesa.numeroMesa}`
                        );
                    } else {
                        // Agregar numeroMesa al Set para evitar duplicados
                        numerosMesasUnicos.add(mesa.numeroMesa);
                        // Agregar la mesa al array filtrado
                        mesasFiltradas.push(mesa);
                    }
                });

                // Devolver solo mesas únicas al DataTable
                return mesasFiltradas;
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
                data: "personas",
                // renderizamos una funcion que nos permita mostrar los comensale que hay en la mesa y ademas que valide si hay comensales
                // le agregamos un svg de un usuario para mejor estetica
                render: function (data) {
                    const personas = parseInt(data) || 0;
                    return `
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <span class="font-medium">${personas}</span>
                        </div>
                    `;
                },
            },
            {
                data: "codigoPedido",
                render: function (data) {
                    if (data) {
                        return `<a href="javascript:void(0)" 
                      onclick="verPedido('${data}')" 
                     class="text-dark text-decoration-underline hover:text-body">
                      ${data}
                   </a>`;
                    }
                    return "<strong>SIN PEDIDO ASOCIADO</strong>";
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
        // cancelamos el evento por default ya que lo estamos enviando desde un formulario
        e.preventDefault();
        // Muestra el contenedor de item oculto para el estado del producto
        $(".estado-producto-container").removeClass("d-block").addClass("d-none");
        $("#actualizar-pedido-btn").attr("id", "agregar-pedido-btn").html("Agregar Producto");
        // Limpia los campos y el listado de productos
        limpiarCamposPedido();

        console.log("Modo 'Crear' activado, campos y variables limpiados.");
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
                    $("#capacidad").html(mesa.capacidad);
                    $("#comensales").html(mesa.personas);

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

    // Luego, fuera de la configuración del DataTable, usa delegación de eventos
    $(document).on(
        "click",
        ".visualizar-pedido-btn, .visualizar-pedido-eye",
        function (e) {
            e.preventDefault();
            const codigoPedido = $(this).data("pedido");
            let totalPedido = 0;

            $.ajax({
                url: baseUrl + "pedidos/consultarPedido",
                type: "POST",
                dataType: "json",
                data: { codigoPedido: codigoPedido },
                success: function (response) {
                    if (response.status) {
                        if (response.data) {
                            let pedidosData = response.data;
                            // seteamos la data en los campos
                            $("#codigo-pedido-detalle").text(
                                pedidosData.codigo_pedido
                            );
                            $("#nombre-mesero-detalle").text(
                                pedidosData.nombre_mesero
                            );
                            $("#numero-mesa-detalle").text(
                                pedidosData.numero_mesa
                            );
                            $("#personas-detalle").text(
                                `${pedidosData.personas} Comensales`
                            );

                            // validamos el estado del pedido para ponerlo en el estado
                            if (pedidosData.estado === "PENDIENTE") {
                                $("#estado-pedido-detalle").text(
                                    pedidosData.estado
                                );
                                $("#estado-pedido-detalle").addClass(
                                    "badges bg-lightred"
                                );
                            } else if (
                                pedidosData.estado === "EN PREPARACION"
                            ) {
                                $("#estado-pedido-detalle").text(
                                    pedidosData.estado
                                );
                                $("#estado-pedido-detalle").addClass(
                                    "badges bg-lightyellow"
                                );
                            } else {
                                $("#estado-pedido-detalle").text(
                                    pedidosData.estado
                                );
                                $("#estado-pedido-detalle").addClass(
                                    "badges bg-lightgreen"
                                );
                            }

                            // Generar filas de productos usando productos_detallados
                            let tableHTML;
                            // Variable para almacenar la clase según el estado del producto
                            let estadoClass = "";
                            console.log(pedidosData.productos_detallados);
                            // iteramos la data para mostrar los datos de los productos en la tabla
                            pedidosData.productos_detallados.forEach(
                                (producto) => {
                                    const cantidad = parseFloat(
                                        producto.cantidad
                                    );
                                    const precio = parseFloat(producto.precio);
                                    const subtotal = cantidad * precio;
                                    totalPedido += subtotal;

                                    // Comprobación del estado del producto y asignación de la clase correspondiente
                                    if (
                                        producto.estados_productos ===
                                        "PENDIENTE"
                                    ) {
                                        estadoClass = "badges bg-lightred"; // Clase para 'PENDIENTE'
                                    } else if (
                                        producto.estados_productos ===
                                        "EN PREPARACION"
                                    ) {
                                        estadoClass = "badges bg-lightyellow"; // Clase para 'EN PREPARACION'
                                    } else {
                                        estadoClass = "badges bg-lightgreen";
                                    }

                                    tableHTML += `
                                    <tr>
                                        <td>${producto.nombre_producto}</td>
                                        <td>${cantidad}</td>
                                        <td>$${precio.toFixed(2)}</td>
                                        <td>$${subtotal.toFixed(2)}</td>
                                    <td><span class="${estadoClass}">${
                                        producto.estados_productos
                                    }</span>
                                        
                                    </td>
                                    </tr>
                        `;
                                }
                            );
                            $("#notas-pedido-detalle").text(
                                pedidosData.notas_general_pedido
                            );
                            $("#total-pedido-detalle").text(`$${totalPedido}`);

                            // Insertar la tabla en el DOM
                            $("#detalles-pedidos-table tbody").html(tableHTML);
                        } else {
                            console.log(
                                "response.data está vacío o es undefined"
                            );
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
                    $("#modalFormCreateProduct").modal("show");
                },
            });

            console.log("Visualizando pedido:", codigoPedido);
            $("#visualizarDetallesPedidosModal").modal("show");
        }
    );

    // funcion para agregar los items y mostrarlos en el fronted
    $("#agregar-pedido-btn").on("click", function (e) {
        e.preventDefault();

        // guardamos la data que viene de los input
        console.log("working.....");
        const idProducto = $("#producto option:selected").val();
        console.log(idProducto);
        const idCategoria = $("#categoriaPedido option:selected").val();
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
            id_producto: parseInt(idProducto),
            id_categoria: parseInt(idCategoria),
            nombre_producto: productoNombre,
            cantidad: cantidad,
            precio: precio,
            notas_producto: notas,
            subtotal: subtotal,
        });

        console.log(pedidoProductos);

        // Agregar producto al listado de items
        $("#listaProductos").append(`
            <div class="item-pedido d-flex justify-content-between align-items-center mb-3 p-3 border border-secondary rounded" data-id="${idProducto}" data-subtotal="${subtotal}" style="border-color: #ccc !important;">
                <div class="px-2">
                    <strong>${productoNombre}</strong><br>
                    <span>Cantidad: ${cantidad} x $${precio.toFixed(
            2
        )} = $${subtotal}</span><br>
                    <span>Notas: ${notas}</span>
                </div>
                <div>
                    <button id="actualizar-producto" class="btn" style="background: #28c76f; color: #fff;">Actualizar</button>
                    <button id="eliminar-producto" class="btn btn-danger">Eliminar</button>
                </div>
                
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
    $("#enviar-pedido-btn").on("click", function (e) {
        // quitamos el efecto por default
        e.preventDefault();

        // validamos si esta en modo edicion para cambiar el codigo del pedido
        let editar = $(".modal-header").hasClass('headerUpdate') ? true : false;
        if(editar) { 
            console.log("Esta en modo edicion asi que puedes cambiar ciertas cosas bro");
            let codigoPedido = $("#codigo-pedido").text();
            console.log(pedidoCompleto);
        }else {
            // Obtener los datos generales del pedido
            const codigoPedido = $("#codigo-pedido").text();
            const fechaHora = $("#fecha-hora").text();
            const numeroMesa = $("#numeroMesa").val();
            const estadoMesa = $("#numeroMesa option:selected").data("estado");
            const idMesero = $("#idMesero").data("id");
            const numeroPersonas = $("#numeroPersonas").val();
            const notasPedido = $("#notasPedido").val();
            total = parseFloat($("#totalPedido").text().replace("$", ""));

            console.log(
                "NOOOOOOOOOOO Esta en modo edicion asi que puedes cambiar ciertas cosas bro"
            );
            // creamos un JSON con toda la data del pedido
            pedidoCompleto = {
                codigoPedido: codigoPedido,
                fechaHora: fechaHora,
                numeroMesa: numeroMesa,
                estadoMesa: estadoMesa,
                idMesero: idMesero,
                numeroPersonas: numeroPersonas,
                notasPedido: notasPedido,
                total: total,
                pedidoProductos: pedidoProductos,
            };
            console.log(pedidoCompleto);

            // validamos la data antes de ser enviada
            // Validar antes de enviar
            if (
                !pedidoCompleto.numeroMesa ||
                !pedidoCompleto.numeroPersonas ||
                pedidoCompleto.pedidoProductos.length === 0
            ) {
                alert(
                    "Por favor completa todos los campos y agrega al menos un producto."
                );
                return;
            }
        }
        
        

        // Creamos una petición para procesarla y enviarla al servidor
        $.ajax({
            url: editar ? baseUrl + "pedidos/actualizarPedido"  : baseUrl + "pedidos/crearPedido",
            method: "POST",
            data: { pedido: JSON.stringify(pedidoCompleto)},
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
                            dataTablePedidos.ajax.reload(null, false);
                            dataTableMesasPedidos.ajax.reload(null, false);
                            $("#generarPedidoModal").closest(".modal").modal("hide");
                            // llamamos la funcion para limpiar los datos
                            limpiarCamposPedido();
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

    // Creamos la funcion para eliminar un pedido
    $("#data-pedidos").on("click", ".botonEliminar", function (e) {
        // quitamos el evento por defecto de los formularios
        e.preventDefault();
        const eliminarPedidoBtn = $(this);
        const idPedido = eliminarPedidoBtn.data("id");
        const idMesa = eliminarPedidoBtn.data("idmesa");
        console.log(idMesa);

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
                // desabilitamos el boton despues de un click para que el usuario no le de click varias veces
                eliminarPedidoBtn.prop("disabled", true);
                $.ajax({
                    url: baseUrl + "pedidos/borrarPedido",
                    type: "POST",
                    dataType: "json",
                    data: { idPedido: idPedido, idMesa: idMesa },
                    success: function (response) {
                        console.log(response);
                        let data = response;
                        if (data.status) {
                            Swal.fire({
                                title: "Éxito",
                                text: data.message,
                                icon: "success",
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    dataTablePedidos.ajax.reload(null, false);
                                    dataTableMesasPedidos.ajax.reload(
                                        null,
                                        false
                                    );
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error",
                                allowOutsideClick: false,
                                confirmButtonText: "Ok",
                            }).then(() => {
                                // habilitamos nuevamente el error si sucede un error
                                eliminarPedidoBtn.prop("disabled", true);
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
                        }).then(() => {
                            // habilitamos nuevamente el error si sucede un error
                            eliminarPedidoBtn.prop("disabled", true);
                        });
                    },
                });
            }
        });
    });

    // esta funcion nos permitira actualizar un producto
    // Escuchar el evento de clic en el botón "Actualizar"
    $(document).on("click", "#actualizar-producto", function (e) {
        e.preventDefault();

        console.log("its click on #actualizar-producto");

        $(".title-products").html("Actualizar Productos");
        $("#agregar-pedido-btn")
            .off("click")
            .attr("id", "actualizar-pedido-btn")
            .html("Actualizar Producto")
            .attr("data-id", $(this).closest(".item-pedido").attr("data-id")); // Asignamos el data-id al botón

        // Obtenemos el elemento padre (el producto en el DOM)
        const itemPedido = $(this).closest(".item-pedido");
        console.log(itemPedido);

        // Extraemos el ID del producto y la categoría
        const idProducto = parseInt(itemPedido.attr("data-id"));
        console.log(idProducto);
        console.log(pedidoProductos);
        const producto = pedidoProductos.find(
            (p) => p.id_producto == idProducto
        );

        if (producto) {
            // Llenamos los campos del formulario con los datos del producto
            $("#categoriaPedido").val(producto.id_categoria).trigger("change");

            // Esperamos que las opciones del select de productos se carguen
            setTimeout(() => {
                $("#producto").val(producto.id_producto).trigger("change");
            }, 500); // Ajusta este tiempo si es necesario

            // Llenamos los otros campos
            $("#cantidadItems").val(producto.cantidad);
            $("#notasItems").val(producto.notas_producto);
            $("#estadoProducto").val(producto.estados_productos);
        } else {
            alert("No se encontró el producto seleccionado en el pedido.");
        }
    });

    // utilizamos esta esta funcion para actualizar un producto y mostrarlo en el DOM actualizado
    $(document).on("click", "#actualizar-pedido-btn", function (e) {
        e.preventDefault();

        const idProducto = parseInt($(this).attr("data-id"));
        const index = pedidoProductos.findIndex(
            (p) => p.id_producto === idProducto
        );
        if (index === -1) {
            alert("Error: No se encontró el producto para actualizar.");
            return;
        }

        const cantidad = parseInt($("#cantidadItems").val()) || 1;
        const notas = $("#notasItems").val() || "Sin notas";

        const idCategoriaSelect = $("#categoriaPedido option:selected").val();

        const idProductoSelect = parseInt($("#producto option:selected").val());
       
        const productoNombre = $("#producto option:selected").text();

        const precioProducto = parseFloat(
            $("#producto option:selected").attr("data-precio")
        ); // Extraer el nuevo precio del producto seleccionado

        // Actualizar los datos del producto en el array
        pedidoProductos[index].cantidad = cantidad;
        pedidoProductos[index].id_categoria = idCategoriaSelect;
        pedidoProductos[index].id_producto = idProductoSelect;
        pedidoProductos[index].notas_producto = notas;
        pedidoProductos[index].nombre = productoNombre;
        pedidoProductos[index].precio = precioProducto; // Actualizar el precio en el array
        pedidoProductos[index].subtotal = (precioProducto * cantidad).toFixed(
            2
        );

        // Actualizar el producto en el DOM
        const productoElemento = $(`.item-pedido[data-id="${idProducto}"]`);

        if (!productoElemento.length) {
            alert("Error: No se encontró el producto en el DOM.");
            return;
        }

        // Actualizar el nombre del producto
        productoElemento.find("strong").text(productoNombre);

        // Actualizar la cantidad, precio y subtotal
        productoElemento
            .find("span:first")
            .text(
                `Cantidad: ${cantidad} x $${precioProducto.toFixed(2)} = $${
                    pedidoProductos[index].subtotal
                }`
            );

        // Actualizar las notas
        productoElemento.find("span:last").text(`Notas: ${notas}`);
        // Recalcular el total
        const total = pedidoProductos.reduce(
            (sum, prod) => sum + parseFloat(prod.subtotal),
            0
        );

        // Actualizar el data-id en el DOM con el nuevo idProducto
        productoElemento.attr("data-id", idProductoSelect);

        console.log(pedidoProductos);
        $("#totalPedido").text(`$${total.toFixed(2)}`);

        // Cambiar el botón de vuelta a "Agregar Producto"
        $("#actualizar-pedido-btn")
            .off("click") // Con el off limpiamos el evento anterior para que no hayan bugs raros
            .attr("id", "agregar-pedido-btn")
            .html("Agregar Producto")
            .attr("data-id", $(this).closest(".item-pedido").attr("data-id"));

        // Limpiar el formulario
        $("#producto").val("#");
        $("#categoriaPedido").val("#");
        $("#cantidadItems").val("");
        $("#notasItems").val("");
    });

    // creamos esta funcion para actualizar toda la data de un pedido
    $("#data-pedidos").on("click", ".botonActualizar", function (e) {
        // cambiamos el estado de editar ya que estamos en modo edicion
        editar = true;

        $("#agregar-pedido-btn")
            .off("click")
            .attr("id", "actualizar-pedido-btn")
            .html("Actualizar Producto");

        // obtenemos el codigo del pedido
        let codigoPedido = $(this).data("codigopedido");

        // actualizamos los campos del modal para actualizar el pedido
        $("#titleModal").html("Actualizar Pedido");
        // Muestra el contenedor de item oculto para el estado del producto
        $(".estado-producto-container")
            .removeClass("d-none")
            .addClass("d-block");
        $(".title-products").text("Actualizar Productos");
        $(".modal-header")
            .removeClass("headerRegister")
            .addClass("headerUpdate");
        $("#btnText").text("Actualizar");

        // creamos la peticion para enviar el codigo del producto y asi setearlos en los campos del pedido para actualizarlos
        $.ajax({
            url: baseUrl + "pedidos/consultarPedido",
            type: "POST",
            dataType: "json",
            data: { codigoPedido: codigoPedido },
            success: function (response) {
                if (response.status) {
                    // Verifica que response.data no sea undefined o null
                    if (response.data) {
                        // Asumiendo que necesitas el primer elemento del array data
                        let pedidoData = response.data;
                        console.log(pedidoData);
                        console.log(pedidoData.id_mesa);
                        console.log(pedidoData.numero_mesa);

                        // seteamos la data en los campos
                        $("#codigo-pedido").text(pedidoData.codigo_pedido);
                        $("#fecha-hora").text(pedidoData.fecha_hora);

                        // validamos que este en modo edicion para evitar problemas con el formulario de crear
                        if (editar) {
                            console.log(editar);
                            // cargamos la mesa del pedido al select ya que solo nos trae las mesas disponible por eso dividmos la funcion por aparte en mesas
                            cargarMesasPorEstado(
                                "DISPONIBLE",
                                pedidoData,
                                editar
                            );
                        }

                        $("#numeroPersonas").val(pedidoData.personas);
                        let template = "";
                        let subtotal;
                        total = 0;
                        

                        // Define un objeto con los mapeos de estados a clases CSS
                        const estadoClases = {
                            pendiente: "badges bg-lightred",
                            "en preparacion": "badges bg-lightyellow",
                            completado: "badges bg-ligthgreen",
                            // Agrega más estados y clases según sea necesario
                        };

                        // itereamos sobre el array productos_detallados para mostrar los productos del pedido
                        pedidoData.productos_detallados.forEach((producto) => {
                            // Obtén la clase correspondiente al estado o usa una clase por defecto
                            subtotal = 0;
                            const claseEstado =
                                estadoClases[
                                    producto.estados_productos.toLowerCase()
                                ] || "badges bg-ligthgreey";
                            subtotal = (
                                producto.precio * producto.cantidad
                            ).toFixed(2);
                            console.log(subtotal);
                            template += `
                                <div class="item-pedido d-flex justify-content-between align-items-center mb-3 p-3 border border-secondary rounded" data-id="${
                                    producto.id_producto
                                }" data-subtotal="${subtotal}" style="border-color: #ccc !important;">
                                    <div class="px-2">
                                        <strong>${
                                            producto.nombre_producto
                                        }   - <span class="${claseEstado}">${
                                producto.estados_productos
                            }</span></strong><br>
                                        <span>Cantidad: ${
                                            producto.cantidad
                                        } x $${parseFloat(
                                producto.precio
                            ).toFixed(2)} = $${subtotal}</span><br>
                                        <span>Notas: ${
                                            producto.notas_producto
                                        }</span>
                                    </div>
                                    <div>
                                        <button id="actualizar-producto" class="btn" style="background: #28c76f; color: #fff;">Actualizar</button>
                                        <button id="eliminar-producto" class="btn btn-danger">Eliminar</button>
                                    </div>
                                
                                </div>
                            `;
                            
                            total += parseFloat(subtotal);
                            
                        });

                        // Rellena pedidoCompleto con los valores iniciales
                        pedidoCompleto = {
                            idPedido: pedidoData.id_pedido,
                            codigoPedido: pedidoData.codigo_pedido,
                            fechaHora: pedidoData.fecha_hora,
                            numeroMesaAntigua: null, // Lo inicializamos como null
                            numeroMesa: null,
                            idMesero: $("#idMesero").data("id"),
                            numeroPersonas: pedidoData.personas,
                            notasPedido: pedidoData.notas_general_pedido,
                            total: total,
                            pedidoProductos:
                                pedidoData.productos_detallados.map(
                                    (producto) => ({
                                        ...producto,
                                        id_categoria: producto.id_categoria,
                                    })
                                ),
                        };

                        // Esperar que las mesas se carguen para asignar numeroMesaAntigua
                        setTimeout(() => {
                            pedidoCompleto.numeroMesaAntigua = $("#numeroMesa option:selected").val();
                            console.log("Mesa Antigua asignada: ", pedidoCompleto.numeroMesaAntigua);
                        }, 500);

                        // Escuchar cambios en el select de mesa y actualizar numeroMesa
                        $("#numeroMesa").on("change", function () {
                            pedidoCompleto.numeroMesa = $(this).val();
                            console.log("Nueva Mesa asignada: ", pedidoCompleto.numeroMesa);
                        });

                        console.log(pedidoCompleto);

                        // Actualizamos el total de pedido
                        $("#totalPedido").text(`$${total.toFixed(2)}`);
                        console.log(pedidoData.notas_general_pedido);
                        $("#notasPedido").text(pedidoData.notas_general_pedido);

                        $("#listaProductos").html(template);
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
                // mostramos el modal
                $("#generarPedidoModal").modal("show");
            },
        });
    });

   function limpiarCamposPedido() {
       console.log("Limpiando lista de productos y campos...");

       // Limpia el listado de productos en el DOM
       $("#listaProductos").empty();

       // Reinicia las variables globales
       pedidoProductos = [];
       total = 0;


       // Resetea los campos del formulario
       $("#numeroPersonas").val(0);
       $("#notasPedido").val("");
       $("#totalPedido").text("$0.00");
       $("#producto").val("#");
       $("#categoriaPedido").val("#");
       $("#cantidadItems").val("");
       $("#notasItems").val("");
   }

});
