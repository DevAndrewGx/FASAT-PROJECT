document.addEventListener('DOMContentLoaded', () => {
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let dataTable = $("#data-empleados").DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "processing": "Procesando..."
        },
        "ajax": {
            "url": baseUrl + "users/getUsers",
            "type": "GET",
            "dataType": "json",
        },
        "columns": [
            {"data":"checkmarks"},
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<img src="' + row.foto + '" alt="Foto" style="width:30px; height:30px; border-radius:50%;"> ' + row.nombres;
                }
            },
            {"data":"apellidos"},
            {"data":"documento"},
            {"data":"telefono"},
            {"data":"correo"},
            {"data":"estado"},
            {"data":"rol"},
            {"data":"fecha_de_creacion"},
            {"data":"acciones"}
        ],
        "columnDefs": [{
            "targets": [0, 9],
            "orderable": false
        }],
    });
});
