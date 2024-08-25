<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>FAST | GESTIÓN DE CATEGORÍAS</title>
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
                <div class="item" id="categorias">
                    <i class='bx bx-category'></i>
                    <a href="#">Categorías</a>
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
                        <h1>Gestión de Categorías</h1>
                        <nav class="nav-main">
                            <a href="homeAdmin.php">Admin</a>
                            <a href="adminCat.php" id="actual" data-navegation="#categorias"> / Gestión de Categorías </a>
                        </nav>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Agregar Nueva Categoría</h5>
                        <!-- Botón para abrir el modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriesModal">Agregar Categoría</button>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista de Categorías</h5>
                        <div class="table-responsive">
                            <table id="categoriesTable" class="table table-responsive datanew">
                                <thead>
                                    <tr>
                                        <th class="sorting">Nombre</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se añadirán las categorías dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Gestión de Categorías -->
    <div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriesModalLabel">Gestión de Categorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoriesForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Nombre de la Categoría">
                            <div id="categoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un nombre de categoría válido.</div>
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" id="hasSubcategory"> 
                            <label for="hasSubcategory">Agregar Subcategoría</label>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="addCategory">Agregar Categoría</button>
                        </div>
                        <div class="mb-3">
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
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Subcategorías -->
    <div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="subcategoryModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subcategoryModalLabel">Agregar Subcategoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="subcategoryForm">
                        <div class="mb-3">
                            <label for="subcategoryName" class="form-label">Nombre de la Subcategoría</label>
                            <input type="text" class="form-control" id="subcategoryName" placeholder="Nombre de la Subcategoría">
                            <div id="subcategoryNameError" class="invalid-feedback" style="display:none;">Por favor, ingresa un nombre de subcategoría válido.</div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="addSubcategory">Agregar Subcategoría</button>
                        </div>
                        <div class="mb-3">
                            <h5>Lista de Subcategorías</h5>
                            <div class="table-responsive">
                                <table class="table" id="subcategoryTable">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se añadirán las subcategorías dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?php echo constant('URL'); ?>public/js/categories.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/app.js"></script>
    <script type="module" src="<?php echo constant('URL'); ?>public/js/alertas.js"></script>

    <!-- Script de manejo de categorías y subcategorías -->
    <script>
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
                    $('#categoriesModal').modal('hide');
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
    </script>
</body>

</html>
