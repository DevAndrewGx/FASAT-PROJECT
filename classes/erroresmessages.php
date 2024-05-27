<?php

    // esta clase nos serviria para manejar los mensajes de error

    class ErrorsMessages {
        //Nomencaltura para el manejo de errores => ERROR+CONTROLLER+METODO+ACTION
        const ERROR_ADMIN_NEWCATEGORY_EXISTS = "3d25dd12e0a6eb0f375328f8dd9621ab";

        // variable para guardar los errores
        private $errorList = [];
        public function __construct() {

            // asignamos los errores en un arreglo de clave valor
            $this->errorList = [
                // llamamos la constante atravez de la clase
                ErrorsMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS => "El nombre de la categoria ya existe"
            ];
        }

        // funcion para devolver la llave del error
        public function getError($hash) { 
            return $this->errorList[$hash];
        }


        // funcion para validar si existe la key
        public function existsKey($key) { 

            // buscamos si la llave existe en el arreglo
            if(array_key_exists($key, $this->errorList)) { 
                return true;
            }
            return false;
        }
    }
?>