<?php
require 'autoload.php'; // Asegúrate de que PhpSpreadsheet esté instalado
require 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Crear un nuevo archivo Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados de la plantilla para cada tabla
    $headers = [
        'Nombre Categoría', 'Tipo Categoría',   // Categorias
        'ID Foto', 'ID Categoría', 'ID Subcategoría', 'ID Stock', 'ID Proveedor', 'Nombre Producto', 'Precio', 'Descripción', 'Estado', // Productos Inventario
        'Cantidad', 'Cantidad Mínima', 'Cantidad Disponible',  // Stock Inventario
        'Nombre Subcategoría', 'ID Categoría (Subcategoría)',  // Sub Categorías
    ];
    $sheet->fromArray($headers, null, 'A1'); // Escribir los encabezados en la primera fila

    // Configurar el archivo para descarga
    $filename = 'plantilla_datos_inventario_vacia.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Crear el escritor de Excel
    $writer = new Xlsx($spreadsheet);

    // Enviar el archivo al navegador
    $writer->save('php://output');
    exit();
} catch (Exception $e) {
    echo 'Error al generar la plantilla Excel: ' . $e->getMessage();
}
