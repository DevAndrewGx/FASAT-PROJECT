<?php
require_once('../../../models/seguridadAdmin.php');
require_once('../../../models/Consultas.php');

require_once('../../../models/Conexion.php');
require_once('../../../models/Sesion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/empleados/stylesEmpleado.css">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
    <!-- RESPONSIVE -->
    <!-- TESTING DATATABLES -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css" />
    <link rel="stylesheet" href="http://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css"/>
</head>

<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-wrapper">
        <header>
            <nav>
                <ul class="items-right">
                    <li class="nav-item">
                        <a href="#"><i class='bx bx-search'></i></a>
                    </li>

                    <li class="nav-item">
                        <a href="#"><i class='bx bx-bell'></i></a>
                    </li>

                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-img">
                                <img src="../../imgs/avatar-06.jpg" alt="admin" width="60px">
                                <span class="status1 online"></span></span>
                            </span>
                        </a>

                        <!-- DROPDOWN MENU -->

                        <div class="dropdown-menu menu-drop-user">
                            <div class="profilename">
                                <div class="profileset">
                                    <span class="user-img"><img src="../../imgs/avatar-06.jpg" alt="hello">
                                        <span class="status2 online"></span></span>
                                    <div class="profilesets">
                                        <h6>Juanita Dow</h6>
                                        <h5>Admin</h5>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <a class="dropdown-item" href="#"> <img src="../../imgs/icons/user.svg" alt="user">
                                    My
                                    Profile</a>
                                <a class="dropdown-item" href="#"><img src="../../imgs/icons/settings.svg" alt="settings">Settings</a>
                                <hr class="m-0">
                                <a class="dropdown-item logout pb-0" href="#"><img src="../../imgs/icons/log-out.svg" alt="logout">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <aside class="left-section">

            <div class="sidebar">

                <div class="logo">
                    <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
                    <a href="#"><img src="../../imgs/LOGOf.png" alt="logo"></a>
                </div>


                <div class="item">
                    <i class='bx bx-home-alt-2'></i>
                    <a href="adminDashboard.php">Dashboard</a>
                </div>
                <div class="item">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Ordenes</a>
                </div>
                <div class="item" id="active">
                    <i class='bx bxs-user-detail'></i>
                    <a href="gestionEmpleados.php">Empleados</a>
                </div>
                <div class="item">
                    <i class='bx bx-transfer-alt'></i>
                    <a href="gestionVentas.html">Ventas</a>
                </div>
                <div class="item">
                    <i class='bx bx-task'></i>
                    <a href="gestionInventario.html">Inventario</a>
                </div>
                <div class="item">
                    <i class='bx bx-cog'></i>
                    <a href="#">Settings</a>
                </div>
            </div>

            <div class="log-out sidebar">
                <div class="item">
                    <i class='bx bx-log-out'></i>
                    <a href="../../sing-up/login.html">Log-out</a>
                </div>

            </div>
        </aside>


        <!-- END OF SIDEBAR -->
        <!-- MAIN CONTENT -->
        <main class="page-wrapper" style="min-height: 995px">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Empleados</h1>
                        <p>Gestiona tus empleados</p>

                    </div>
                    <div class="page-btn">
                        <a href="crearEmpleado.php" class="btn btn-added"><img src="../../imgs/icons/plus.svg" alt="plussvg"> Agregar
                            Empleado</a>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="empleados" class="table datanew nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Documento</th>
                                        <th>Tipo Documento</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        <th>Rol</th>
                                        <th>Creado el</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aqui vamos insertar la data con jquery -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>




    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>


    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- JS BOOTSTRAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"> </script>

    <!-- Responsive dataTables -->
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>

    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/responsive/1.0.2/js/dataTables.responsive.js"></script>

    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="module" src="../../js/alertas.js"></script>

    <!-- TESTING BACKEND DATATABLE FEATURES -->
    <script type="module">
        // IMPORT OUR FUNCTIONS TO STAR WORKING WITH ALERTS 
        import {
            mostrarError,
            mostrarExito,
            mostrarConfirmacionBorrar
        } from '../../js/alertas.js';
        $(document).ready(function() {
            let dataTable = $('#empleados').DataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "../../../controllers/mostrarEmpleados.php",
                    "type": "POST",
                    "dataType": "json"
                },
                "columns": [{
                        "data": null,
                        "render": function(data, type, row) {
                            return `<label class="checkboxs">
                      <input type="checkbox">
                      <span class="checkmarks"></span>
                  </label>`;
                        }
                    },
                    {
                        "data": "foto",
                        "render": function(data, type, row) {
                            return `<a href="#" class="employee-img">
                      <img src="${data}" alt="employee">
                  </a>
                  <a href="#">${row.nombres}</a>`;
                        }
                    },
                    {
                        "data": "apellidos"
                    },
                    {
                        "data": "documento"
                    },
                    {
                        "data": "tipo_documento"
                    },
                    {
                        "data": "telefono"
                    },
                    {
                        "data": "correo"
                    },
                    {
                        "data": "estado"
                    },
                    {
                        "data": "rol"
                    },
                    {
                        "data": "fecha_de_creacion"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return `<a class="me-3 confirm-text" href="javascript:void(0);" data-id="${row.id_usuario}">
                                <img src="../../imgs/icons/eye.svg" alt="eye">
                            </a>
                            <a class="me-3 botonActualizar" data-id="${row.id_usuario}" href="editarEmpleado.php">
                                <img src="../../imgs/icons/edit.svg" alt="eye">
                            </a>
                    
                            <a class="me-3 confirm-text botonEliminar" data-id="${row.id_usuario}" href="editarEmpleado.php">
                                <img src="../../imgs/icons/trash.svg" alt="trash">
                            </a>`;
                        }
                    }
                ],
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": [0, 3, 4],
                    "orderable": true
                }],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "processing": "Procesando..."
                }
            });

            // Agregando un eventlistener para borrar data
            $('#empleados').on('click', '.botonEliminar', function(e) {
                e.preventDefault();

                const id_usuario = $(this).data('id');

                mostrarConfirmacionBorrar(id_usuario);
            });
            // Agregando un eventlistener para actualizar data
            $('#empleados').on('click', '.botonActualizar', function(e) {
                e.preventDefault();
                const id_usuario = $(this).data('id');
                window.location.href = `editarEmpleado.php?id_usuario=${id_usuario}`;
            });
        });
    </script>
</body>

</html>