<?php
require 'autoload.php';
require 'Conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet,IOFactory};
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\IOFactory; otra menera de hacer una ruta

    $sql = "SELECT * FROM usuarios";
    $statement= $conexion->prepare($sql);
    $statement->execute();
    $rows=$statement->fetchALL(PDO::FETCH_ASSOC);
    $estado = [
        1 => 'Activo',
        2 => 'Inactivo',
        3 => 'Pendiente' 
    ];
    $rol = [
        1 => 'Administrador',
        2 => 'Mesero',
        3 => 'Cheff',
        4 => 'Cajero'
    
    ];
    
    
    $excel = new Spreadsheet();
    $hojaactiva = $excel->getActiveSheet();
    $hojaactiva->setTitle("Reporte");
    
    $hojaactiva->getColumnDimension('A')->setWidth(20);
    $hojaactiva->setCellValue('A1','Nombres');
    $hojaactiva->getColumnDimension('B')->setWidth(15);
    $hojaactiva->setCellValue('B1','Apellidos');
    $hojaactiva->getColumnDimension('C')->setWidth(30);
    $hojaactiva->setCellValue('C1','Documento');
    $hojaactiva->getColumnDimension('D')->setWidth(25);
    $hojaactiva->setCellValue('D1','Teléfono');
    $hojaactiva->getColumnDimension('E')->setWidth(15);
    $hojaactiva->setCellValue('E1','Estado');
    $hojaactiva->getColumnDimension('F')->setWidth(15);
    $hojaactiva->setCellValue('F1','Rol');
    $hojaactiva->getColumnDimension('G')->setWidth(30);
    $hojaactiva->setCellValue('G1','Fecha de Creación');
    $fila = 2;
    
    foreach($rows as $row){
        $hojaactiva->setCellValue('A'.$fila,$row['nombres']);
        $hojaactiva->setCellValue('B'.$fila,$row['apellidos']);
        $hojaactiva->setCellValue('C'.$fila,$row['documento']);
        $hojaactiva->setCellValueExplicit('D' . $fila, $row['telefono'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        
        $estado1 =$estado[$row['id_estado']]?? 'Desaconocido';
        $hojaactiva->setCellValue('E'.$fila,$estado1);
        $rol1 = $rol[$row['id_rol']]?? 'Desaconocido';
        $hojaactiva->setCellValue('F'.$fila,$rol1);
        $hojaactiva->setCellValue('G'.$fila,$row['fecha_de_creacion']);
        $fila++;
    }
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;
    
    
    
    ?>