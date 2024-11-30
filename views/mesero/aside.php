<aside class="left-section">
    <div class="sidebar">
        <div class="logo">
            <button class="menu-btn" id="menu-close"><i class='bx bx-log-out-circle'></i></button>
            <a href="#"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo"></a>
            <i class='bx bxs-chevron-left-circle'></i>
        </div>
        <div class="item active" id="ordenes">
            <i class='bx bx-food-menu'></i>
            <a href="<?php echo constant('URL'); ?>mesero">Ordenes</a>
        </div>
        <div class="item" id="mesas">
            <i class='bx bx-grid-alt'></i>
            <a href="<?php echo constant('URL'); ?>mesasMesero">Mesas</a>
        </div>
    </div>
    <div class="log-out sidebar">
        <div class="item">
            <i class='bx bx-log-out'></i>
            <a href="<?php echo constant("URL"); ?>logout">Cerrar Sesion</a>
        </div>
    </div>
</aside>