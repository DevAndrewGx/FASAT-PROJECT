<?php 

    // esta clase se encargara de crear la sessiones
    class Session {
        
        // creamos un atributo con un valor con defecto
        private $sessionName = 'user';
        public function __construct() {


            // validamos si la sesion ya existe en el constructor
            if(session_status() == PHP_SESSION_NONE) {
                // si no existe creamos una nueva session
                session_start();

            }
        }


        // funcion para guardar el nombre del usuario en la session
        public function setCurrentUser($user) {
            $_SESSION[$this->sessionName] = $user;
        }


        
        // funcion para obtener la session del usuario actual
        public function getCurrentUser() {
            return $_SESSION[$this->sessionName];
        }


        // esta funcion nos ayuda a cerrar la session 
        public function closeSession() { 
            session_unset(); //esta funcion nos permite borrar todas las variables de session que tengamos
            session_destroy(); // finalmente destruimos la session
        }


        // esta funcion es util para saber si aun existe la session
        public function exist() {
            return isset($_SESSION[$this->sessionName]);
        }
    }
?>