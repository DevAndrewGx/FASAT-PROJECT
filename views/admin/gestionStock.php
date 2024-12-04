<?php
$user = $this->d['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | STOCK</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/inventario.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/empleados.css">
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
                            <li><a href="<?php echo constant('URL'); ?>productos">Lista Productos</a></li>
                            <li><a href="<?php echo constant('URL'); ?>categorias">Lista Categorias</a></li>
                            <li id="active"><a href="<?php echo constant('URL'); ?>stock">Control de Stock</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="page-header">
                    <div class="page-title">
                        <h1>Control de Stock</h1>
                        <nav class="nav-main">
                            <a href="<?php echo constant('URL') ?>admin">Admin</a>
                            <a href="<?php echo constant('URL') ?>productos" id="actual" data-navegation="#inventario" data-rol="admin"> / Inventario </a>
                            <a href="<?php echo constant('URL') ?>stock" id="actual" data-navegation="#inventario" data-rol="admin"> / Stock </a>
                        </nav>
                    </div>

                </div>

                <div class="row">
                    <!-- Tabla de Productos -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Productos</h5>
                                <div class="table-responsive">
                                    <table id="data-stock-productos" class="table datanew" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <label class="checkboxs">
                                                        <input type="checkbox">
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </th>

                                                <th>Producto</th>
                                                <th>Stock</th>
                                                <th>Disponible</th>
                                                <th>Cantidad Minima</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Control de Stock -->
    <!-- <div class="modal fade" id="modalStock" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="stockModalLabel">Agregar Control de Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formStock">
                        <div class="mb-3">
                            <label for="productSelect" class="form-label">Producto o Ingrediente</label>
                            <select id="productSelect" class="form-select">
                                <optgroup label="Productos">
                                    <option>Agua Mineral</option>
                                    <option>Cerveza Rubia</option>
                                </optgroup>
                                <optgroup label="Ingredientes">
                                    <option>Harina de Trigo</option>
                                    <option>Jamón</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stockActual" class="form-label">Stock Actual</label>
                            <input type="number" id="stockActual" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="stockMinimo" class="form-label">Stock Mínimo</label>
                            <input type="number" id="stockMinimo" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="comentarios" class="form-label">Comentarios</label>
                            <textarea id="comentarios" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="guardarStock">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> -->


    <!-- Modal para Editar Stock -->
    <div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="editStockModalLabel">Actualizar Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditStock">
                        <div class="mb-3">
                            <label for="editProductSelect" class="form-label">Producto o Ingrediente</label>
                            <input type="text" class="form-control" id="nombreProductoStock" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="editStockActual" class="form-label">Stock Actual</label>
                            <input type="number" id="stockActual" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editStockMinimo" class="form-label">Stock Mínimo</label>
                            <input type="number" id="stockMinimo" class="form-control">
                        </div>

                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class='bx bxs-check-circle'></i><span id="btnText">Actualizar Stock</span></button>&nbsp;&nbsp;&nbsp;
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para Confirmación de Eliminación -->
    <div class="modal fade" id="modalDeleteStock" tabindex="-1" aria-labelledby="deleteStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="deleteStockModalLabel">¿Estás seguro?</h5>
                    <p>Esta acción no se puede deshacer.</p>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Sí, eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <!-- DataTables Bootstrap 5 integration -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="module" src="<?php echo constant('URL'); ?>public/js/alertas.js"></script>

    <script src="<?php echo constant('URL'); ?>public/js/inventario.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/categorias.js"></script>

</body>



</html>