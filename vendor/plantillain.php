<?php
require 'autoload.php'; // Asegúrate de haber instalado PhpSpreadsheet usando Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Plantilla Inventario');

// Encabezados específicos
$headers = ['id_foto', 'id_categoria', 'id_subcategoria', 'id_stock', 'id_proveedor', 'nombre', 'precio', 'descripcion', 'estado'];

// Escribir los encabezados en la primera fila
$sheet->fromArray($headers, null, 'A1');

// Estilo para los encabezados
$sheet->getStyle('A1:I1')->getFont()->setBold(true);
$sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Ajustar automáticamente el ancho de las columnas
foreach (range('A', 'I') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Configurar las cabeceras para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Plantilla_Inventario.xlsx"');
header('Cache-Control: max-age=0');

// Guardar el archivo y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
