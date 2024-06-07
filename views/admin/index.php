<?php
// require_once('../../../models/seguridadAdmin.php');
// require_once('../../../models/Conexion.php');
// require_once('../../../models/Sesion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <!-- <link rel="shortcut icon" href="../../imgs/LOGOf.png"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/dashboard.css">

</head>

<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-wrapper">

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
                                <img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="admin">
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
                                <a class="dropdown-item" href="perfil.html"> <img src="../../imgs/icons/user.svg" alt="user">
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
                    <a href="#"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>

                </div>


                <div class="item" id="active">
                    <i class='bx bx-home-alt-2'></i>
                    <a href="adminDashboard.html">Dashboard</a>
                </div>
                <div class="item">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Ordenes</a>
                </div>
                <div class="item">
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
                    <a href="#">Ajustes</a>
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
            <h1>Admin Dashboard</h1>
            <div class="analyse">
                <!-- STOCK
                            SALES
                            SALES-INCOME
                            ORDERS TODAY -->
                <div id="stock">
                    <div class="status">
                        <div class="info">
                            <h2>Elementos en stock</h2>
                            <h3>90 +</h3>
                        </div>

                        <div class="progress">
                            <div class="item">
                                <i class='bx bx-package'></i>
                            </div>

                            <div class="value">
                                <p>+ 7%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="orders">
                    <div class="status">
                        <div class="info">
                            <h2>Ordenes hoy </h2>
                            <h3>15 +</h3>

                        </div>

                        <div class="progress">
                            <div class="item">
                                <i class='bx bx-cart-download'></i>
                            </div>

                            <div class="value">
                                <p>+ 5%</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="sales-income">
                    <div class="status">
                        <div class="info">
                            <h2>Ingresos Ventas</h2>
                            <h3>$80.000</h3>
                        </div>

                        <div class="progress">
                            <div class="item">
                                <i class='bx bxs-dish'></i>
                            </div>

                            <div class="value">
                                <p>+ 7%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="total-sales">
                    <div class="status">
                        <div class="info">
                            <h2>Total Ventas</h2>
                            <h3>100 +</h3>
                        </div>

                        <div class="progress">
                            <div class="item">
                                <i class='bx bx-trending-up'></i>
                            </div>

                            <div class="value">
                                <p>+ 15%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CHART ANALYTICS -->
            <div class="charts-analytics">
                <div class="chart">
                    <h2>Productos Stock</h2>
                    <p>Mes-a-mes Comparación</p>

                    <div class="pulse">
                    </div>
                    <div class="chart-area">
                        <div class="grid"></div>
                    </div>
                </div>

                <div class="chart">
                    <h2>Ventas & Gastos</h2>
                    <p>Mes-a-mes Comparison</p>
                    <div class="pulse-sale">

                    </div>
                    <span id="sale-span">Ventas</span>

                    <div class="pulse-expense">

                    </div>
                    <span id="expense-span">Gastos</span>

                    <div class="chart-area chart-ExSa">
                        <div class="grid"></div>
                    </div>
                </div>
            </div>

            <div id="orders-employees">

                <div class="employee">
                    <h2>Empleados</h2>
                    <p id="list">Lista de empleados</p>
                    <div class="data-employee">

                        <div class="info-employee">
                            <div class="img">
                                <img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="avatar-02">
                            </div>
                            <div class="info">
                                <h3>Juan Andres</h3>
                                <p>Mesero</p>

                            </div>
                        </div>


                        <div class="display-info">
                            <a href="#"><img src="../../imgs/icons/eye.svg" alt="eye-display">Mostrar</a>
                        </div>

                    </div>

                    <div class="data-employee">

                        <div class="info-employee">
                            <div class="img">
                                <img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="avatar-02">
                            </div>
                            <div class="info">
                                <h3>Fernando Gabriel</h3>
                                <p>Cheff</p>
                            </div>
                        </div>


                        <div class="display-info">
                            <a href="#"><img src="../../imgs/icons/eye.svg" alt="eye-display">Mostrar</a>
                        </div>

                    </div>

                    <div class="data-employee">
                        <div class="info-employee">
                            <div class="img">
                                <img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="avatar-02">
                            </div>
                            <div class="info">
                                <h3>Maria Antonia</h3>
                                <p>Mesera</p>
                            </div>
                        </div>


                        <!-- DISPLAY INFORMATION'S EMPLOYEES -->
                        <div class="display-info">
                            <a href="#"><img src="../../imgs/icons/eye.svg" alt="eye-display">Mostrar</a>
                        </div>

                    </div>
                    <!-- BUTTON TO WATCH MORE DETAILS ABOUT EMPLOYEES -->
                    <!-- <div id="more-details">
                        <a href="#">Mas detalles</a>
                    </div> -->

                </div>

                <div id="orders">
                    <h2>Productos</h2>
                    <p>Ultimos productos mas vendidos</p>
                    <table id="example" class="table table-responsive datanew">
                        <thead>
                            <tr>
                                <th>h</th>
                                <th>First</th>
                                <th>Last</th>
                                <th>Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>


    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- APEXCHART LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../../js/appChart.js"></script>

    <!-- DATA-TABLES -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



    <!-- APP JS -->
    <script src="../../js/app.js"></script>
</body>

</html>