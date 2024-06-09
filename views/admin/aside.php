<aside class="left-section">

    <div class="sidebar">

        <div class="logo">
            <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
            <a href="#"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>
        </div>


        <div class="item">
            <i class='bx bx-home-alt-2'></i>
            <a href="<?php echo constant('URL'); ?>admin">Dashboard</a>
        </div>
        <div class="item">
            <i class='bx bx-grid-alt'></i>
            <a href="#">Ordenes</a>
        </div>
        <div class="item" id="active">
            <i class='bx bxs-user-detail'></i>
            <a href="<?php echo constant('URL'); ?>empleados">Empleados</a>
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