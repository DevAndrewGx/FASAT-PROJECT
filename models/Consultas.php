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
        $fila = $consulta->fetch();

        if ($fila) {

            echo '<script>alert("Ya existe un usuario en el sistema con este correo o documento")</script>';
            echo "<script>location.href='../views/html/admin/crearEmpleado.php'</script>";
        } else {

            $sql1 = 'INSERT INTO usuarios (documento, rol, estado, tipo_documento, nombres, apellidos, telefono, direccion, correo, password, foto) VALUES (:documento, :rol, :estado, :tipo_documento, :nombres, :apellidos, :telefono, :direccion, :correo, :password, :foto)';
            $sql2 = 'INSERT INTO horarios(hora_entrada, hora_salida, id_usuario) VALUES(:entrada, :salida, :id_usuario)';

            $consulta1 = $conexion->prepare($sql1);
            $consulta2 = $conexion->prepare($sql2);

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

            $consulta2->bindParam(':entrada', $desdeHorario);
            $consulta2->bindParam(':salida', $hastaHorario);

            // TENEMOS QUE RETORNAR TRUE PARA QUE APAREZCA LA ALERTA DEPENDIENDO SI SE INSERTO LOS DATOS EN LA BASE
            if ($consulta1->execute()) {
                $id_usuario_insertado = $conexion->lastInsertId();
                $consulta2->bindParam(':id_usuario', $id_usuario_insertado);

                if ($consulta2->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


    public function cargarDatosEmpleados($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName)
    {

        // Crear objeto de conexión
        $objConexion = new Conexion();
        $conexion = $objConexion->getConexion();

        $sql = "SELECT id_usuario, documento, rol, estado, tipo_documento, nombres, apellidos, telefono, direccion, correo, foto, fecha_de_creacion FROM usuarios";


        if (!empty($busqueda)) {

            $searchValue = $busqueda;
            $sql .= " WHERE nombres LIKE '%$searchValue%' ";
            $sql .= " OR apellidos LIKE '%$searchValue%' ";
            $sql .= " OR telefono LIKE '%$searchValue%' ";
            $sql .= " OR direccion LIKE '%$searchValue%' ";
            $sql .= " OR documento LIKE '%$searchValue%' ";
            $sql .= " OR correo LIKE '%$searchValue%' ";
            $sql .= " OR rol LIKE '%$searchValue%' ";
            $sql .= " OR tipo_documento LIKE '%$searchValue%' ";
            $sql .= " OR estado LIKE '%$searchValue%' ";
            $sql .= " OR fecha_de_creacion LIKE '%$searchValue%' ";
        }


        if ($columna != null && $orden != null ) {
            
            $sql .= " ORDER BY $columnName $orden";
        } else {
            $sql .= " ORDER BY id_usuario DESC";
        }

        if ($registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null) {
            $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
        }

        $consulta = $conexion->prepare($sql);
        $consulta->execute();

        $data = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function totalRegistros()
    {
        $objConexion = new Conexion();
        $conexion = $objConexion->getConexion();

        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM usuarios");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        $objConexion = new Conexion();
        $conexion = $objConexion->getConexion();

        $sql = "SELECT COUNT(*) as total FROM usuarios";

        if (!empty($busqueda)) {
            $searchValue = $busqueda;
            $sql .= " WHERE nombres LIKE '%$searchValue%' ";
            $sql .= " OR apellidos LIKE '%$searchValue%' ";
            $sql .= " OR telefono LIKE '%$searchValue%' ";
            $sql .= " OR direccion LIKE '%$searchValue%' ";
            $sql .= " OR documento LIKE '%$searchValue%' ";
            $sql .= " OR correo LIKE '%$searchValue%' ";
            $sql .= " OR rol LIKE '%$searchValue%' ";
            $sql .= " OR tipo_documento LIKE '%$searchValue%' ";
            $sql .= " OR estado LIKE '%$searchValue%' ";
            $sql .= " OR fecha_de_creacion LIKE '%$searchValue%' ";
        }

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function borrarEmpleado($id) { 
        
        $objConexion = new Conexion();
        $conexion = $objConexion -> getConexion();

        $sql1 = "DELETE FROM usuarios WHERE id_usuario = :id";
        $sql2 = "DELETE FROM horarios WHERE id_usuario = :id";

        $consulta1 = $conexion -> prepare($sql1);
        $consulta1->bindParam(":id", $id);
        

        $consulta2 = $conexion->prepare($sql2);
        $consulta2->bindParam(":id", $id);

        // EJECUTAMOS PRIMERO LA CONSULTA2 PARA BORRAR PRIMERO EN HORARIO Y DESPUES EN USUARIOS
        if($consulta2 ->execute()) {
            $consulta1->execute();
            return true; 
        }else {
            return false;
        }   
    }


    public function actualizarEmpleados($id_usuario, $nombres, $tipo_documento, $documento, $correo, $apellidos, $rol, $telefono, $direccion, $hora_entrada, $hora_salida, $password, $fotoMovida, $estado) {
        $objConexion = new Conexion();
        $conexion = $objConexion->getConexion();

        $sql1 ="UPDATE usuarios SET documento = :documento, rol = :rol, estado = :estado, tipo_documento = :tipo_documento, nombres = :nombres, apellidos = :apellidos, telefono = :telefono, direccion = :direccion, correo = :correo, password = :password, foto = :foto WHERE id_usuario = :id_usuario";


        $sql2 = "UPDATE horarios SET hora_entrada = :hora_entrada, hora_salida = :hora_salida WHERE id_usuario = :id_usuario";

        $consulta1 = $conexion -> prepare($sql1);
        $consulta2 = $conexion->prepare($sql2);
    
        $consulta1->bindParam(":id_usuario", $id_usuario);
        $consulta1->bindParam(":documento", $documento);
        $consulta1->bindParam(":rol", $rol);
        $consulta1->bindParam(":estado", $estado);
        $consulta1->bindParam(":tipo_documento", $tipo_documento);
        $consulta1->bindParam(":nombres", $nombres);
        $consulta1->bindParam(":apellidos", $apellidos);
        $consulta1->bindParam(":telefono", $telefono);
        $consulta1->bindParam(":direccion", $direccion);
        $consulta1->bindParam(":correo", $correo);
        $consulta1->bindParam(':password', $password);
        $consulta1->bindParam(":foto", $fotoMovida);

        $consulta2->bindParam(":id_usuario", $id_usuario);
        $consulta2->bindParam(":hora_entrada", $hora_entrada);
        $consulta2->bindParam(":hora_salida", $hora_salida);
       
        // primero actualizamos la segunda y despues la primera para la depencia de las tablas
        if($consulta2->execute()) {
            $consulta1->execute();
            return true;
        }else { 
            return false; 
        }
    }

    public function obtenerEmpleados($id)
    {
        $f = []; // Inicializar como un array vacío

        try {
            $objConexion = new Conexion();
            $conexion = $objConexion->getConexion();

            $sql = "SELECT * FROM usuarios JOIN horarios ON usuarios.id_usuario = horarios.id_usuario WHERE usuarios.id_usuario = :id_usuario";

            // Depuración: Imprimir la consulta SQL
            // echo "Consulta SQL: " . $sql . "<br>";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":id_usuario", $id);

            $consulta->execute(); // Ejecutar la consulta

            while ($data = $consulta->fetch()) {
                $f[] = $data;
            }

            $conexion = null; // Cerrar la conexión

        } catch (Exception $e) {
            // Lanzar la excepción para manejarla en el código que llama a este método
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }

        // Depuración: Imprimir el resultado de la consulta
        // echo "Resultados: ";
        // print_r($f);
        // echo "<br>";

        return $f;
    }

}
