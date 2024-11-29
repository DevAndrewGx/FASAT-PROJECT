<?php
        $user = "root";
        $pass = "";
        $host = "localhost";
        $db = "test_fast9";
        $charset = 'utf8';  // Añadido punto y coma
        // creamos variables
        try{
            // Creamos un objeto conexión PDO  // Corregido el comentario
            $conexion = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);  // Añadido charset al DSN
            $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("conexion fallida: " .$e->getMessage());
        }
    
?>
