<?php

    require_once("../models/Conexion.php");
    require_once("../models/Consultas.php");

    // creamos un arregloasoc para enviar la respuesta al cliente de nuevo
    $response = [
        'success' => false,
        'message' => ''
    ];

    $id_usuario = $_POST['id_usuario'];
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
    $verificarPassword = $_POST['verificarPassword'];
    $foto = $_FILES['foto']['name'];
    $estado = "Activo";

    if (strlen($nombres) > 0 && strlen($tipoDocumento) > 0 && strlen($documento) > 0 && strlen($email) > 0 && strlen($apellidos) > 0 && strlen($rol) > 0 && strlen($telefono) > 0 && strlen($direccion) > 0 && strlen($desdeHorario) > 0 && strlen($hastaHorario) > 0 && strlen($password) > 0 && strlen($verificarPassword) > 0 && strlen($estado) > 0) {

       
        if ($foto) {
            $fotoMovida = '../../uploads/' . $_FILES['foto']['name'];
            $mover = move_uploaded_file($_FILES['foto']['tmp_name'], '../views/uploads/' . $foto . '');
        }

        if ($verificarPassword == $password) {
            $objConsultas = new Consultas();
            $result = $objConsultas->actualizarEmpleados($id_usuario, $nombres, $tipoDocumento, $documento, $email, $apellidos, $rol, $telefono, $direccion, $desdeHorario, $hastaHorario, $password, $fotoMovida, $estado);
            
            
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'El usuario ha sido actualizado exitosamente';
            } else {
                $response['message'] = 'Ocurrió un error al registrar el usuario';
            }
        } else {
            $response['message'] = 'Las claves no coinciden intentalo nuevamente';
        }
    } else {
        $response['message'] = 'Por favor complete todos los campos';
    }

    echo json_encode($response);
?>