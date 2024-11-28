<?php
// models/UsuarioModel.php
require_once '../libs/imodel.php';
require_once 'Conexion.php';

class UsuarioModel extends Conexion implements IModel
{
    private $usuarios = [];

    public function crear()
    {
        // Implementación de inserción de usuario
    }

    public function consultarTodos()
{
    try {
        $sql = "SELECT * FROM inventario";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultados)) {
            error_log("InventarioModel::consultarTodos -> No se encontraron registros.");
        }

        return $resultados;
    } catch (PDOException $e) {
        error_log("InventarioModel::consultarTodos -> Error: " . $e->getMessage());
        return [];
    }
}

    public function consultar($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function borrar($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function actualizar($id)
    {
        // Implementación de actualización de usuario
    }

    public function asignarDatosArray($array)
    {
        $this->usuarios = $array;
    }

    public function interpretarEstado($estado)
    {
        switch ($estado) {
            case 1: return 'Activo';
            case 2: return 'Inactivo';
            default: return 'Desconocido';
        }
    }

    public function interpretarRol($rol)
    {
        switch ($rol) {
            case 1: return 'Administrador';
            case 2: return 'Mesero';
            case 3: return 'Cheff';
            case 4: return 'Cajero';
        }
    }
}
?>