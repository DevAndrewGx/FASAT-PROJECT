<?php
class Conexion
{
    function getConexion()
    {

        // creamos variables
        $user = "root";
        $password = "";
        $host = "localhost";
        $db = "proyecto";

        // Cramos un objeto conexino PDO

        $conexion = new PDO("mysql:host=$host;dbname=$db;", $user, $password);

        // retornamos la conexion
        return $conexion;
    }
}
