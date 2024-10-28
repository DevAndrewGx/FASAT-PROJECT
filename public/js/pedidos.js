
$(document).ready(function() {
   const baseUrl = $('meta[name="base-url"]').attr("content");

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
           { data: "pedidoAsociado" },
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
});
