<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
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


                <div class="item active" id="dashboard">
                    <i class='bx bx-home-alt-2'></i>
                    <a href="<?php echo constant('URL'); ?>admin">Dashboard</a>
                </div>
                <div class="item" id="empleados">
                    <i class='bx bxs-user-detail'></i>
                    <a href="<?php echo constant('URL'); ?>users">Usuarios</a>
                </div>
                <div class="item" id="ordenes">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Ordenes</a>
                </div>

                <div class="item" id="ventas">
                    <i class='bx bx-transfer-alt'></i>
                    <a href="<?php echo constant('URL'); ?>ventas">Ventas</a>
                </div>
                <div class="item" id="inventario">
                    <i class='bx bx-task'></i>
                    <a href="<?php echo constant('URL'); ?>productos">Inventario</a>
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
        <!-- HEADER STYLES -->


        <!-- MAIN CONTENT -->
        <main-mesa>

            <h1>Mapa de Mesas</h1>
            <p>Selecciona las mesas que deseas abrir a compra</p>
            <div class="page-wrapper">
                <div class="table-wrapper">
                    <!-- Contenedor de las mesas -->
                    <div id="contenedor">
                        <!-- Mesas -->
                        <div class="mesa redonda" id="mesa1" onclick="toggleSeleccion('mesa1')">1
                            <button class=" btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none; ">Abrir Mesa</button>
                        </div>
                        <div class="mesa redonda" id="mesa2" onclick="toggleSeleccion('mesa2')">2
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa cuadrada" id="mesa3" onclick="toggleSeleccion('mesa3')">3
                            <button class=" btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa cuadrada" id="mesa4" onclick="toggleSeleccion('mesa4')">4
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa redonda" id="mesa5" onclick="toggleSeleccion('mesa5')">5
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa cuadrada" id="mesa6" onclick="toggleSeleccion('mesa6')">6
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa cuadrada" id="mesa7" onclick="toggleSeleccion('mesa7')">7
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa redonda" id="mesa8" onclick="toggleSeleccion('mesa8')">8
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa cuadrada" id="mesa9" onclick="toggleSeleccion('mesa9')">9
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                        <div class="mesa redonda" id="mesa10" onclick="toggleSeleccion('mesa10')">10
                            <button class="btn btn-primary btn-registrar-mesa" onclick="mostrarFormulario()" style="display: none;">Abrir Mesa</button>
                        </div>
                    </div>
                </div>
            </div>


        </main-mesa>


    </div>

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


</body>

</html>