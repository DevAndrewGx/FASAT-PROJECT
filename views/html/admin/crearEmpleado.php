<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | DASHBOARD</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/empleados/stylesEmpleado.css">
    <link rel="stylesheet" href="../../styles/style.css">
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-img">
                                <img src="../../imgs/avatar-06.jpg" alt="admin" width="60px">
                                <span class="status1 online"></span></span>
                            </span>
                        </a>

                        <!-- DROPDOWN MENU -->

                        <div class="dropdown-menu menu-drop-user">
                            <div class="profilename">
                                <div class="profileset">
                                    <span class="user-img"><img src="../../imgs/avatar-06.jpg" alt="hello">
                                        <span class="status2 online"></span></span>
                                    <div class="profilesets">
                                        <h6>Juanita Dow</h6>
                                        <h5>Admin</h5>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <a class="dropdown-item" href="#"> <img src="../../imgs/icons/user.svg" alt="user">
                                    My
                                    Profile</a>
                                <a class="dropdown-item" href="#"><img src="../../imgs/icons/settings.svg" alt="settings">Settings</a>
                                <hr class="m-0">
                                <a class="dropdown-item logout pb-0" href="../../../controllers/cerrarSesion.php"><img src="../../imgs/icons/log-out.svg" alt="logout">Logout</a>
                            </div>
                        </div>
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
                    <a href="gestionEmpleados.php">Empleados</a>
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
            <p>Agregar usuario</p>
            <div class="page-wrapper">
                <div class="content">

                    <div class="">
                        <div class="card-body">

                            <form action="../../../controllers/registrarEmpleado.php" method="POST" enctype="multipart/form-data" id="formularioRegistro">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" class="form-control" placeholder="Ingrese Nombres" name="nombres">
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo documento</label>
                                            <select class="form-control select" name="tipoDocumento">
                                                <option>Seleccione</option>
                                                <option>CC</option>
                                                <option>CC EXTRAGERIA</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Documento</label>
                                            <input type="text" class="form-control" placeholder="Ingrese documento" name="documento">
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" placeholder="Ingrese correo" name="email">
                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input type="text" class="form-control" placeholder="Ingrese usuario" name="apellidos">
                                        </div>
                                        <div class="form-group">
                                            <label>Rol</label>
                                            <select class="form-control select" name="rol">
                                                <option>Seleccione</option>
                                                <option>Mesero</option>
                                                <option>Cheff</option>
                                                <option>Encargado inventario</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" class="form-control" placeholder="Ingrese numero de telefono" name="telefono">
                                        </div>

                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input type="text" class="form-control" placeholder="Ingrese Direccion" name="direccion">
                                        </div>





                                    </div>

                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Horario</label>
                                            <div class="row">
                                                <div class="pass-group col-lg-6">
                                                    <input type="time" class="form-control pass-input" name="desdeHorario">
                                                    <!-- Icono para ocultar/mostrar contraseña -->

                                                </div>
                                                <div class="pass-group col-lg-6">
                                                    <input type="time" class="form-control pass-input" name="hastaHorario">
                                                    <!-- Icono para ocultar/mostrar contraseña -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña</label>
                                            <div class="pass-group">
                                                <input type="password" class="form-control pass-input" placeholder="Ingresar contraseña" name="password">
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
                                                <input type="file" name="foto" accept=".png, .jpg, .jpeg" aria-describedby="Foto Empleado">
                                                <div class="image-uploads">
                                                    <img src="../../imgs/icons/upload.svg" alt="img">
                                                    <h4>Arrastra el archivo</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" href="#" class="btn btn-principal me-2">Aceptar</button>
                                        <!-- <a href="gestionEmpleados.html" class="btn btn-danger">Cancelar</a> -->
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>

        </main>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../js/app.js"></script>

    <script src="../../js/alertas.js"></script>
</body>

</html>