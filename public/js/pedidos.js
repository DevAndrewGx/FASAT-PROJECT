
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
//    creamos la funcion para abrir el modal cada vez que le de click en la fila
   $("#data-mesas-pedidos tbody").on("click", "tr", function () {
    
       console.log("its working");

       // Obtén los datos de la fila seleccionada
       const rowData = dataTableMesasPedidos.row(this).data();

       console.log(rowData);


       // Nos aseguramos de que el `id_mesa` exista en los datos de la fila 
       if (rowData && rowData.id_mesa) {
           const formData = new FormData();
           formData.append("id_mesa", rowData.id_mesa);

           // Realizamos la petición AJAX
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
                        // Accedemos a los datos en `data.data`
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

                        // Finalmente mostramos el modal
                        $("#detallesPedidoMesaModal").modal("show");
                    }


                },
               error: function (response) {
                   // Manejo de errores
                   console.error(
                       "Error en la respuesta del servidor:",
                       response
                   );
               },
           });
       } else {
           console.error(
               "No se encontró el id_mesa en los datos de la fila seleccionada."
           );
       }
   });

});
