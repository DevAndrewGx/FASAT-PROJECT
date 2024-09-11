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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                    <a href="#">Ordenes</a>
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
                        <h1>Gestión de Caja</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#ordenes"> / Gestión de Caja </a>
                        </nav>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Mesa 5</h5>
                        <p>Precio a Pagar: $300</p>
                        <button class="btn btn-primary openRestaurantInfo" data-mesa="5" data-precio="300" data-platos="Ensalada, Sopa de Pollo, Bistec" data-bebidas="Coca-Cola, Agua">Pagar</button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Mesa 6</h5>
                        <p>Precio a Pagar: $150</p>
                        <button class="btn btn-primary openRestaurantInfo" data-mesa="6" data-precio="150" data-platos="Pasta Alfredo, Ensalada César" data-bebidas="Jugo de Naranja, Té Helado">Pagar</button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Mesa 7</h5>
                        <p>Precio a Pagar: $200</p>
                        <button class="btn btn-primary openRestaurantInfo" data-mesa="7" data-precio="200" data-platos="Pizza Margherita, Tiramisu" data-bebidas="Cerveza, Vino Tinto">Pagar</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Información del Restaurante -->
    <div class="modal fade" id="restaurantInfoModal" tabindex="-1" aria-labelledby="restaurantInfoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restaurantInfoModalLabel">Información del Restaurante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="restaurantInfoForm">
                        <div class="mb-3">
                            <label for="restaurantName" class="form-label">Nombre del Restaurante</label>
                            <input type="text" class="form-control" id="restaurantName" value="Restaurante Ejemplo" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="restaurantAddress" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="restaurantAddress" value="Calle Falsa 123" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="restaurantPhone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="restaurantPhone" value="123456789" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="continueToInvoice">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Factura -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="invoiceContent">
                        <h3>Restaurante Ejemplo</h3>
                        <p>Dirección: Calle Falsa 123</p>
                        <p>Teléfono: 123456789</p>
                        <hr>
                        <p id="invoiceMesa">Mesa: </p>
                        <p id="invoicePrecio">Precio a Pagar: $</p>
                        <p id="invoicePlatos">Platos: </p>
                        <p id="invoiceBebidas">Bebidas: </p>
                        <hr>
                        <p>Gracias por su visita!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="generateInvoice">Generar Factura</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('.openRestaurantInfo').on('click', function () {
                const mesa = $(this).data('mesa');
                const precio = $(this).data('precio');
                const platos = $(this).data('platos');
                const bebidas = $(this).data('bebidas');
                $('#restaurantInfoModal').modal('show');
                $('#continueToInvoice').data('mesa', mesa);
                $('#continueToInvoice').data('precio', precio);
                $('#continueToInvoice').data('platos', platos);
                $('#continueToInvoice').data('bebidas', bebidas);
            });

            $('#continueToInvoice').on('click', function () {
                const mesa = $(this).data('mesa');
                const precio = $(this).data('precio');
                const platos = $(this).data('platos');
                const bebidas = $(this).data('bebidas');
                $('#invoiceMesa').text(`Mesa: ${mesa}`);
                $('#invoicePrecio').text(`Precio a Pagar: $${precio}`);
                $('#invoicePlatos').text(`Platos: ${platos}`);
                $('#invoiceBebidas').text(`Bebidas: ${bebidas}`);
                $('#invoiceModal').modal('show');
            });

            $('#generateInvoice').on('click', function () {
                Swal.fire({
                    title: 'Factura Generada',
                    text: 'La factura ha sido generada con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                }).then(() => {
                    $('#invoiceModal').modal('hide');
                });
            });
        });
    </script>
</body>

</html>
