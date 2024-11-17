<?php
$user = $this->d['user'];
$mesas = $this->d['mesa'];
$categorias = $this->d['categorias'];
?>

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
                    <i class='bx bx-food-menu'></i>
                    <a href="<?php echo constant('URL'); ?>mesero">Ordenes</a>
                </div>
                <div class="item" id="mesas">
                    <i class='bx bx-grid-alt'></i>
                    <a href="<?php echo constant('URL'); ?>mesasMesero">Mesas</a>
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
        <!-- MAIN CONTENT -->
        <main class="page-wrapper" style="min-height: 995px;">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Mesas</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Mesero</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#mesas" data-rol="mesero"> / Visualizacion de mesas</a>
                        </nav>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mesas & Pedidos Asociados</h5>
                        <div class="table-responsive">
                            <table id="data-mesas-pedidos" class="table table-responsive datanew">
                                <thead>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>

                                    <th class="sorting">Numero mesa</th>
                                    <th class="sorting">Pedido Asociado</th>
                                    <th class="sorting">Estado</th>
                                    <th class="sorting">Accion</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mesas & Pedidos Asociados</h5>
                        <div class="table-responsive">
                            <table id="dataa-mesas-pedidos" class="table table-responsive datanew">
                                <thead>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>

                                    <th class="sorting">Numero mesa</th>
                                    <th class="sorting">Pedido Asociado</th>
                                    <th class="sorting">Estado</th>
                                    <th class="sorting">Accion</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            </div>
        </main>
    </div>



    <!-- jQuery primero, luego Popper.js, luego Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <!-- DataTables Bootstrap 5 integration -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="module" src="<?php echo constant('URL'); ?>public/js/alertas.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/mesas.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/pedidos.js"></script>

</body>


</html>