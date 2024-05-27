<?php 

    // esta clase nos serviria para manejar los mensajes de correcto 

    class SuccessMessages { 
        //Nomencaltura para el manejo de mensajes de exito => SUCCESS+CONTROLLER+METODO+ACTION
        const SUCCESS_ADMIN_NEWCATEGORY_EXISTS = "3d25dd12e0a6eb0f375328f8dd9621ab";

        // variable para guardar los mensajes de exito
        private $successList = [];
        public function __construct() { 
            

            // asignamos los errores en un arreglo de clave valor
            $this->successList = [
                // llamamos la constante atravez de la clase
                SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY_EXISTS => "El nombre de la categoria ya existe"
            ];
        }


         // funcion para devolver la clave del error
        public function getSuccess($hash) { 
            return $this->successList[$hash];
        }


        // funcion para validar si existe la key
        public function existsKey($key) { 

            // buscamos si la llave existe en el arreglo
            if(array_key_exists($key, $this->successList)) { 
                return true;
            }
            return false;
        }
    }
?>