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
        $header = array_shift($data); // Extrae el encabezado

        // Configura el directorio para las imágenes
        $imgDir = 'public/imgs/uploads/f38de4b1f5f606c3a714062b870d9cf3.png';
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true); // Crea el directorio si no existe
        }

        // Nombre de la imagen predeterminada
        $defaultImageName = 'usuarioPredeterminado.jpg'; // Cambia esto al nombre de tu imagen predeterminada

        foreach ($data as $row) {
            // Asigna un nombre único a la imagen si la columna id_foto está presente
            $imageName = null;

            // Verifica si hay una imagen especificada en el Excel (columna id_foto)
            if (!empty($row[0])) { // Suponiendo que la columna id_foto es la primera columna
                $sourceImagePath = $row[0]; // Ruta de la imagen desde el Excel
                // Verifica si la imagen existe
                if (file_exists($sourceImagePath)) {
                    $ext = pathinfo($sourceImagePath, PATHINFO_EXTENSION); // Obtiene la extensión
                    $newImageName = uniqid('img_') . '.' . $ext; // Genera un nuevo nombre de archivo único
                    $destinationPath = $imgDir . $newImageName;

                    // Copia la imagen a la carpeta de destino
                    if (copy($sourceImagePath, $destinationPath)) {
                        $imageName = $newImageName; // Actualiza el nombre de la imagen para la base de datos
                    } else {
                        $response['message'] = 'No se pudo copiar la imagen desde: ' . $sourceImagePath;
                        echo json_encode($response);
                        exit();
                    }
                } else {
                    $imageName = $defaultImageName; // Usa la imagen predeterminada si no se encuentra
                }
            } else {
                $imageName = $defaultImageName; // Usa la imagen predeterminada si no se especificó
            }

            // Validación de datos
            $errors = [];
            if (empty($row[1])) {
                $errors[] = 'El ID de categoría es obligatorio.';
            }
            if (empty($row[2])) {
                $errors[] = 'El ID de subcategoría es obligatorio.';
            }
            if (empty($row[3])) {
                $errors[] = 'El stock es obligatorio.';
            }
            if (empty($row[4])) {
                $errors[] = 'El ID de proveedor es obligatorio.';
            }
            if (empty($row[5])) {
                $errors[] = 'El nombre es obligatorio.';
            }
            if (empty($row[6])) {
                $errors[] = 'El precio es obligatorio.';
            }
            if (empty($row[7])) {
                $errors[] = 'La descripción es obligatoria.';
            }
            if (empty($row[8])) {
                $errors[] = 'El estado es obligatorio.';
            }

            if (!empty($errors)) {
                $response['message'] = implode(' ', $errors);
                echo json_encode($response);
                exit();
            }

            // Reemplaza los valores vacíos con NULL, excepto para la imagen
            $row = array_map(function($value, $index) {
                return empty($value) && $index !== 0 ? null : $value; // Excluye id_foto (índice 0)
            }, $row, array_keys($row));

            // Inserta la imagen en la base de datos
            $stmt = $conexion->prepare("INSERT INTO `fotos`(`foto`, `tipo`) VALUES (?, 'productos')");
            $stmt->execute([$imageName]);
            $idFoto = $conexion->lastInsertId(); // Obtiene el ID de la imagen insertada

            // Inserta el producto en la tabla `productos` con el ID de la imagen
            $sql = "INSERT INTO `productos_inventario` 
                    (`id_categoria`, `id_subcategoria`, `id_stock`, `id_proveedor`, `nombre`, `precio`, `descripcion`, `estado`, `id_foto`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $idFoto
            ]);
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
?>
