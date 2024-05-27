<?php 

    // esta clase se encargara de crear la sessiones
    class Session {
        
        // creamos un atributo con un valor con defecto
        private $sessionName = 'user';
        public function __construct() {


            // validamos si la sesion ya existe en el constructor
            if(session_status() == PHP_SESSION_NONE) {
                // we have to initializer our sessions if it doesn't exist
                session_start();

            }
        }

        // function to set up a new session for the current user
        public function setCurrentUser($user) {
            $_SESSION[$this->sessionName] = $user;
        }


        //function to get the current user

        public function getCurrentUser() {
            return $_SESSION[$this->sessionName];
        }


        // function to close the session
        public function closeSession() { 
            session_unset();
            session_destroy();
        }


        // function to know if session is already exist
        public function exist() {
            return isset($_SESSION[$this->sessionName]);
        }
    }
?>