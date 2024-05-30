<?php 

    class Login extends SessionController{
        
        function __construct() { 
            
            // llamamos al constructor de controller para tener sus caracteritisticas
            parent::__construct();
            error_log('Login::construct -> inicio de login');  
        }

        function render() { 
            error_log('Login::render -> Carga la pagina principal del login');
            $this->view->render('login/index');
        }
    }
?>