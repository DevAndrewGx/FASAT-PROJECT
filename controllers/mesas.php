<?php 
    class Mesas extends SessionController { 

        private $user;

        function __construct()
        {
            parent::__construct();
            // obtenemos el usuario de la session
            $this->user = $this->getUserSessionData();
            error_log('Mesas::construct -> controlador usuarios');
        }
    
        function render()
        {
            error_log('Mesas::render -> Carga la pagina principal de las mesas');
            $this->view->render('admin/gestionMesas', [
                'user' => $this->user
            ]);
        }
    }
?>