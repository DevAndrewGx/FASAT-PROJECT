<aside class="left-section">

    <div class="sidebar">

        <div class="logo">
            <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
            <a href="<?php echo constant('URL') ?>admin"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>
            <i class='bx bxs-chevron-left-circle'></i>
        </div>


        <div class="item active" id="dashboard">
            <a href="<?php echo constant('URL'); ?>admin">
                <i class='bx bx-home-alt-2'></i>
                Dashboard
            </a>
        </div>
        <div class="item" id="empleados">
            <a href="<?php echo constant('URL'); ?>users">
                <i class='bx bxs-user-detail'></i>
                Usuarios
            </a>
        </div>
        <div class="item" id="mesas">
            <a href="<?php echo constant('URL'); ?>mesas">
                <i class='bx bxs-grid'></i>
                Mesas
            </a>
        </div>
        <div class="item" id="ventas">
            <a href="<?php echo constant('URL'); ?>ventas">
                <i class='bx bx-transfer-alt'></i>
                Ventas
            </a>
        </div>
        <div class="item" id="inventario">
            <a href="<?php echo constant('URL'); ?>productos">
                <i class='bx bx-task'></i>
                Inventario
            </a>
        </div>
        <div class="item">
            <a href="#">
                <i class='bx bx-cog'></i>
                Settings
            </a>
        </div>

    </div>

    <div class="log-out sidebar">
        <div class="item">
            <i class='bx bx-log-out'></i>
            <a href="../../sing-up/login.html">Log-out</a>
        </div>
    </div>
</aside>