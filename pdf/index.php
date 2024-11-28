<?php
require_once 'controllers/usuarioController.php';
require_once 'controllers/inventariocontroller.php';



$controller = new UsuarioController();
$controller->generarReporte();
?>