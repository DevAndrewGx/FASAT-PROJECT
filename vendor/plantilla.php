<?php
require 'conexion.php'; // Asegúrate de que este archivo establece una conexión PDO con la base de datos
require 'autoload.php'; // Asegúrate de haber instalado PhpSpreadsheet usando Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tableName = 'usuarios';

// Función para obtener los nombres de las columnas de una tabla
function getColumnNames($conexion, $tableName) {
    try {
        $stmt = $conexion->query("SHOW COLUMNS FROM `$tableName`");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    } catch (Exception $e) {
        error_log("Error al obtener columnas: " . $e->getMessage());
        return [];
    }
}

// Obtener los nombres de las columnas
$columns = getColumnNames($conexion, $tableName);

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Escribir los nombres de las columnas en la primera fila
$sheet->fromArray($columns, null, 'A1');

// Crear un escritor de archivos Excel
$writer = new Xlsx($spreadsheet);

// Guardar el archivo en el servidor
$filename = 'plantilla_' . $tableName . '.xlsx';
try {
    $writer->save($filename);

    // Forzar la descarga del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Leer el archivo para la descarga
    readfile($filename);

    // Eliminar el archivo del servidor después de la descarga
    unlink($filename);
    exit();
} catch (Exception $e) {
    error_log("Error al guardar o descargar el archivo: " . $e->getMessage());
    // Manejo de errores adecuado
    echo 'Error al generar la plantilla. Inténtalo de nuevo más tarde.';
    exit();
}
?>
