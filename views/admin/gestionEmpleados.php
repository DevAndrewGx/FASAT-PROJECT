<?php
// require_once('../../../models/seguridadAdmin.php');
// require_once('../../../models/Consultas.php');

// require_once('../../../models/Conexion.php');
// require_once('../../../models/Sesion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | EMPLEADOS</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/empleados.css">
</head>


<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-wrapper">

        <?php require_once('views/header.php') ?>
        <?php require_once('aside.php') ?>


        <!-- MAIN CONTENT -->
        <main class="page-wrapper" style="min-height: 995px">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Empleados</h1>
                        <!-- <p>Gestiona tus empleados</p> -->

                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#empleados"> / Empleados </a>
                        </nav>

                    </div>
                    <div class="pdf">
                        <a href="pdf/usuarios.php" class="btn btn-outline-secondary me-2" style="border: none; background-color: transparent;">
                            <img src="<?php echo constant('URL') ?>/public/imgs/icons/pdf1.svg" alt="Exportar a PDF">
                        </a>
                        <a href="vendor/usuarios.php" class="btn btn-outline-secondary me-2" style="border: none; background-color: transparent;">
                            <img src="<?php echo constant('URL') ?>/public/imgs/icons/excel1.svg" alt="Exportar a Excel">
                        </a>
                        <a href="#" onclick="openModalCreateUser();" class="btn btn-primary">
                            <img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="Agregar Empleado"> Agregar Empleado
                        </a>
                        
                    </div>
                </div>

                     <div class="contain">
                        <button id="modalcarga" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            Subir Archivo Excel
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Cargar Archivo Excel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Botón para descargar la plantilla -->
                                    <a href="vendor/plantilla.php" class="btn btn-secondary mb-3">Descargar Plantilla Excel</a>
                                    <!-- Contenedor para las alertas -->
                                    <div id="alertContainer" class="mb-3"></div>
                                    <!-- Formulario para cargar el archivo Excel -->
                                    <form id="subirEx" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="excelFile" class="form-label">Selecciona el archivo Excel:</label>
                                            <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Subir Archivo</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-empleados" class="table datanew nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Documento</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        <th>Rol</th>
                                        <th>Creado el</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aqui vamos insertar la data con jquery -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUsuario" name="formUsuario" class="form-horizontal" enctype="multipart/form-data">
                        <p class="text-primary">Todos los campos son obligatorios.</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="identificacion">Identificación</label>
                                <input type="number" class="form-control" id="identificacion" name="documento">
                                <div id="identificacionError" class="invalid-feedback" style="display:none;">Por favor, ingresa una identificación válida.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres">
                                <div id="nombresError" class="invalid-feedback" style="display:none;">Por favor, ingresa nombres válidos.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos">
                                <div id="apellidosError" class="invalid-feedback" style="display:none;">Por favor, ingresa apellidos válidos.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="telefono">Teléfono</label>
                                <input type="number" class="form-control" id="telefono" name="telefono">
                                <div id="telefonoError" class="invalid-feedback" style="display:none;">Por favor, ingresa un número de teléfono válido.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div id="emailError" class="invalid-feedback" style="display:none;">Por favor, ingresa un email válido.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="rol">Rol</label>
                                <select class="form-control select" name="rol" id="rol">
                                    <option selected="true">Seleccione</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Mesero</option>
                                    <option value="3">Cheff</option>
                                    <option value="4">Cajero</option>
                                </select>
                                <div id="rolError" class="invalid-feedback" style="display:none;">Por favor, selecciona un rol.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="estado">Estado</label>
                                <select class="form-control selectpicker" id="estado" name="estado">
                                    <option>Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                    <option value="3">Pendiente</option>
                                </select>
                                <div id="estadoError" class="invalid-feedback" style="display:none;">Por favor, selecciona un estado.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div id="passwordError" class="invalid-feedback" style="display:none;">Campo obligatorio.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="validarPassword">Confirmar contraseña</label>
                                <input type="password" class="form-control pass-inputs" id="validarPassword" name="validarPassword">
                                <div id="validarPasswordError" class="invalid-feedback" style="display:none;">Campo obligatorio.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>Foto de perfil</label>
                                <div class="image-upload image-upload-new col-md-6">
                                    <input type="file" name="foto" id="foto" accept=".png, .jpg, .jpeg" aria-describedby="Foto Empleado">
                                    <div class="image-uploads">
                                        <img src="<?php echo constant('URL') ?>public/imgs/icons/upload.svg" alt="img">
                                        <h4>Arrastra el archivo</h4>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="tipoFoto" value="Usuarios">
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

    <script src="<?php echo constant('URL'); ?>public/js/empleados.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    script src="<?php echo constant('URL'); ?>public/js/carga.js"></script>

</body>

</html>
