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

    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/inventario.css">
</head>

<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-wrapper">

        <?php require_once('views/header.php') ?>
        <?php require_once('aside.php') ?>


        <!-- MAIN CONTENT -->
        <main class="page-wrapper" style="min-height: 995px;">

            <div class="content">

                <div class="nav-sections">
                    <nav>
                        <ul>
                            <li id="active"><a href="#">Lista Productos</a></li>
                            <li><a href="listaCategorias.html">Lista Categorias</a></li>
                            <li><a href="#">Control de Stock</a></li>
                        </ul>
                    </nav>
                </div>


                <div class="nav-sections">
                    <nav>
                        <!-- cunstom selects -->
                        <ul>
                            <div class="select-menu">
                                <div class="select-btn">
                                    <span class="select-placeholder">Categoria</span>
                                    <i class='bx bxs-chevron-down'></i>
                                </div>
                                <ul class="options">
                                    <li class="option">
                                        <span class="option-text">Comidas rapidas</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Platos especiales</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Ensaladas</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Bebidas</span>
                                    </li>

                                </ul>
                            </div>

                            <div class="select-menu">
                                <div class="select-btn">
                                    <span class="select-placeholder">Sub-categorias</span>
                                    <i class='bx bxs-chevron-down'></i>
                                </div>
                                <ul class="options">
                                    <li class="option">
                                        <span class="option-text">Sin sal</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Con azucar</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Dietica</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Espodarica</span>
                                    </li>

                                </ul>
                            </div>

                            <div class="select-menu">
                                <div class="select-btn">
                                    <span class="select-placeholder">Producto</span>
                                    <i class='bx bxs-chevron-down'></i>
                                </div>
                                <ul class="options">
                                    <li class="option">
                                        <span class="option-text">Coca-cola</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Ensalada italiana</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Pollo asado</span>
                                    </li>

                                    <li class="option">
                                        <span class="option-text">Espodarica</span>
                                    </li>

                                </ul>
                            </div>

                            <!-- <li id="active"><a href="#"></a></li>
                            <li><a href="listaCategorias.html">Lista Categorias</a></li>
                            <li><a href="#">Control de Stock</a></li> -->
                        </ul>
                    </nav>
                </div>

                <div class="page-header">
                    <div class="page-title">
                        <h1>Productos</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario"> / Inventario </a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario"> / Productos </a>
                        </nav>
                    </div>
                    <div class="page-btn">
                        <a href="crearProducto.html" class="btn btn-added"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Agregar Nuevo
                            Producto</a>
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
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Producto</th>
                                        <th>SKU</th>
                                        <th>Categoría</th>
                                        <th>Marca</th>
                                        <th>Precio</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Creado Por</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <td>Pizza</td>
                                        <td>PT0012</td>
                                        <td>Comida Rápida</td>
                                        <td>N/D</td>
                                        <td>12.99</td>
                                        <td>pc</td>
                                        <td>50.00</td>
                                        <td>Admin</td>
                                        <td>
                                            <a href="editarCategory.html">
                                                <img src="../../imgs/icons/edit.svg" alt="edit">
                                            </a>
                                            <a href="#">
                                                <img src="../../imgs/icons/trash.svg" alt="edit">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <td>Hamburguesa</td>
                                        <td>HB0034</td>
                                        <td>Comida Rápida</td>
                                        <td>N/D</td>
                                        <td>8.99</td>
                                        <td>pc</td>
                                        <td>30.00</td>
                                        <td>Admin</td>
                                        <td>
                                            <a href="editarCategory.html">
                                                <img src="../../imgs/icons/edit.svg" alt="edit">
                                            </a>
                                            <a href="#">
                                                <img src="../../imgs/icons/trash.svg" alt="edit">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <td>Ensalada César</td>
                                        <td>EN0056</td>
                                        <td>Ensaladas</td>
                                        <td>N/D</td>
                                        <td>6.99</td>
                                        <td>pc</td>
                                        <td>20.00</td>
                                        <td>Admin</td>
                                        <td>
                                            <a href="editarCategory.html">
                                                <img src="../../imgs/icons/edit.svg" alt="edit">
                                            </a>
                                            <a href="#">
                                                <img src="../../imgs/icons/trash.svg" alt="edit">
                                            </a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <td>Sushi</td>
                                        <td>SH0089</td>
                                        <td>Comida Asiática</td>
                                        <td>N/D</td>
                                        <td>15.99</td>
                                        <td>pc</td>
                                        <td>40.00</td>
                                        <td>Admin</td>
                                        <td>
                                            <a href="editarCategory.html">
                                                <img src="../../imgs/icons/edit.svg" alt="edit">
                                            </a>
                                            <a href="#">
                                                <img src="../../imgs/icons/trash.svg" alt="edit">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <td>Tacos</td>
                                        <td>TC0075</td>
                                        <td>Comida Mexicana</td>
                                        <td>N/D</td>
                                        <td>10.99</td>
                                        <td>pc</td>
                                        <td>35.00</td>
                                        <td>Admin</td>
                                        <td>
                                            <a href="editarCategory.html">
                                                <img src="../../imgs/icons/edit.svg" alt="edit">
                                            </a>
                                            <a href="#">
                                                <img src="../../imgs/icons/trash.svg" alt="edit">
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            <script src="<?php echo constant('URL'); ?>public/js/inventario.js"></script>
        </main>
</body>



</html>