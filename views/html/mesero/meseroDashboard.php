<?php
require_once('../../../models/seguridadMesero.php');
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
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">



</head>

<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-container">

        <header>
            <nav>
                <ul class="items-right">
                    <li>
                        <a href="#"><i class='bx bx-search'></i></a>
                    </li>

                    <li>
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
                                <a class="dropdown-item logout pb-0" href="../../../controllers/cerrarSesion.php"><img src="../../imgs/icons/log-out.svg" alt="logout">Logout</a>
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




                <div class="item" id="active">
                    <i class='bx bx-food-menu'></i>
                    <a href="registroMesas.html">Hacer orden</a>
                </div>

                <div class="item">
                    <i class='bx bx-calendar'></i>
                    <a href="diaVentas.html">Ordenes del dia</a>
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
                        <div class="mesa redonda" id="mesa1" onclick="toggleSeleccion('mesa1')">1</div>
                        <div class="mesa redonda" id="mesa2" onclick="toggleSeleccion('mesa2')">2</div>
                        <div class="mesa cuadrada" id="mesa3" onclick="toggleSeleccion('mesa3')">3</div>
                        <div class="mesa cuadrada" id="mesa4" onclick="toggleSeleccion('mesa4')">4</div>
                        <div class="mesa redonda" id="mesa5" onclick="toggleSeleccion('mesa5')">5</div>
                        <div class="mesa cuadrada" id="mesa6" onclick="toggleSeleccion('mesa6')">6</div>
                        <div class="mesa cuadrada" id="mesa7" onclick="toggleSeleccion('mesa7')">7</div>
                        <div class="mesa redonda" id="mesa8" onclick="toggleSeleccion('mesa8')">8</div>
                        <div class="mesa cuadrada" id="mesa9" onclick="toggleSeleccion('mesa9')">9</div>
                        <div class="mesa redonda" id="mesa10" onclick="toggleSeleccion('mesa10')">10</div>
                    </div>
                </div>
            </div>

            <!-- Botón para registrar orden -->
            <button class="btn btn-primary registrar-orden-btn" onclick="mostrarFormulario()">Registrar Orden</button>


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