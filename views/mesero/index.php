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
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Enviar Nuevo Pedido</h5>
                        <button class="btn btn-primary" id="openOrderForm" data-bs-toggle="modal" data-bs-target="#orderModal">Ingresar Orden</button>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Historial de Pedidos</h5>
                        <div class="table-responsive">
                            <table id="ordersTable" class="table table-responsive datanew">
                                <thead>
                                    <tr>
                                        <th class="sorting">Mesa</th>
                                        <th class="sorting">Mesero</th>
                                        <th class="sorting">Plato</th>
                                        <th class="sorting">Cantidad</th>
                                        <th class="sorting">Fecha</th>
                                        <th class="sorting">Estado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
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
            </div>
        </main>
    </div>

    <!-- Modal para abrir una mesa -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="orderModalLabel">Abrir Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pedidosForm">
                        <div class="mb-3" id="container-form">
                            <label for="categoriaPedido" class="form-label">Seleccione categoria</label>
                            <select name="categoriaPedido" id="categoriaPedido" class="form-control">
                                <option value="#" selected>Seleccione la categoria</option>
                            </select>
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un numero de mesa válido.</div>
                        </div>
                        <!-- select oculto para actualizar la subcategoria con su respectiva categoria
                              -->
                        <div class="mb-3" id="container-form">
                            <label for="productosPedidos" class="form-label">Seleccione producto</label>
                            <select name="productos" id="productos" class="form-control">
                                <option value="#" selected>Seleccione la producto</option>
                            </select>
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un numero de mesa válido.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="abrirMesa">Abrir Mesa</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para crear un pedido -->
    <div class="modal fade" id="pedidosModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="orderModalLabel">Adicionar productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pedi">
                        <div class="mb-3" id="container-form">
                            <label for="numeroMesa" class="form-label">Seleccione numero mesa</label>
                            <select name="numeroMesa" id="numeroMesa" class="form-control">
                                <option value="#" selected>Seleccione el numero de mesa</option>
                            </select>
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un numero de mesa válido.</div>
                        </div>
                        <!-- select oculto para actualizar la subcategoria con su respectiva categoria
                              -->
                        <div class="mb-3" id="meseroAsociado">
                            <label for="mesero" class="form-label">Nombre mesero asociado</label>
                            <input type="text" id="mesero" name="mesero" class="form-control" value="<?php echo $user->getNombres(); ?>" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="abrirMesa">Abrir Mesa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Popper.js para Bootstrap (necesario para los modales) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <!-- DataTables Bootstrap 5 integration -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="module" src="<?php echo constant('URL'); ?>public/js/alertas.js"></script>
    <!-- APP JS -->
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/mesas.js"></script>

</body>


</html>