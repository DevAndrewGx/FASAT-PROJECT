<?php 
    // creamos la clase para el controlador
    
    class Inventario extends SessionController {

        
        function __construct()
        {
            parent::__construct();
            error_log('Inventario::construct -> controlador inventariio');
        }

        function render()
        {
            error_log('Inventario::render -> Carga la pagina principal del inventario');
            $this->view->render('admin/gestionInventario');
        }
    }

?>