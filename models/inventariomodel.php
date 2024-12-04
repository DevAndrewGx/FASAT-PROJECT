<?php
require_once '../libs/imodel.php';
require_once 'Conexion.php';

class InventarioModel extends Conexion implements IModel
{
    public $productos = []; // Cambié 'private' por 'public'

    /**
     * Crear un nuevo registro (pendiente de implementación).
     */
    public function crear()
    {
        // Implementación de inserción de producto (pendiente)
    }

    /**
     * Consultar todos los registros de la tabla.
     * 
     * @param bool $selectAll Si es true, selecciona todos los campos con `SELECT *`, si es false, selecciona campos específicos.
     * @return array Los registros obtenidos de la tabla.
     */
    public function consultarTodos($selectAll = false)
    {
        try {
            // Alternar entre consulta completa o campos específicos
            $sql = $selectAll
                ? "SELECT * FROM productos_inventario WHERE 1"
                : "SELECT 
                        id_pinventario AS id, 
                        id_foto, 
                        id_categoria, 
                        id_subcategoria, 
                        id_stock, 
                        id_proveedor, 
                        nombre, 
                        precio, 
                        descripcion, 
                        estado 
                    FROM productos_inventario WHERE 1";

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

    /**
     * Consultar un registro específico por ID.
     * 
     * @param int $id El ID del registro a consultar.
     * @return array|null El registro consultado o null si no existe.
     */
    public function consultar($id)
    {
        try {
            $sql = "SELECT 
                        id_pinventario AS id, 
                        id_foto, 
                        id_categoria, 
                        id_subcategoria, 
                        id_stock, 
                        id_proveedor, 
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

    /**
     * Borrar un registro específico por ID.
     * 
     * @param int $id El ID del registro a borrar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
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

    /**
     * Actualizar un registro específico (pendiente de implementación).
     */
    public function actualizar($id)
    {
        // Implementación de actualización de producto (pendiente)
    }

    /**
     * Asignar datos a la propiedad $productos.
     * 
     * @param array $array Los datos a asignar.
     */
    public function asignarDatosArray($array)
    {
        $this->productos = $array;
    }

    /**
     * Interpretar el estado como texto legible.
     * 
     * @param int $estado El estado del producto.
     * @return string La descripción del estado.
     */
    
}
