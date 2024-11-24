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
                <div class="item active" id="ordenes">
                    <i class='bx bx-food-menu'></i>
                    <a href="<?php echo constant('URL'); ?>mesero">Ordenes</a>
                </div>
                <div class="item" id="mesas">
                    <i class='bx bx-grid-alt'></i>
                    <a href="<?php echo constant('URL'); ?>mesasMesero">Mesas</a>
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
                            <a href="homeAdmin.php" id="actual" data-navegation="#mesero" data-rol="mesero">Mesero</a>
                        </nav>
                    </div>
                    <div class="page-btn">
                        <a href="#" class="btn btn-primary" id="btnCrearPedido" data-bs-toggle="modal" data-bs-target="#generarPedidoModal"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Crear Nuevo Pedido</a>
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
                                    <th class="sorting">Pedido</th>
                                    <th class="sorting">Total</th>

                                    <th class="sorting">Estado</th>
                                    <th class="sorting">Accion</th>
                                </thead>
                                <tbody>
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
                                    <th class="sorting">Capacidad</th>
                                    <th class="sorting">Comensales</th>
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

    <!-- <div class="modal fade" id="abrirMesaModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="abrirMesaLabel">Abrir Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="abrirMesaForm">
                        <div class="mb-3" id="meseroAsociado">
                            <label for="mesero" class="form-label">Nombre mesero asociado</label>
                            <input type="text" name="<?php echo $user->getDocumento(); ?>" class="form-control" value="<?php echo $user->getNombres(); ?>" disabled>
                        </div>
                        <div class="mb-3" id="container-form">
                            <label for="numeroMesa" class="form-label">Seleccione numero mesa</label>
                            <select name="numeroMesa" id="numeroMesaa" class="form-control">
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
    </div> -->

    <!-- modal para generar un pedido -->
    <div class="modal fade" id="generarPedidoModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister d-flex justify-content-between align-items-center p-3">
                    <h5 class="modal-title fw-bold" id="orderModalLabel">Nuevo Pedido</h5>

                    <div class="d-flex flex-column align-items-end px-4">
                        <h4 class="fw-bold mb-0" id="codigo-pedido"></h4>
                        <p class="fw-bold mb-0" id="fecha-hora"></p>
                    </div>

                    <!-- Botón de cerrar en la esquina superior derecha -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Encabezado de pedido y fecha -->
                <div class="modal-body">
                    <form id="formPedido">
                        <div class="mb-3" id="container-form">
                            <div class="row mb-3">
                                <div class="form-group col-md-4">
                                    <label for="numeroMesa" class="form-label">Numero de Mesa</label>
                                    <select name="numeroMesa" id="numeroMesa" class="form-control">
                                        <option value="#">Selecciona mesa</option>
                                    </select>
                                    <div id="nombresError" class="invalid-feedback" style="display:none;">Seleccione un numero de mesa valido.</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apellidos" class="form-label">Nombre Mesero</label>
                                    <input type="text" id="idMesero" name="idMesero" data-id="<?php echo $user->getDocumento(); ?>" class="form-control" value="<?php echo $user->getNombres(); ?>" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="numeroPersonas" class="form-label">Numero de personas</label>
                                    <input type="number" class="form-control" id="numeroPersonas" name="numeroPersonas">
                                    <div id="numeroPersonasError" class="invalid-feedback" style="display:none;">Por favor, ingresa un número de personas valido válido.</div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="mb-3">Agregar Productos</h5>
                                    <div class="row mb-2">
                                        <div class="form-group col-md-6">
                                            <label for="categoriaPedido" class="form-label">Categoria</label>
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

                                        <div class="form-group col-md-6">
                                            <label for="producto" class="form-label">Producto</label>
                                            <select name="producto" id="producto" class="form-control">
                                                <option value="#">Selecciona producto</option>
                                                <?php
                                                foreach ($categorias as $cat) {
                                                ?>
                                                    <option value="<?php echo $cat->getIdCategoria() ?>"><?php echo $cat->getNombreCategoria() ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="cantidadItems" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidadItems" name="cantidadItems">
                                            <div id="numeroPersonasError" class="invalid-feedback" style="display:none;">Por favor, ingresa un número valido de items. </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="notasItems" class="form-label">Notas Producto</label>
                                            <input type="text" class="form-control" id="notasItems" name="notasItems" placeholder="Ej:Sin sal, termino medio">
                                        </div>
                                    </div>
                                    <button id="agregar-pedido-btn" class="btn btn-primary w-100 d-flex align-items-center justify-content-center fw-900">Agregar Producto</button>
                                </div>
                            </div>

                            <!-- Los productos del pedido que se van agregar dinamicamente -->
                            <div class="conatiner-productos">
                                <h6 class="fw-bold">Productos del Pedido</h6>
                                <!-- contenedor para mostrar los elementos dinamicamente  -->
                                <div id="listaProductos">

                                </div>
                                <hr class="my-4">
                            </div>

                            <!-- Total y notas generales del pedido -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold">Total:</h5>
                                <h5 id="totalPedido" class="text-end fw-bold">$0.00</h5>
                            </div>
                            <div class="form-group">
                                <label for="notasPedido" class="form-label">Notas Generales del Pedido</label>
                                <textarea class="form-control" id="notasPedido" rows="3" placeholder="Notas adicionales sobre el pedido..."></textarea>
                            </div>
                            <button type="submit" id="enviar-pedido-btn" class="btn btn-primary w-100 d-flex align-items-center justify-content-center fw-900">Enviar Pedido</button>
                        </div>
                    </form>
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