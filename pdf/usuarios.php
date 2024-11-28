<?php
// pdf/usuarios.php
require_once('../pdf/FPDF.php'); // Asegúrate de que la ruta sea correcta

// Clase para generar el PDF
class ReportePDF extends FPDF
{
    function Header()
    {
        $this->Image('../public/imgs/LOGOf.png', 10, 8, 33); // Ajusta la ruta al logo
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(70);
        $this->Cell(60, 10, 'Reporte de Usuarios', 1, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function generarTablausuarios($usuarios, $usuarioModel)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(25, 10, 'Nombres', 1, 0, 'C');
        $this->Cell(25, 10, 'Apellidos', 1, 0, 'C');
        $this->Cell(30, 10, 'Documento', 1, 0, 'C');
        $this->Cell(25, 10, 'Teléfono', 1, 0, 'C');
        $this->Cell(20, 10, 'Estado', 1, 0, 'C');
        $this->Cell(25, 10, 'Rol', 1, 0, 'C');
        $this->Cell(40, 10, 'Fecha de Creación', 1, 1, 'C');

        $this->SetFont('Arial', '', 10);
        if (!empty($usuarios)) {
            foreach ($usuarios as $usuario) {
                $this->Cell(25, 10, $usuario['nombres'], 1);
                $this->Cell(25, 10, $usuario['apellidos'], 1);
                $this->Cell(30, 10, $usuario['documento'], 1);
                $this->Cell(25, 10, $usuario['telefono'], 1);
                $this->Cell(20, 10, $usuarioModel->interpretarEstado($usuario['id_estado']), 1);
                $this->Cell(25, 10, $usuarioModel->interpretarRol($usuario['id_rol']), 1);
                $this->Cell(40, 10, $usuario['fecha_de_creacion'], 1, 1, 'C');
            }
        } else {
            $this->Cell(190, 10, 'No se encontraron registros', 1, 0, 'C');
        }
    }
}

// Incluir el modelo de Usuario para obtener los datos
require_once('../models/UsuarioModel.php');
$usuarioModel = new UsuarioModel();
$usuarios = $usuarioModel->consultarTodos();

// Generar el PDF
$pdf = new ReportePDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->generarTablausuarios($usuarios, $usuarioModel);

// Forzar la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reporte_usuarios.pdf"');
$pdf->Output();
