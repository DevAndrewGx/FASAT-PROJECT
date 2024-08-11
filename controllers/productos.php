<?php 

    class Productos Extends SessionController { 
        
        private $user;

        function __construct() { 
            parent::__construct();

            $this->user = $this->getUserSessionData();
            error_log('Producto::construct -> Controlador producto');
        }


        function render() { 
            error_log('Producto::render -> Carga la pagina principal ');
            $this->view->render('admin/gestionInventario', []);
        }

        // creamos la funcion que nos permitira crear nuevos productos
        function createProduct() { 
            
            // primero validamos si la data viene correctamente desde el formulario
            error_log('Productos::createProduct -> Funcion para crear nuevos productos');
            
            if(!$this->existPOST(['nombre']));
        }

        
    }
?>