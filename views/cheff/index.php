<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
</head>
<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-wrapper">
        <?php require_once('views/header.php') ?>
        <aside class="left-section">
            <div class="sidebar">
                <div class="logo">
                    <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
                    <a href="#"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>
                    <i class='bx bxs-chevron-left-circle'></i>
                </div>
                <div class="item" id="ordenes">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Órdenes</a>
                </div>
                <div class="item">
                    <i class='bx bx-cog'></i>
                    <a href="#">Ajustes</a>
                </div>
            </div>
            <div class="log-out sidebar">
                <div class="item">
                    <i class='bx bx-log-out'></i>
                    <a href="../../sing-up/login.html">Cerrar Sesión</a>
                </div>
            </div>
        </aside>
        <!-- MAIN CONTENT -->
        <main class="page-wrapper" style="min-height: 995px;">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Gestión de Pedidos - Chef</h1>
                        <nav class="nav-main">
                            <a href="homeChef.php">Chef</a>
                            <a href="chefPedidos.php" id="actual"> / Gestión de Pedidos </a>
                        </nav>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Órdenes de Platos en Proceso</h5>
                        <div class="table-responsive">
                            <table id="ordersTable" class="table table-responsive datanew">
                                <thead>
                                    <tr>
                                        <th>Mesa</th>
                                        <th>Plato</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5</td>
                                        <td>Pizza Margarita</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Pizza Margarita</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Pizza Margarita</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Pizza Margarita</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Órdenes de Bebidas en Proceso</h5>
                        <div class="table-responsive">
                            <table id="beveragesTable" class="table table-responsive datanew">
                                <thead>
                                    <tr>
                                        <th>Mesa</th>
                                        <th>Bebida</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5</td>
                                        <td>Coca-Cola</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Coca-Cola</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Coca-Cola</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Coca-Cola</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Coca-Cola</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badge bg-warning text-dark">En Proceso</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-toggle-status" data-status="en-proceso">Marcar como Listo</button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <!-- Scripts de Bootstrap y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
<script src="../../js/main.js"></script>
</html>

    <!-- Scripts de Bootstrap y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
</body>
<script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#ordersTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true
            });
            $('#beveragesTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true
            });

            // Manejo de clic en botones
            $(document).on('click', '.btn-toggle-status', function() {
                var $button = $(this);
                var currentStatus = $button.data('status');

                // Cambiar el estado y el texto del botón
                if (currentStatus === 'en-proceso') {
                    $button.data('status', 'listo');
                    $button.text('Marcar como En Proceso');
                    $button.removeClass('btn-success').addClass('btn-warning');
                    $button.closest('tr').find('td:eq(4) .badge').removeClass('bg-warning').addClass('bg-success').text('Listo');
                } else {
                    $button.data('status', 'en-proceso');
                    $button.text('Marcar como Listo');
                    $button.removeClass('btn-warning').addClass('btn-success');
                    $button.closest('tr').find('td:eq(4) .badge').removeClass('bg-success').addClass('bg-warning').text('En Proceso');
                }
            });
        });
    </script>
<script src="../../js/main.js"></script>
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- DataTable -->
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo constant('URL'); ?>public/js/empleados.js"></script>
<script src="<?php echo constant('URL'); ?>public/js/pedidos.js"></script>
<script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
<script type="module" src="<?php echo constant('URL'); ?>public/js/alertas.js"></script>
</html>
