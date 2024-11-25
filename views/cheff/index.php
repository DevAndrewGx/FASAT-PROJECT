<?php
$user = $this->d['user'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                        <h1>Panel de Cocina</h1>
                        <nav class="nav-main">
                            <a href="homeChef.php">Chef</a>
                            <a href="chefPedidos.php" id="actual"> / Gestión de Pedidos </a>
                        </nav>
                    </div>
                </div>

                <!-- Resumen de estados -->
                <div class="d-flex justify-content-end mb-4">
                    <!-- Contador de pendientes -->
                    <div class="d-flex align-items-center border rounded-pill px-3 py-1 me-2" style="border-color: #ffc107;">
                        <i class="bi bi-exclamation-circle-fill text-warning me-2" style="font-size: 1.2rem;"></i>
                        <span class="text-warning fw-bold">Pendientes:</span>
                        <span class="ms-1 text-warning">1</span>
                    </div>

                    <!-- Contador en preparación -->
                    <div class="d-flex align-items-center border rounded-pill px-3 py-1 me-2" style="border-color: #000;">
                        <i class="bi bi-clock text-dark me-2" style="font-size: 1.2rem;"></i>
                        <span class="text-dark fw-bold">En preparación:</span>
                        <span class="ms-1 text-dark">1</span>
                    </div>

                    <!-- Contador completados -->
                    <div class="d-flex align-items-center border rounded-pill px-3 py-1" style="border-color: #198754;">
                        <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.2rem;"></i>
                        <span class="text-success fw-bold">Completados:</span>
                        <span class="ms-1 text-success">0</span>
                    </div>
                </div>


                <!-- Pedidos -->
                <div id="contenedor-pedidos" class="row g-3">
                    <!-- Pedido #001 -->
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">Pedido - <span id="codigo-pedido-cheff"></span></h5>
                                    <small class="text-muted">Mesa 5 <big>|</big> 14:30</small>
                                </div>
                                <span class="badges bg-lightred">PENDIENTE</span>
                            </div>

                            <div class="m-3 p-3 border border-secondary rounded" style="border-color: #ccc !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <!-- Nombre del producto -->
                                    <h6 class="mb-0">2x Filete de res</h6>
                                    <!-- Estado -->
                                    <span class="badge bg-warning text-light">PENDIENTE</span>
                                </div>
                                <!-- Notas -->
                                <p class="mb-2"><small class="text-muted">Notas: Término medio</small></p>
                                <!-- Botones -->
                                <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                <button class="btn bg-transparent btn-sm" disabled>Completar</button>
                            </div>

                            <div class="m-3 p-3 border border-secondary rounded" style="border-color: #ccc !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <!-- Nombre del producto -->
                                    <h6 class="mb-0">2x Filete de res</h6>
                                    <!-- Estado -->
                                    <span class="badge bg-warning text-dark">PENDIENTE</span>
                                </div>
                                <!-- Notas -->
                                <p class="mb-2"><small class="text-muted">Notas: Término medio</small></p>
                                <!-- Botones -->
                                <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                <button class="btn btn-secondary btn-sm" disabled>Completar</button>
                            </div>


                            <div class="m-3 p-3 border border-secondary rounded" style="border-color: #ccc !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <!-- Nombre del producto -->
                                    <h6 class="mb-0">2x Filete de res</h6>
                                    <!-- Estado -->
                                    <span class="badge bg-warning text-dark">PENDIENTE</span>
                                </div>
                                <!-- Notas -->
                                <p class="mb-2"><small class="text-muted">Notas: Término medio</small></p>
                                <!-- Botones -->
                                <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                <button class="btn btn-secondary btn-sm" disabled>Completar</button>
                            </div>


                            <div class="m-3 p-3 border border-secondary rounded" style="border-color: #ccc !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <!-- Nombre del producto -->
                                    <h6 class="mb-0">2x Filete de res</h6>
                                    <!-- Estado -->
                                    <span class="badge bg-warning text-dark">PENDIENTE</span>
                                </div>
                                <!-- Notas -->
                                <p class="mb-2"><small class="text-muted">Notas: Término medio</small></p>
                                <!-- Botones -->
                                <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                <button class="btn btn-secondary btn-sm" disabled>Completar</button>
                            </div>

                            <div class=" card-footer text-muted d-flex align-items-center">
                                <i class="bi bi-clock me-2"></i> Tiempo transcurrido: 5 min
                            </div>
                        </div>
                    </div>

                    <!-- Pedido #002 -->
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">Pedido #002</h5>
                                    <small class="text-muted">Mesa 3 <big>|</big> 14:25</small>
                                </div>
                                <span class="badge bg-dark text-light">EN PREPARACIÓN</span>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>1x Pasta Alfredo</h6>
                                        <p class="mb-2"><small class="text-muted">Notas: Extra queso</small></p>
                                        <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                        <button class="btn btn-success btn-sm">Completar</button>
                                    </div>
                                    <span class="badge bg-dark text-light">EN PREPARACIÓN</span>
                                </div>
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>2x Sopa del día</h6>
                                        <p class="mb-2"><small class="text-muted"></small></p>
                                        <button class="btn btn-secondary btn-sm me-2" disabled>Iniciar</button>
                                        <button class="btn btn-success btn-sm" disabled>Completado</button>
                                    </div>
                                    <span class="badge bg-success text-light">COMPLETADO</span>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex align-items-center">
                                <i class="bi bi-clock me-2"></i> Tiempo transcurrido: 10 min
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">Pedido #002</h5>
                                    <small class="text-muted">Mesa 3 <big>|</big> 14:25</small>
                                </div>
                                <span class="badge bg-dark text-light">EN PREPARACIÓN</span>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>1x Pasta Alfredo</h6>
                                        <p class="mb-2"><small class="text-muted">Notas: Extra queso</small></p>
                                        <button class="btn btn-dark btn-sm me-2">Iniciar</button>
                                        <button class="btn btn-success btn-sm">Completar</button>
                                    </div>
                                    <span class="badge bg-dark text-light">EN PREPARACIÓN</span>
                                </div>
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>2x Sopa del día</h6>
                                        <p class="mb-2"><small class="text-muted"></small></p>
                                        <button class="btn btn-secondary btn-sm me-2" disabled>Iniciar</button>
                                        <button class="btn btn-success btn-sm" disabled>Completado</button>
                                    </div>
                                    <span class="badge bg-success text-light">COMPLETADO</span>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex align-items-center">
                                <i class="bi bi-clock me-2"></i> Tiempo transcurrido: 10 min
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="<?php echo constant('URL'); ?>public/js/cheff.js"></script>
</body>


</html>