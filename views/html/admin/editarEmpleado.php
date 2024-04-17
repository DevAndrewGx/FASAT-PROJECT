<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/empleados/stylesEmpleado.css">

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!-- ASIDE CONTAINER -->
    <div class="main-container">

        <header>
            <nav>
                <ul class="items-right">
                    <li>
                        <a href="#"><i class='bx bx-search'></i></a>
                    </li>

                    <li>
                        <a href="#"><i class='bx bx-bell'></i></a>
                    </li>

                    <li>
                        <a href="#"><img src="../../imgs/avatar-06.jpg" alt="admin" width="60px"></a>
                    </li>
                </ul>
            </nav>
        </header>

        <aside class="left-section">

            <div class="sidebar">

                <div class="logo">
                    <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
                    <a href="#"><img src="../../imgs/LOGOf.png" alt="logo"></a>
                </div>


                <div class="item">
                    <i class='bx bx-home-alt-2'></i>
                    <a href="adminDashboard.php">Dashboard</a>
                </div>
                <div class="item">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Ordenes</a>
                </div>
                <div class="item" id="active">
                    <i class='bx bxs-user-detail'></i>
                    <a href="gestionEmpleados.html">Empleados</a>
                </div>
                <div class="item">
                    <i class='bx bx-transfer-alt'></i>
                    <a href="gestionVentas.html">Ventas</a>
                </div>
                <div class="item">
                    <i class='bx bx-task'></i>
                    <a href="gestionInventario.html">Inventario</a>
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


        <!-- END OF SIDEBAR -->
        <!-- HEADER STYLES -->


        <!-- MAIN CONTENT -->
        <main>

            <h1>Manejo de usuarios</h1>
            <hp>Editar usuario</hp>
            <div class="page-wrapper">
                <div class="content">
                    <div class="page-header">
                        <div class="page-title">

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="formularioRegistro">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" id="nombres" class="form-control" placeholder="Ingrese Nombres" name="nombres">
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo documento</label>
                                            <select class="form-control select" id="tipo_documento" name="tipoDocumento">
                                                <option>Seleccione</option>
                                                <option>CC</option>
                                                <option>CC EXTRAGERIA</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Documento</label>
                                            <input type="text" id="documento" class="form-control" placeholder="Ingrese documento" name="documento">
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" id="email" class="form-control" placeholder="Ingrese correo" name="email">
                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input type="text" id="apellidos" class="form-control" placeholder="Ingrese usuario" name="apellidos">
                                        </div>
                                        <div class="form-group">
                                            <label>Rol</label>
                                            <select class="form-control select" id="rol" name="rol">
                                                <option>Seleccione</option>
                                                <option>Mesero</option>
                                                <option>Cheff</option>
                                                <option>Encargado inventario</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" id="telefono" class="form-control" placeholder="Ingrese numero de telefono" name="telefono">
                                        </div>

                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input type="text" id="direccion" class="form-control" placeholder="Ingrese Direccion" name="direccion">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Horario</label>
                                            <div class="row">
                                                <div class="pass-group col-lg-6">
                                                    <input type="time" id="desdeHorario" class="form-control pass-input" name="desdeHorario">
                                                    <!-- Icono para ocultar/mostrar contraseña -->

                                                </div>
                                                <div class="pass-group col-lg-6">
                                                    <input type="time" id="hastaHorario" class="form-control pass-input" name="hastaHorario">
                                                    <!-- Icono para ocultar/mostrar contraseña -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña</label>
                                            <div class="pass-group">
                                                <input type="password" id="password" class="form-control pass-input" placeholder="Ingresar contraseña" name="password">
                                                <!-- Icono para ocultar/mostrar contraseña -->
                                                <span class="fas toggle-passworda fa-eye-slash"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <div class="pass-group">
                                                <input type="password" class="form-control pass-inputs" placeholder="Confirmar Contraseña" name="validarPassword">
                                                <!-- Icono para ocultar/mostrar contraseña -->
                                                <span class="fas toggle-passworda fa-eye-slash"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Foto de perfil</label>
                                            <div class="image-upload image-upload-new">
                                                <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg" aria-describedby="Foto Empleado">
                                                <div class="image-uploads">
                                                    <img src="../../imgs/icons/upload.svg" alt="img">
                                                    <h4>Arrastra el archivo</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" href="#" class="btn btn-principal me-2">Aceptar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            // Obtener el id_usuario de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const id_usuario = urlParams.get('id_usuario');

            // Verificar si se ha obtenido el id_usuario
            if (id_usuario) {
                // Realizar la solicitud AJAX para obtener los datos del empleado
                $.post("../../../controllers/obtenerRegistroEmpleados.php", {
                    id_usuario
                }, function(response) {
                    let data = JSON.parse(response);

                    // Llenamos el formulario con los datos obtenidos
                    $('#nombres').val(data[0].nombres);
                    $('#tipo_documento').val(data[0].tipo_documento);
                    $('#documento').val(data[0].documento);
                    $('#email').val(data[0].correo);
                    $('#apellidos').val(data[0].apellidos);
                    $('#rol').val(data[0].rol);
                    $('#telefono').val(data[0].telefono);
                    $('#direccion').val(data[0].direccion);
                    $('#desdeHorario').val(data[0].hora_entrada);
                    $('#hastaHorario').val(data[0].hora_salida);
                    $('#foto').val(data[0].foto);
                });
            } else {
                // Mostrar un mensaje de error o redirigir a otra página
                console.error('No se proporcionó el id_usuario');
            }
        });
    </script>
    <script src="../../js/alertas.js"></script>
    <script src="../../js/app.js"></script>
</body>

</html>