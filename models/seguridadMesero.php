<?php

session_start();

if (!isset($_SESSION['autenticado'])) {
    echo '<script>alert("Por favor, inicie sesión")</script>';
    echo "<script>location.href='../../../views/sign-up/login.php'</script>";
}

if ($_SESSION['rol'] != 'Mesero') {

    echo '<script>alert("No posee los permisos para acceder a esta interfaz")</script>';
    // history.go(-1)
    echo "<script>history.go(-1)</script>";
}
