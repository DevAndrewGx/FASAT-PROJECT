<?php
require 'conexion.php';
require 'autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['success' => false, 'message' => ''];

if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['excelFile']['tmp_name'];

    try {
        // Carga el archivo Excel
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        $header = array_shift($data); // Extraer el encabezado

        // Verificar que hay datos en el archivo
        if (empty($data)) {
            throw new Exception("El archivo está vacío.");
        }

        foreach ($data as $row) {
            // Reemplaza los valores vacíos con NULL
            $row = array_map(function ($value) {
                return empty($value) ? null : trim($value);
            }, $row);

            // 1. Verificar y obtener ID Foto
            $id_foto = null;
            if (!empty($row[0])) { // ID Foto
                $stmt = $conexion->prepare("SELECT id_foto FROM fotos WHERE id_foto = ?");
                $stmt->execute([$row[0]]);
                $id_foto = $stmt->fetchColumn();
                if (!$id_foto) {
                    // Insertar foto predeterminada si no existe
                    $stmt = $conexion->prepare("INSERT INTO fotos (foto, tipo) VALUES (?, 'productos')");
                    $stmt->execute(['usuarioPredeterminado.jpg']);
                    $id_foto = $conexion->lastInsertId();
                }
            }

            // 2. Verificar y obtener ID Categoría
            $id_categoria = null;
            if (!empty($row[1])) { // ID Categoría
                $stmt = $conexion->prepare("SELECT id_categoria FROM categorias WHERE nombre_categoria = ?");
                $stmt->execute([$row[1]]);
                $id_categoria = $stmt->fetchColumn();
                if (!$id_categoria) {
                    // Si no existe, insertar nueva categoría
                    $stmt = $conexion->prepare("INSERT INTO categorias (nombre_categoria, tipo_categoria) VALUES (?, 'General')");
                    $stmt->execute([$row[1]]);
                    $id_categoria = $conexion->lastInsertId();
                }
            }

            // 3. Verificar y obtener ID Subcategoría
            $id_subcategoria = null;
            if (!empty($row[2])) { // ID Subcategoría
                $stmt = $conexion->prepare("SELECT id_sub_categoria FROM sub_categorias WHERE nombre_subcategoria = ?");
                $stmt->execute([$row[2]]);
                $id_subcategoria = $stmt->fetchColumn();
                if (!$id_subcategoria) {
                    // Si no existe, insertar nueva subcategoría
                    $stmt = $conexion->prepare("INSERT INTO sub_categorias (nombre_subcategoria, id_categoria) VALUES (?, ?)");
                    $stmt->execute([$row[2], $id_categoria]);
                    $id_subcategoria = $conexion->lastInsertId();
                }
            }

            // 4. Verificar y obtener ID Stock
            $id_stock = null;
            if (!empty($row[3])) { // ID Stock
                $stmt = $conexion->prepare("SELECT id_stock FROM stock_inventario WHERE id_stock = ?");
                $stmt->execute([$row[3]]);
                $id_stock = $stmt->fetchColumn();
                if (!$id_stock) {
                    // Si no existe, insertar nuevo stock
                    $stmt = $conexion->prepare("INSERT INTO stock_inventario (cantidad, cantidad_minima, cantidad_disponible) VALUES (?, ?, ?)");
                    $stmt->execute([0, 0, 0]); // Insertamos stock con 0 valores
                    $id_stock = $conexion->lastInsertId();
                }
            }

            // 5. Verificar Estado
            $estado = null;
            if (!empty($row[7])) { // Estado
                $estados = ['activo' => 1, 'inactivo' => 2, 'pendiente' => 3];
                $estado = $estados[strtolower($row[7])] ?? null;
                if ($estado === null) {
                    throw new Exception("Estado inválido en la fila con nombre: {$row[6]}.");
                }
            }

            // 6. Validación de otros campos
            if (empty($row[4])) {
                throw new Exception("El nombre del producto es obligatorio en la fila.");
            }

            // 7. Verificar si el producto ya existe en el inventario
            $stmt = $conexion->prepare("SELECT id_pinventario FROM productos_inventario WHERE nombre = ?");
            $stmt->execute([$row[4]]);
            $idProductoExistente = $stmt->fetchColumn();

            if ($idProductoExistente) {
                // Si el producto existe, lo actualizamos
                $stmt = $conexion->prepare("UPDATE productos_inventario SET id_foto = ?, id_categoria = ?, id_subcategoria = ?, id_stock = ?, precio = ?, descripcion = ?, estado = ? WHERE id_pinventario = ?");
                $stmt->execute([
                    $id_foto,
                    $id_categoria,
                    $id_subcategoria,
                    $id_stock,
                    $row[5],  // Precio
                    $row[6],  // Descripción
                    $estado,
                    $idProductoExistente
                ]);
            } else {
                // Si el producto no existe, lo creamos
                $stmt = $conexion->prepare("INSERT INTO productos_inventario (id_foto, id_categoria, id_subcategoria, id_stock, nombre, precio, descripcion, estado) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $id_foto,
                    $id_categoria,
                    $id_subcategoria,
                    $id_stock,
                    $row[4],  // Nombre
                    $row[5],  // Precio
                    $row[6],  // Descripción
                    $estado
                ]);
            }
        }

        $response['success'] = true;
        $response['message'] = 'Datos subidos correctamente.';
    } catch (Exception $e) {
        $response['message'] = 'Error en el procesamiento del archivo: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Error en la subida del archivo.';
}

echo json_encode($response);
