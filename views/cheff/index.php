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
        <?php require_once('aside.php') ?>

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
                    <!-- Se va cargar el contenido dinamicamente cuando cargue la pagina en el DOM -->
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