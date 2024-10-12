<aside class="left-section">

    <div class="sidebar">

        <div class="logo">
            <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
            <a href="#"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>
            <i class='bx bxs-chevron-left-circle'></i>
        </div>


        <div class="item active" id="dashboard">
            <i class='bx bx-home-alt-2'></i>
            <a href="<?php echo constant('URL'); ?>admin">Dashboard</a>
        </div>
        <div class="item" id="empleados">
            <i class='bx bxs-user-detail'></i>
            <a href="<?php echo constant('URL'); ?>users">Usuarios</a>
        </div>
        <div class="item" id="ordenes">
            <i class='bx bx-grid-alt'></i>
            <a href="#">Ordenes</a>
        </div>
        
        <div class="item" id="ventas">
            <i class='bx bx-transfer-alt'></i>
            <a href="<?php echo constant('URL'); ?>ventas">Ventas</a>
        </div>
        <div class="item" id="inventario">
            <i class='bx bx-task'></i>
            <a href="<?php echo constant('URL'); ?>productos">Inventario</a>
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