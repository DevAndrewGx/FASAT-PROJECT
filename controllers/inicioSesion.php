<?php

//  require_once() para enlazar las dependencias necesarias
require_once("../models/Conexion.php");
require_once("../models/Sesion.php");

// Aterrizamos en variables los datos ingresados por el usuario, los cuales viajan a traves del metodo POST y los name de los campos
$usuario = $_POST['user'];
$claveMd = $_POST['password'];

if (strlen($usuario) > 0 && strlen($claveMd) > 0) {

    $objConsultas = new Sesion();
    $result = $objConsultas->validarSesion($usuario, $claveMd);
} else {

    echo '<script>alert("Por favor, complete todos los campos")</script>';
    echo '<script>location.href="../views/sign-up/login.php"</script>';
}
