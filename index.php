<?php

    // Configuramos para mostrar todos los errores en la APP
    error_reporting(E_ALL);

    ini_set('ignore_repeated_errors', TRUE);

    ini_set('display_errors',FALSE);

    ini_set('log_errors', TRUE);

    // Para evitar imprimir echos o vardumps, utilizamos un archivo de errores para mejor vision de errores
    ini_set("error_log", "C:/xampp/htdocs/FASTPROJECT/php-error.log");
    error_log('Testing errors');

     // En libs vamos a tener nuestros archivos base para que funcione nuestra aplicacion
    // requerimos  nuestras otras depencias
    require_once('libs/database.php');
    require_once('classes/erroresmessages.php');
    require_once('classes/sucessmesages.php');
    require_once('classes/clienteFunciones.php');
    require_once('libs/controller.php');
    require_once('libs/model.php');
    require_once('libs/view.php');

    require_once('libs/app.php');

    
    require_once 'classes/session.php';
    require_once('classes/sessionController.php');


    require_once('config/config.php');

    include_once 'models/usersmodel.php';
    include_once 'models/fotomodel.php';
    include_once 'models/joinUserRolModel.php';
    include_once 'models/joinUserRelationsModel.php';
    

    // Esto va hacer que automaticamente se ejecute el contructor y empieze a hacer las validaciones
    $app = new App();   
?>