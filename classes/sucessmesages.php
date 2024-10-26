<?php 

    // esta clase nos serviria para manejar los mensajes de correcto 

    class SuccessMessages { 
        //Nomencaltura para el manejo de mensajes de exito => SUCCESS+CONTROLLER+METODO+ACTION
        const SUCCESS_ADMIN_NEWDATAUSER = "c05d223cd274c7560a2f7f0f5d097f0e";

        // variable para guardar los mensajes de exito
        private $successList = [];
        public function __construct() { 
            

            // asignamos los errores en un arreglo de clave valor
            $this->successList = [
                // llamamos la constante atravez de la clase
                SuccessMessages::SUCCESS_ADMIN_NEWDATAUSER => "El usuario fue creado exitosamente!"
            ];
        }


         // funcion para devolver la clave del error
        public function getSuccess($hash) { 
            return $this->successList[$hash];
        }


        // funcion para validar si existe la key
        public function existeLlave($key) { 

            // buscamos si la llave existe en el arreglo
            if(array_key_exists($key, $this->successList)) { 
                return true;
            }
            return false;
        }
    }
?>