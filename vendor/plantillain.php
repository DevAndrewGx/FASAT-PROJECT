<?php
require 'autoload.php'; // Asegúrate de que PhpSpreadsheet esté instalado
require 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Crear un nuevo archivo Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados de la plantilla (basado en tu consulta SQL, pero sin `id_pinventario` y `id_proveedor`)
    $headers = [
        'ID Foto',
        'ID Categoría',
        'ID Subcategoría',
        'ID Stock',
        'Nombre',
        'Precio',
        'Descripción',
        'Estado'
    ];
    $sheet->fromArray($headers, null, 'A1'); // Escribir los encabezados en la primera fila

    // Configurar el archivo para descarga
    $filename = 'plantilla_inventario.xlsx';
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
