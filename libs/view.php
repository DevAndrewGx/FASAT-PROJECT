<?php 
    // Esta clase nos va servir como base para exterla a todas nuestras vistas
    class View { 

        protected $d;
        function __construct() { 

        }


        // creamos la funcion render para cargar o mostrar nuestra vista
        // esta funcion resive 2 parametros que son la vista que es el archivo que queremos cargar(nombre) 
        // y data que es un arreglo que nos va permitir pasar data del controlador a la vista para que lo muestre, en vez de hacerlo de forma manual
        function render($nombre, $data = []) { 
            // variable d -> data
            $this->d = $data;
            $this->handleMessages();
            // llamamos el archivo con el nombre de la vista que queremos cargar
            require 'views/'.$nombre.'.php';
        }


        // function para la manejar los mensajes para mostrarlos en la vista

        private function handleMessages() { 

            // validamos si estan los dos errores porque seria un error para la vista
            if(isset($_GET['success']) && isset($_GET['error'])) {
                //Error

            }else if(isset($_GET['success'])) {   // validamos si existe el getSuccess para mostrar los mensajes
                // llamamos a handleSuccess que nos permitira manejar los mensajes de exito
                $this->handleSuccess();
            }else if(isset($_GET['error'])){ 
                // llamamos a handleError que nos permitira manejar los mensajes de error
                $this->handleError();
            }
           
        }

        // funcion para maneejar los mensajes de exito
        private function handleSuccess() { 

            // recuperamos el hash de la URL
            $hash = $_GET['success'];
            // creamos un nuevo success
            $success = new SuccessMessages();


            // validamos si existe el hash que viene de la url
            if($success->existsKey($hash)) {
                // $this->d son los datos que vamos a mostrar 
                $this->d['success'] = $success->getSuccess($hash);
            }
        }
    
        // function para manejar los mensajes de error 
        private function handleError() { 

            // recuperamos el hash de la URL
            $hash = $_GET['error'];
            // creamos un nuevo error
            $error = new ErrorsMessages();


            // validamos si existe el hash que viene de la url
            if($error->existsKey($hash)) {
                // $this->d son los datos que vamos a mostrar 
                $this->d['error'] = $error->getError($hash);
            }
        }

        // esta funcion nos permitira mostrar los mensajes en la interfaz
        public function showMessages() { 

            $this->showErrors();
            $this->showSuccess();
        }
        // funcion para mostrar los errores
        public function showErrors() { 

            // validamos si existe la clave de error
            if(array_key_exists('error', $this->d)) { 
                // Si existe imprimos el mensaje en el DOM
                echo '<div class="error">'.$this->d['error'].'</div>';
            }
        }

        // funcion para mostrar los success
        public function showSuccess() { 
            // validamos si existe la clave de success
            if(array_key_exists('success', $this->d)) { 
                // Si existe imprimos el mensaje en el DOM
                echo '<div class="success">'.$this->d['success'].'</div>';
            }
        }




    
    }
?>