<?php

    // esta clase nos serviria para manejar los mensajes de error

    class ErrorsMessages {
        //Nomencaltura para el manejo de errores => ERROR+CONTROLLER+METODO+ACTION
        const ERROR_ADMIN_NEWDATAUSER_EMPTY = "3d25dd12e0a6eb0f375328f8dd9621ab";
        const ERROR_ADMIN_NEWDATAUSER = "898d670983c24831af06d155120c068d";
        const ERROR_ADMIN_NEWDATAUSER_PHOTO = '2d55fd10e1a8ea0x415321t9vb9621kp'; 
        const ERROR_LOGIN_AUTHENTICATE_EMPTY = "9d35fd12e1a6ex0f375321f8eb9621xb"; 
        const ERROR_LOGIN_AUTHENTICATE_DATA = "6d25fd10e1a6ea0f315321f8vb9621eb";
        const ERROR_LOGIN_AUTHENTICATE = "7d25jd12e1r6eh0f315321f8tb8621ub";

        // variable para guardar los errores
        private $errorList = [];
        public function __construct() {

            // asignamos los errores en un arreglo de clave valor
            $this->errorList = [
                // llamamos la constante atravez de la clase
                ErrorsMessages::ERROR_ADMIN_NEWDATAUSER_EMPTY => "Todos los campos son necesarios",
                ErrorsMessages::ERROR_ADMIN_NEWDATAUSER => "Hubo un problema al agregar usuario, intentalo nuevamente",
                ErrorsMessages::ERROR_ADMIN_NEWDATAUSER_PHOTO => "No se guardo la foto correctamente code: 500",

                ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY => "Llena los campos de usuario y password",
                ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_DATA => "Usuario o contraseña incorrectos",
                ErrorsMessages::ERROR_LOGIN_AUTHENTICATE => "No se puede procesar la solicitud. Ingresa usuario y password"
                
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