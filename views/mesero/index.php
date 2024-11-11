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
                        <h1>Gestión de Pedidos</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#ordenes"> / Gestión de Pedidos </a>
                        </nav>
                    </div>
                    <div class="page-btn">
                        <a href="#" class="btn btn-primary" id="openOrderForm" data-bs-toggle="modal" data-bs-target="#abrirMesaModal"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Crear Nueva Orden</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos Actuales y en Cola</h5>
                        <div class="table-responsive">
                            <table id="data-pedidos" class="table table-responsive datanew">
                                <thead>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>

                                    <th class="sorting">Mesa</th>
                                    <th class="sorting">Mesero</th>
                                    <th class="sorting">Codigo Pedido</th>
                                    <th class="sorting">Cantidad</th>

                                    <th class="sorting">Estado</th>
                                    <th class="sorting">Accion</th>
                                    <th class="sorting">Fecha</th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5</td>
                                        <td>Juan Pérez</td>
                                        <td>Pizza Margarita</td>
                                        <td>2</td>
                                        <td>19 Nov 2022</td>
                                        <td><span class="badges bg-lightgreen">Entregada</span></td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acción
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="#">Detalles del Pedido</a></li>
                                                    <li><a class="dropdown-item" href="#">Editar Pedido</a></li>
                                                    <li><a class="dropdown-item" href="#">Descargar PDF</a></li>
                                                    <li><a class="dropdown-item" href="#">Eliminar Pedido</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
            </div>
    </div>
    </main>
    </div>

    <!-- Modal para abrir una mesa -->
    <div class="modal fade" id="abrirMesaModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="abrirMesaLabel">Abrir Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="abrirMesaForm">

                        <!-- select oculto para actualizar la subcategoria con su respectiva categoria
                              -->
                        <div class="mb-3" id="meseroAsociado">
                            <label for="mesero" class="form-label">Nombre mesero asociado</label>
                            <input type="text" name="<?php echo $user->getDocumento(); ?>" class="form-control" value="<?php echo $user->getNombres(); ?>" disabled>
                        </div>
                        <div class="mb-3" id="container-form">
                            <label for="numeroMesa" class="form-label">Seleccione numero mesa</label>
                            <select name="numeroMesa" id="numeroMesa" class="form-control">
                                <option value="#" selected>Seleccione el numero de mesa</option>
                            </select>
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un numero de mesa válido.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="abrirMesaButton">Abrir Mesa</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- modal para generar un pedido -->
    <div class="modal fade" id="generarPedidoModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="orderModalLabel">Agregar productos - Mesa <span id="estado-mesa"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm">
                        <div class="mb-3" id="container-form">
                            <label for="categoriaPedido" class="form-label">Categoria producto</label>
                            <select name="categoriaPedido" id="categoriaPedido" class="form-control">
                               <option value="#">Selecciona una categoria</option>
                                    <?php
                                    foreach ($categorias as $cat) {
                                    ?>
                                        <option value="<?php echo $cat->getIdCategoria() ?>"><?php echo $cat->getNombreCategoria() ?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="mb-3" id="container-form">
                            <label for="numeroMesa" class="form-label">Seleccione numero mesa</label>
                            <select name="numeroMesa" id="numeroMesa" class="form-control">
                                <option value="#" selected>Seleccione el numero de mesa</option>
                            </select>
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un numero de mesa válido.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="crearPedido">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal para ver los detalles de la mesa y el pedido asociado -->
    <div class="modal fade" id="detallesPedidoMesaModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="orderModalLabel">Detalles Mesa y Pedido Asociado<span id="estado-mesa"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Numero Mesa:</td>
                                <td id="numeroPedidoMesa"></td>
                            </tr>
                            <tr>
                                <td>Pedido Asociado:</td>
                                <td id="codigoPedido"></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td id="estado"></td>
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
    <script src="<?php echo constant('URL'); ?>public/js/mesas.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/pedidos.js"></script>

</body>


</html>