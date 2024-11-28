<?php
require_once 'models/InventarioModel.php';
require_once 'views/Reporte.php';

class InventarioController
{
    public function generarReporte()
    {
        $inventarioModel = new InventarioModel();
        $inventario = $inventarioModel->consultarTodos();

        $pdf = new ReportePDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->generarTablainventario($inventario, $inventarioModel);
        $pdf->Output();
    }
}
