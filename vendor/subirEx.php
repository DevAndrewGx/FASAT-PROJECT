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
        $imgDir = '/public/imgs/uploads/';
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true); // Crea el directorio si no existe
        }

        // Nombre de la imagen predeterminada
        $defaultImageName = 'usuarioPredeterminado.jpg'; // Cambia esto al nombre de tu imagen predeterminada

        // Mapeo de roles y estados
        $roles = [
            'admistrador' => 1,
            'mesero' => 2,
            'cheff' => 3,
            'cajero' => 3
        ];

        $estados = [
            'activo' => 1,
            'inactivo' => 2,
            'pendiente' => 3
        ];

        foreach ($data as $row) {
            // Mapea el rol y estado
            $row[0] = isset($roles[strtolower($row[0])]) ? $roles[strtolower($row[0])] : null;
            $row[1] = isset($estados[strtolower($row[1])]) ? $estados[strtolower($row[1])] : null;

            // Asigna la fecha actual si está vacía
            $row[8] = $row[8] ?: date('Y-m-d H:i:s');

            // Inicializa el nombre de la imagen
            $imageName = null;

            // Verifica si hay una imagen especificada en el Excel (columna id_foto)
            if (!empty($row[9])) {
                $sourceImagePath = $row[9]; // Ruta de la imagen desde el Excel
                // Verifica si la imagen existe
                if (file_exists($sourceImagePath)) {
                    $ext = pathinfo($sourceImagePath, PATHINFO_EXTENSION); // Obtiene la extensión
                    $newImageName = uniqid() . '.' . $ext; // Genera un nuevo nombre de archivo único
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
                    $response['message'] = 'No se encontró la imagen en la ruta: ' . $sourceImagePath;
                    // Usa la imagen predeterminada si no se encuentra la imagen
                    $imageName = $defaultImageName;
                }
            } else {
                // Usa la imagen predeterminada si no se especificó ninguna imagen
                $imageName = $defaultImageName;
            }

            // Reemplaza los valores vacíos con NULL, excepto para id_foto, token_password, password_request
            $row = array_map(function($value, $index) {
                return empty($value) && !in_array($index, [9, 10, 11]) ? null : $value;
            }, $row, array_keys($row));

            // Inserta la imagen en la base de datos
            $stmt = $conexion->prepare("INSERT INTO `fotos`(`foto`, `tipo`) VALUES (?, 'usuarios')");
            $stmt->execute([$imageName]);
            $idFoto = $conexion->lastInsertId(); // Obtiene el ID de la imagen insertada

            // Inserta el registro en la tabla `usuarios` con el ID de la imagen
            $sql = "INSERT INTO `usuarios` 
                    (`id_rol`, `id_estado`, `documento`, `nombres`, `apellidos`, `telefono`, `correo`, `password`, `fecha_de_creacion`, `id_foto`, `token_password`, `password_request`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $idFoto, $row[10], $row[11]
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
