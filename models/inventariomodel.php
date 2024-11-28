<?php
require_once '../libs/imodel.php';
require_once 'Conexion.php';

class InventarioModel extends Conexion implements IModel
{
    private $productos = [];

    public function crear()
    {
        // Implementación de inserción de producto (pendiente)
    }

    public function consultarTodos()
    {
        try {
            // Consulta adaptada a la tabla `productos_inventario`
            $sql = "SELECT 
                        id_pinventario AS id, 
                        nombre, 
                        precio, 
                        descripcion, 
                        estado 
                    FROM productos_inventario";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $this->productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($this->productos)) {
                error_log("InventarioModel::consultarTodos -> No se encontraron registros en productos_inventario.");
            }

            return $this->productos;
        } catch (PDOException $e) {
            error_log("InventarioModel::consultarTodos -> Error en la consulta: " . $e->getMessage());
            return [];
        }
    }

    public function consultar($id)
    {
        try {
            $sql = "SELECT 
                        id_pinventario AS id, 
                        nombre, 
                        precio, 
                        descripcion, 
                        estado 
                    FROM productos_inventario 
                    WHERE id_pinventario = :id";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("InventarioModel::consultar -> Error en la consulta: " . $e->getMessage());
            return null;
        }
    }

    public function borrar($id)
    {
        try {
            $sql = "DELETE FROM productos_inventario WHERE id_pinventario = :id";
            $stmt = $this->getConnection()->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("InventarioModel::borrar -> Error: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar($id)
    {
        // Implementación de actualización de producto (pendiente)
    }

    public function asignarDatosArray($array)
    {
        $this->productos = $array;
    }

    public function interpretarEstado($estado)
    {
        switch ($estado) {
            case 1:
                return 'Disponible';
            case 0:
                return 'No disponible';
            default:
                return 'Desconocido';
        }
    }
}
