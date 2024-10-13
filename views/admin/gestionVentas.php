
<?php
    $user = $this->d['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
    <!-- cumston styles -->
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
                        <h1>Ventas</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#ventas"> / Ventas </a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-responsive datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th class="sorting">Camarero</th>
                                    <th class="sorting">Cliente</th>
                                    <th class="sorting">Mesa</th>

                                    <th class="sorting">Total</th>
                                    <th class="sorting">Pagado</th>
                                    <th class="sorting">Pendiente</th>

                                    <th class="sorting">Fecha</th>
                                    <th class="sorting">Estado</th>
                                    <th class="sorting">Pago</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- TABLEROW1 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Juan Pérez</td>
                                    <td>Mesa 1</td>
                                    <td>5</td>

                                    <td>150.00</td>
                                    <td>150.00</td>
                                    <td>0.00</td>

                                    <td>19 Nov 2022</td>
                                    <td><span class="badges bg-lightgreen">Entregada</span></td>
                                    <td><span class="badges bg-lightgreen">Pagado</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- TABLEROW2 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Marta González</td>
                                    <td>Mesa 2</td>
                                    <td>8</td>

                                    <td>80.00</td>
                                    <td>0.00</td>
                                    <td>80.00</td>

                                    <td>20 Nov 2022</td>
                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- TABLEROW3 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Luisa Martínez</td>
                                    <td>Mesa 3</td>
                                    <td>3</td>

                                    <td>120.00</td>
                                    <td>0.00</td>
                                    <td>120.00</td>
                                    <td>21 Nov 2022</td>

                                    <td><span class="badges bg-lightgreen">Entregada</span></td>
                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- TABLEROW4 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Carlos Sánchez</td>
                                    <td>Mesa 4</td>
                                    <td>7</td>
                                    <td>90.00</td>
                                    <td>0.00</td>
                                    <td>90.00</td>
                                    <td>22 Nov 2022</td>

                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- TABLEROW5 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Carlos Sánchez</td>
                                    <td>Mesa 4</td>
                                    <td>7</td>
                                    <td>90.00</td>
                                    <td>0.00</td>
                                    <td>90.00</td>
                                    <td>22 Nov 2022</td>

                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td><span class="badges bg-lightred">Pendiente</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- TABLEROW6 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Carlos Sánchez</td>
                                    <td>Mesa 4</td>
                                    <td>7</td>
                                    <td>90.00</td>
                                    <td>0.00</td>
                                    <td>90.00</td>

                                    <td>22 Nov 2022</td>
                                    <td><span class="badges bg-lightgreen">Entregada</span></td>
                                    <td><span class="badges bg-lightgreen">Pagado</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- TABLEROW7 -->
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>Carlos Sánchez</td>
                                    <td>Mesa 4</td>
                                    <td>7</td>
                                    <td>90.00</td>
                                    <td>0.00</td>
                                    <td>90.00</td>

                                    <td>22 Nov 2022</td>
                                    <td><span class="badges bg-lightgreen">Entregada</span></td>
                                    <td><span class="badges bg-lightgreen">Pagado</span></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acción
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="detalleVenta.html">Detalles de la
                                                        Venta</a>
                                                </li>
                                                <li><a class="dropdown-item" href="detalleVenta.html">Editar Venta</a></li>
                                                <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Eliminar Venta</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
</body>

</html>