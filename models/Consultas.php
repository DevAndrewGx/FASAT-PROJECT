<?php
class Consultas
{

    public function registrarEmpleado($nombres, $tipoDocumento, $documento, $email, $apellidos, $rol, $telefono, $direccion, $desdeHorario, $hastaHorario, $password, $foto, $estado)
    {

        // SE CREA EL OBJETO DE LA CONEXION (Esto nunca puede faltar)
        $objConexion = new Conexion();
        $conexion = $objConexion->getConexion();

        // SELECT DE USUARIO REGISTRADO EN EL SISTEMA
        $sql = 'SELECT * FROM usuarios WHERE correo = :correo OR documento = :documento';
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':documento', $documento);
        $consulta->bindParam(':correo', $email);
        $consulta->execute();
        // fetch() para corvertir un texto separado por comas en un array. Este no existira si en la consulta no se obtuvo nada.
        $fila = $consulta->fetch();

        if ($fila) {

            echo '<script>alert("Ya existe un usuario en el sistema con este correo o documento")</script>';
            echo "<script>location.href='../Vista/html/Administrador/adminUsu.php'</script>";
        } else {

            // SE CREA LA VARIABLE QUE CONTENDRÁ LA CONSULTA A EJECUTAR EN LA TABLA usuario

            $sql1 = 'INSERT INTO usuarios (documento, rol, estado, tipo_documento, nombres, apellidos, telefono, direccion, correo, password, foto) VALUES (:documento, :rol, :estado, :tipo_documento, :nombres, :apellidos, :telefono, :direccion, :correo, :password, :foto)';

            $sql2 = 'INSERT INTO horarios(hora_entrada, hora_salida, id_usuario) VALUES(:entrada, :salida, :id_usuario)';

            // PREPARAMOS TODO LO NOCESARIO PARA EJECUTAR LA FUNCION ANTERIOR
            $consulta1 = $conexion->prepare($sql1);
            $consulta2 = $conexion->prepare($sql2);

            // CONVERTIMOS LOS ARGUMENTOS EN PARAMETROS
            $consulta1->bindParam(':documento', $documento);
            $consulta1->bindParam(':rol', $rol);
            $consulta1->bindParam(':estado', $estado);
            $consulta1->bindParam(':tipo_documento', $tipoDocumento);
            $consulta1->bindParam(':nombres', $nombres);
            $consulta1->bindParam(':apellidos', $apellidos);
            $consulta1->bindParam(':telefono', $telefono);
            $consulta1->bindParam(':direccion', $direccion);
            $consulta1->bindParam(':correo', $email);
            $consulta1->bindParam(':password', $password);
            $consulta1->bindParam(':foto', $foto);




            // EJECUTAMOS LA CONSULTA PARA RECUPERAR DESPUES EL ID DEL USUARIO PARA INSERTARLO EN LA TABLA USUARIOS
            $consulta1->execute();


            // Obtenemos el id_usuario recientemente INSERTADO
            $id_usuario_insertado = $conexion->lastInsertId();
            $consulta2->bindParam(':entrada', $desdeHorario);
            $consulta2->bindParam(':salida', $hastaHorario);
            $consulta2->bindParam(':id_usuario', $id_usuario_insertado);

            $result = $consulta2->execute();
           

            // Verificamos si la consulta fue exitosa para lanzar la alerta

            if($result) {
                // Ambas consultas fueron exitosas, enviamos una respuesta de éxito
                echo json_encode(["success" => true]);
               
                
            }else {
                // Si la inserción en la tabla de horarios falla, devuelve un mensaje de error
                echo json_encode(["success" => false, "message" => "Error al insertar horario"]);
            }
        }
    }
}
