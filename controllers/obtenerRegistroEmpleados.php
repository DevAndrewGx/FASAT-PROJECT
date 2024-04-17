<?php
    require_once("../models/Conexion.php");
    require_once("../models/Consultas.php");

    // creamos un arregloasoc para enviar la respuesta al cliente de nuevo
    $response = [
        'success' => false,
        'message' => ''
    ];

  
    
    if(isset($_POST['id_usuario'])) {
        $id = $_POST['id_usuario'];

        $objConsultas = new Consultas();
        $consulta = $objConsultas -> obtenerEmpleados($id);

        echo json_encode($consulta);
        // if($consulta) { 
        //     $response['success'] = true;

            
        // }else { 
        //     $response["message"] = "No fue posible ejecutar la query";
        // }
    }else {
        $response["message"] = "Idusuario no encontrado";
    }

    
?>