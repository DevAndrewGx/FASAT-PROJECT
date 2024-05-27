<?php

    // Esta clase nos va servir como base para extenderla a todos los controladores
    // Esta clase va cargar el model y la vista que necesitemos presentar

    class Controller {

        protected $view;
        protected $model;

        function __construct() {
            // este atributo nos va permitir que vista poder cargar
            $this->view = new View();
        }


        // esta funcion se va encargar de cargar el archivo del modelo del controlador asociado al mismo
        function loadModel($model) {
            // construimos una URL para el nombre del modelo
            $url = 'models/'.$model.'model.php';

            // validamos que exista el archivo

            if(file_exists($url)) {
                // si existe llamamos el archivo como tal y inicializamos un nuevo objeto
                require_once($url);

                // almacenamos el nombre del modelo en una variable
                // lo concatenamos con Model porque las clases de los modelos se van a llamar model+Model.php
                $modelName = $model.'Model';

                $this->model = new $modelName();
            }
        }


        // creamos una funcion para verificar si existen parametros enviados a travez de los formularios, para insertar en la base de datos

        function existPOST($params) {

            // recorreremos con un foreach los parametros para verificar si existen
            foreach($params as $param) {
                // si no existe el parametro
                if(!isset($_POST[$param])) {
                    error_log('Controller::existPOST -> No existe el parametro '.$param);
                    return;
                }
            }

            return true;
        }


        // creamos una funcion para verificar los parametros que traemos de la URL

        function existGET($params) {

            // recorreremos con un foreach los parametros para verificar si existen
            foreach($params as $param) {
                // si no existe el parametro
                if(!isset($_GET[$param])) {
                    error_log('Controller::existGET -> No existe el parametro '.$param);
                    return;
                }
            }

            return true;
        }


        // funciones para evitar escribir la sitaxis de get y post para recuperar data

        function getGet($name) {
            return $_GET[$name];
        }

        function getPost($name) {
            return $_POST[$name];
        }

        // esta funcion nos permitira redigir al usuario a otra pagina cuando se complete una accion
        function redirect($route, $mensajes) {

            $data = [];
            $params = '';

            // vamos agregar los mensajes al arreglo de data
            foreach($mensajes as $key => $mensaje) {
                // los mensajes van tener una clvae y un valor
                array_push($data, $key . '=' . $mensaje);
            }

            // delimitamos o unimos los parametros con un &
            $params = join('&', $data);

            // ?nombre=Andrey&apellido=Gomez
            if($params != '') {

                // despues del signo de interrogacion tenemos nuestros parametros
                $params = '?'.$params;
            }

            // utilizamos header para redirigir al usuario a la pagina que esta especificando
            header('Location: '. constant('URL') . $route . $params);
        }
    }

?>