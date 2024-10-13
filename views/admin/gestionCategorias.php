<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | CATEGORIAS</title>
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
                            <li id="active"><a href="<?php echo constant('URL'); ?>categorias">Lista Categorias</a></li>
                            <li><a href="<?php echo constant('URL'); ?>stock">Control de Stock</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="page-header">
                    <div class="page-title">
                        <h1>Categorias</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario"> / Inventario </a>
                            <a href="adminUsu.php" id="actual" data-navegation="#inventario"> / Categorias </a>
                        </nav>
                    </div>
                    <div class="page-btn">
                        <a href="#" onclick="openModalCreateCategory();" class="btn btn-added"><img src="<?php echo constant('URL') ?>/public/imgs/icons/plus.svg" alt="add-icon">
                            Agregar Nueva
                            categoria</a>
                    </div>
                </div>

                <div class="row gap-3">
                    <div class="card mr-3 col-lg-6" style="width: 50%;">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-categorias" class="table datanew nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>Categoría</th>
                                            <th>Tipo de categoria</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card col-lg-6" style="width: 48%;">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-categorias-subcategorias" class="table datanew nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>Subcategoria</th>
                                            <th>Categoria asociada</th>
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
        </main>


        <!-- Modal de Gestión de Categorías -->
        <div class="modal fade" id="modalFormCategories" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header headerRegister">
                        <h5 class="modal-title" id="titleModal">Gestión de Categorías</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formCategories">
                            <div class="mb-3">
                                <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" name="nombreCategoria" id="nombreCategoria" placeholder="Nombre de la Categoría">
                                <div id="categoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un nombre de categoría válido.</div>
                            </div>
                            <div class="mb-3">
                                <label for="categoryType" class="form-label">Tipo de categoria</label>
                                <select class="form-control" name="tipoCategoria" id="tipoCategoria">
                                    <option value="" selected>Seleccione una categoria</option>
                                    <option value="Productos">Productos</option>
                                    <option value="Ingredientes">Ingredientes</option>
                                </select>
                                <div id="typeCategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un tipo de categoría válido.</div>
                            </div>

                            <div class="mb-3" id="subCategoryOption">
                                <input type="checkbox" id="hasSubcategory">
                                <label for="hasSubcategory">Agregar Subcategoría</label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" id="addCategory">Agregar Categoría</button>
                            </div>
                            <!-- <div class="mb-3">
                                <h5>Lista de Categorías</h5>
                                <div class="table-responsive">
                                    <table class="table" id="categoriesTable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de Subcategorías -->
        <div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="subcategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header  headerRegister">
                        <h5 class="modal-title" id="nameSubCategory">Agregar Subcategoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formSubcategory">
                            <div class="mb-3" id="container-form">
                                <label for="subCategoriaNombre" class="form-label">Nombre de la Subcategoría</label>
                                <input type="text mb-3" class="form-control" name="subCategoriaNombre" id="subCategoriaNombre" placeholder="Nombre de la Subcategoría">
                                <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un nombre de subcategoría válido.</div>
                            </div>
                            <!-- select oculto para actualizar la subcategoria con su respectiva categoria
                              -->
                            <div class="mb-3" id="categoriaAsociadaContainer" style="display:none;">
                                <label for="categoriaAsociada" class="form-label">Nombre de la Categoría</label>
                                <select name="categoriaAsociada" id="categoriaAsociada" class="form-control">
                                    <!-- Aquí se insertarán las opciones desde JavaScript -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" id="addSubcategory">Agregar Subcategoría</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
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

    <script src="<?php echo constant('URL'); ?>public/js/empleados.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/categorias.js"></script>


    <!-- <script>
        $(document).ready(function() {
            const categoriesTable = $('#categoriesTable tbody');
            const subcategoryTable = $('#subcategoryTable tbody');

            // Agregar categoría
            $('#addCategory').click(function() {
                const categoryName = $('#categoryName').val().trim();

                if (categoryName === '') {
                    $('#categoryName').addClass('is-invalid');
                    $('#categoryNameError').show();
                } else {
                    $('#categoryName').removeClass('is-invalid');
                    $('#categoryNameError').hide();

                    // Añadir nueva categoría a la tabla
                    const newRow = `<tr>
                                    <td>${categoryName}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm edit-category">Editar</button>
                                        <button class="btn btn-danger btn-sm delete-category">Eliminar</button>
                                    </td>
                                </tr>`;
                    categoriesTable.append(newRow);

                    // Mostrar modal de subcategoría si el checkbox está marcado
                    if ($('#hasSubcategory').is(':checked')) {
                        $('#modalFormCategories').modal('hide');
                        $('#subcategoryModal').modal('show');
                    }

                    $('#categoryName').val('');
                }
            });

            // Editar categoría
            categoriesTable.on('click', '.edit-category', function() {
                const row = $(this).closest('tr');
                const categoryName = row.find('td').eq(0).text();

                $('#categoryName').val(categoryName);
                row.remove();
            });

            // Eliminar categoría
            categoriesTable.on('click', '.delete-category', function() {
                $(this).closest('tr').remove();
            });

            // Agregar subcategoría
            $('#addSubcategory').click(function() {
                const subcategoryName = $('#subcategoryName').val().trim();

                if (subcategoryName === '') {
                    $('#subcategoryName').addClass('is-invalid');
                    $('#subcategoryNameError').show();
                } else {
                    $('#subcategoryName').removeClass('is-invalid');
                    $('#subcategoryNameError').hide();

                    // Añadir nueva subcategoría a la tabla
                    const newRow = `<tr>
                                    <td>${subcategoryName}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm edit-subcategory">Editar</button>
                                        <button class="btn btn-danger btn-sm delete-subcategory">Eliminar</button>
                                    </td>
                                </tr>`;
                    subcategoryTable.append(newRow);
                    $('#subcategoryName').val('');
                }
            });

            // Editar subcategoría
            subcategoryTable.on('click', '.edit-subcategory', function() {
                const row = $(this).closest('tr');
                const subcategoryName = row.find('td').eq(0).text();

                $('#subcategoryName').val(subcategoryName);
                row.remove();
            });

            // Eliminar subcategoría
            subcategoryTable.on('click', '.delete-subcategory', function() {
                $(this).closest('tr').remove();
            });
        });
    </script> -->
</body>



</html>