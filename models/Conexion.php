<?php
class Conexion
{
    function getConexion()
    {
        // creamos variables
        $user = "root";
        $password = "";
        $host = "localhost";
        $db = "test_fast1";
        $charset = 'utf8';  // Añadido punto y coma

        // Creamos un objeto conexión PDO  // Corregido el comentario

        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $password);  // Añadido charset al DSN

        // retornamos la conexion
        return $conexion;
    }
}
