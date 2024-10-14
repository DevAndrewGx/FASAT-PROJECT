<?php

    // Configuramos para mostrar todos los errores en la APP
    error_reporting(E_ALL);

    ini_set('ignore_repeated_errors', TRUE);

    ini_set('display_errors',FALSE);

    ini_set('log_errors', TRUE);

    // Para evitar imprimir echos o vardumps, utilizamos un archivo de errores para mejor vision de errores
    ini_set("error_log", "C:/xampp/htdocs/FAST-PROJECT/php-error.log");
    error_log('Inicializando la aplicacion...');

     // En libs vamos a tener nuestros archivos base para que funcione nuestra aplicacion
    // requerimos  nuestras otras depencias
    require_once('libs/database.php');
    require_once('classes/erroresmessages.php');
    require_once('classes/sucessmesages.php');
    require_once('libs/controller.php');
    require_once('libs/model.php');
    require_once('libs/view.php');

    require_once('libs/app.php');

    
    require_once 'classes/session.php';
    require_once('classes/sessionController.php');


    require_once('config/config.php');

    include_once 'models/usersmodel.php';
    include_once 'models/fotomodel.php';
    include_once 'models/loginmodel.php';
    include_once 'models/joinUserRolModel.php';
    include_once 'models/joinUserRelationsModel.php';
    include_once 'models/emailmodel.php';
    include_once 'models/productosmodel.php';
    include_once 'models/categoriasmodel.php';
    include_once 'models/stockmodel.php';
    include_once 'models/mesasmodel.php';
    

    // MAILER para enviar correo
    require_once 'classes/Mailer.php';
    require_once 'config/config.php';
    require 'PHPMailer-6.9.1/src/PHPMailer.php';
    require 'PHPMailer-6.9.1/src/SMTP.php';
    require 'PHPMailer-6.9.1/src/Exception.php';

    // Esto va hacer que automaticamente se ejecute el contructor y empieze a hacer las validaciones
    $app = new App();   
?>