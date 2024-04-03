<?php

//  require_once() para enlazar las dependencias necesarias
    require_once("../models/Conexion.php");
    require_once("../models/Sesion.php");

    $objConsultas = new Sesion();
    $consulta = $objConsultas->cerrarSesion();

?>