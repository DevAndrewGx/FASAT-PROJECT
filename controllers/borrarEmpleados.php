<?php
    require_once("../models/Conexion.php");
    require_once("../models/Consultas.php");

 
    $response = [
        'success' => false,
        'message' => ''
    ];

    $data = json_decode(file_get_contents("php://input"), true);
    
    if(isset($data['id_usuario'])) {
        $id = $data['id_usuario'];
        $objConsulta = new Consultas();
        $consulta = $objConsulta -> borrarEmpleado($id);

        if($consulta) {
            $response['success'] = true;
        }else {
            $response['message'] = 'Ocurrió un error al borrar un usuario';
        }
    }else {
        echo "Something gone wrong";
    }

    echo json_encode($response);
    exit;
?>