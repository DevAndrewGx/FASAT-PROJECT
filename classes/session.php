<?php 

    // esta clase se encargara de crear la sessiones
    class Session {
        
        // creamos un atributo con un valor con defecto
        private $nombreSession = 'user';
        public function __construct() {


            // validamos si la sesion ya existe en el constructor
            if(session_status() == PHP_SESSION_NONE) {
                // si no existe creamos una nueva session
                session_start();
            }
        }


        // funcion para guardar el nombre del usuario en la session
        public function setUsuarioActual($user) {
            $_SESSION[$this->nombreSession] = $user;
        }


        // funcion para obtener la session del usuario actual
        public function getUsuarioActual() {
            return $_SESSION[$this->nombreSession];
        }


        // esta funcion nos ayuda a cerrar la session 
        public function cerrarSesion() { 
            session_unset(); //esta funcion nos permite borrar todas las variables de session que tengamos
            session_destroy(); // finalmente destruimos la session
        }


        // esta funcion es util para saber si aun existe la session
        public function existe() {
            return isset($_SESSION[$this->nombreSession]);
        }
    }
?>