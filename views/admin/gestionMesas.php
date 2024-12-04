<?php
$user = $this->d['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | MESAS</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="base-url" content="<?php echo constant('URL'); ?>">

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
    <!-- cumston styles -->
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
                <div class="page-header">
                    <div class="page-title">
                        <h1>Mesas</h1>
                        <nav class="nav-main">
                            <a href="<?php echo constant('URL') ?>admin">Admin</a>
                            <a href="<?php echo constant('URL') ?>mesas" id="actual" data-navegation="#mesas" data-rol="admin"> / Mesas </a>
                        </nav>

                    </div>

                    <div class="page-btn">
                        <a href="#" onclick="openModalCreateMesas();" class="btn btn-added"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Agregar Nueva Mesa</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-mesas" class="table table-responsive datanew">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th class="sorting">Numero de mesa</th>
                                        <th class="sorting">Capacidad</th>
                                        <th class="sorting">Estado</th>
                                        <th class="sorting">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <div class="modal fade" id="modalFormMesas" tabindex="-1" aria-labelledby="mesasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="titleModal">Gestión de Mesas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMesas">
                        <div class="mb-3">
                            <label for="numeroMesa" class="form-label">Numero de mesa</label>
                            <input type="number" class="form-control" name="numeroMesa" id="numeroMesa" placeholder="Numero Mesa" min="1">
                            <div id="mesaNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un número válido mayor que 0.</div>
                        </div>



                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" name="capacidad" id="capacidad" placeholder="Capacidad" min="1" max="30">
                            <div id="capacidadError" class="invalid-feedback" style="display:none;">Por favor, ingresa un número entre 1 y 30.</div>
                        </div>


                        <div class="mb-3">
                            <label for="categoryType" class="form-label">Estado mesa</label>
                            <select class="form-control" name="estado" id="estado">
                                <option value="" selected>Seleccione estado</option>
                                <option value="DISPONIBLE">Disponible</option>
                                <option value="EN VENTA">En venta</option>
                                <option value="EN SERVICIO">En servicio</option>
                            </select>
                            <div id="typeCategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un estaddo valido</div>
                        </div>
                        <div class="tile-footer">
                            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class='bx bxs-check-circle'></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
    <script type="module" src="<?php echo constant('URL'); ?>public/js/mesas.js"></script>
</body>

</html>