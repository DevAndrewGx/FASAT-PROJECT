<?php
// controlador para modulos empleados

class MesasMesero extends SessionController
{
    private $user;

    function __construct()
    {
        parent::__construct();
        $this->user = $this->getDatosUsuarioSession();
        error_log('MesasMesero::construct -> controlador mesasMesero');
    }

    function render()
    {
        error_log('MesasMesero::render -> carga la pagina principal de las mesaa para el mesero');
        $this->view->render('mesero/mesas', [
            'user' => $this->user
        ]);
    }
}
