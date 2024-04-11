<?php
require_once("../models/Conexion.php");
require_once("../models/Consultas.php");


$nombres = $_POST['nombres'];
$tipoDocumento = $_POST['tipoDocumento'];
$documento = $_POST['documento'];
$email = $_POST['email'];
$apellidos = $_POST['apellidos'];
$rol = $_POST['rol'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$desdeHorario = $_POST['desdeHorario'];
$hastaHorario = $_POST['hastaHorario'];
$password = $_POST['password'];
$verificarPassword = $_POST['validarPassword'];
$estado = "Activo";


if (strlen($nombres) > 0 && strlen($tipoDocumento) > 0 && strlen($documento) > 0 && strlen($email) > 0 && strlen($apellidos) > 0 && strlen($rol) > 0 && strlen($telefono) > 0 && strlen($direccion) > 0 && strlen($desdeHorario) > 0 && strlen($hastaHorario) > 0 && strlen($password) > 0 && strlen($verificarPassword) > 0 && strlen($estado) > 0) {


    $foto = $_FILES['foto']['name'];
    if (strlen($foto) > 0) {

        $fotoMovida = '../../Uploads/Usuario/' . $_FILES['foto']['name'];
        // MOVEMOS EL ARCHIVO A LA CARPETA UPLOADS CON LA FUNCIÓN DE PHP move_uploaded_file()
        // tmp_name: NOMBRE TEMPORAL DEL ARCHIVO
        $mover = move_uploaded_file($_FILES['foto']['tmp_name'], '../views/uploads/' . $foto . '');
    }
    if ($verificarPassword == $password) {
        $objConsultas = new Consultas();
        $result = $objConsultas->registrarEmpleado($nombres, $tipoDocumento, $documento, $email, $apellidos, $rol, $telefono, $direccion, $desdeHorario, $hastaHorario, $password, $fotoMovida, $estado);
    } else {
        echo '<script>alert("Las claves no coinciden intentalo nuevamente")</script>';
        echo '<script>location.href="../views/html/admin/crearEmpleado.php"</script>';
    }
} else {

    echo '<script>alert("Por favor complete todos los campos")</script>';
    echo '<script>location.href="../views/html/admin/crearEmpleado.php"</script>';
}
