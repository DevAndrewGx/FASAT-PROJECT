<?php
<<<<<<< HEAD
        $user = "root";
        $pass = "";
        $host = "localhost";
        $db = "test_fast1";
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
=======
$user = "root";
$pass = "";
$host = "localhost";
$db = "fast";
$charset = 'utf8';  // Añadido punto y coma
// creamos variables
try {
    // Creamos un objeto conexión PDO  // Corregido el comentario
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);  // Añadido charset al DSN
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("conexion fallida: " . $e->getMessage());
}
>>>>>>> acdb0d98b67ca12db50e1a15ea3e9e711b497157
