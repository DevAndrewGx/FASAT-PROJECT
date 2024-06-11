<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAST | PROJECT</title>
</head>

<body>
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
                            <img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="admin">
                            <span class="status1 online"></span></span>
                        </span>
                    </a>

                    <!-- DROPDOWN MENU -->

                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo constant('URL'); ?>public/imgs/avatar-02.jpg" alt="hello">
                                    <span class="status2 online"></span></span>
                                <div class="profilesets">
                                    <h6>Juanita Dow</h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="perfil.html"> <img src="<?php echo constant('URL'); ?>public/imgs/icons/user.svg" alt="user">
                                My
                                Profile</a>
                            <a class="dropdown-item" href="#"><img src="<?php echo constant('URL'); ?>public/imgs/icons/settings.svg" alt="user">Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="../../../controllers/cerrarSesion.php"><img src="<?php echo constant('URL'); ?>public/imgs/icons/log-out.svg" alt="logout">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
</body>

</html>