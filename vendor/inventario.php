<?php
require 'autoload.php'; // Asegúrate de que PhpSpreadsheet esté instalado
require 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Consulta SQL para obtener los datos
    $sql = "SELECT `id_pinventario`, `id_foto`, `id_categoria`, `id_subcategoria`, `id_stock`, `nombre`, `precio`, `descripcion`, `estado` FROM `productos_inventario` ";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos
    if (!$data) {
        throw new Exception("No hay datos disponibles en la tabla.");
    }

    // Crear un nuevo archivo Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar encabezados al archivo Excel
    $headers = ['ID Producto','Foto', 'Categoria', 'Sub Categoría','stock', 'Nombre','Precio', 'Descripción', 'Esatdo'];
    $sheet->fromArray($headers, null, 'A1'); // Escribe los encabezados en la fila 1

    // Agregar datos desde la base de datos
    $rowIndex = 2; // Comienza desde la fila 2
    foreach ($data as $row) {
        $sheet->fromArray(array_values($row), null, "A{$rowIndex}");
        $rowIndex++;
    }

    // Configurar el archivo para descarga
    $filename = 'productos.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Crear el escritor de Excel
    $writer = new Xlsx($spreadsheet);

    // Enviar el archivo al navegador
    $writer->save('php://output');
    exit();
} catch (Exception $e) {
    echo 'Error al generar el archivo Excel: ' . $e->getMessage();
}
