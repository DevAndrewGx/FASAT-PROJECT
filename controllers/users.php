<?php
// controlador para modulos empleados

class Users extends SessionController
{


    function __construct()
    {
        parent::__construct();
        error_log('Empleados::construct -> controlador empleados');
    }

    function render()
    {
        error_log('Login::render -> Carga la pagina principal de los empleados');
        $this->view->render('admin/gestionEmpleados');
    }
}
