<?php
// controllers/UsuarioController.php
require_once 'models/UsuarioModel.php';
require_once 'views/ReportePDF.php';

class UsuarioController
{
    public function generarReporte()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->consultarTodos();

        $pdf = new ReportePDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->generarTablausuarios($usuarios, $usuarioModel);
        $pdf->Output();
    }
}
