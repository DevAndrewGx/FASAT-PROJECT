<?php 

    class CambiarPassword extends Controller {


        public function __construct() {
            parent::__construct();
        }

        function render() {
            error_log('CambiarPassword::render -> Carga la pagina principal para cambiar password');
            $this->view->render('login/cambiarpassword', []);
        }
    }
?>