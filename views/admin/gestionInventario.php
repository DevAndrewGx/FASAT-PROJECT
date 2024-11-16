<?php
// llamamos al objeto de categorias para recorrerlo 
$categories = $this->d['categories'];
$subcategories = $this->d['subcategories'];
$user = $this->d['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | INVENTARIO</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">

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
                            <li id="active"><a href="<?php echo constant('URL'); ?>productos">Lista Productos</a></li>
                            <li><a href="<?php echo constant('URL'); ?>categorias">Lista Categorias</a></li>
                            <li><a href="<?php echo constant('URL');?>stock">Control de Stock</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="page-header">
                    <div class="page-title">
                        <h1>Productos</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario"> / Inventario </a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario-productos"> / Productos </a>
                        </nav>
                    </div>
                    <div class="page-btn">
                        <a href="#" onclick="openModalCreateProduct();" class="btn btn-added"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Agregar Nuevo
                            Producto</a>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-productos" class="table datanew" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
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


        </main>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFormCreateProduct" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formProduct" name="formProduct" class="form-horizontal" enctype="multipart/form-data">
                        <p class="text-primary">Todos los campos son obligatorios.</p>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6">
                                <label for="nombreProducto" class="col-form-label">Nombre producto</label>
                                <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6">
                                <label for="categoria" class="col-form-label">Categoría</label>
                                <select name="categoria" class="form-control select" id="categoria">
                                    <option value="#">Selecciona una categoria</option>
                                    <?php
                                    foreach ($categories as $cat) {
                                    ?>
                                        <option value="<?php echo $cat->getIdCategoria() ?>"><?php echo $cat->getNombreCategoria() ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="subcategoria" class="col-form-label">Subcategoria</label>
                                <select name="subcategoria" class="form-control select" id="subcategoria">
                                    <option>Seleccionar subcategoria</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="precio" class="col-form-label">Precio</label>
                                <input type="text" class="form-control valid validText" name="precio" id="precio" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cantidad" class="col-form-label">Cantidad</label>
                                <!-- <select name="disponibilidad" class="form-control select" id="disponibilidad">
                                    <option>Seleccionar opcion</option>
                                    <option value="SI">Si</option>
                                    <option value="NO">No</option>
                                </select> -->
                                <input type="number" class="form-control valid validTest" name="cantidad" id="cantidad" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="descripcion">Descripcion</label>
                                <textarea rows="10" cols="50" name="descripcion" class="form-control" id="descripcion"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Foto de producto</label>
                                <div class="image-upload image-upload-new col-md-12">
                                    <input type="file" name="foto" id="foto" accept=".png, .jpg, .jpeg" aria-describedby="Foto Empleado">
                                    <div class="image-uploads">
                                        <img src="<?php echo constant('URL') ?>public/imgs/icons/upload.svg" alt="img">
                                        <h4>Arrastra el archivo</h4>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="tipoFoto" value="Productos">
                        </div>
                        <div class="tile-footer">
                            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class='bx bxs-check-circle'></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class='bx bxs-x-circle'></i>Cerrar</button>
                        </div>
                    </form>
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
</body>



</html>