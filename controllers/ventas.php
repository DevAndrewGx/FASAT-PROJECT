<?php
// controlador para modulos empleados

class Ventas extends SessionController
{
    private $user;

    function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log('Ventas::construct -> controlador ventas');
    }

    function render()
    {
        error_log('Login::render -> Carga la pagina principal de los empleados');
        $this->view->render('admin/gestionVentas', [
            'user' => $this->user
        ]);
    }
}
