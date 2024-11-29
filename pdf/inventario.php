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
        $this->Cell(60, 10, 'Reporte de Inventario', 1, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function generarTablainventario($inventario, $modelo)
{
    // Configuración de la fuente para los encabezados
    $this->SetFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $this->Cell(10, 10, 'ID', 1, 0, 'C');
    $this->Cell(50, 10, 'Nombre', 1, 0, 'C');
    $this->Cell(30, 10, 'Precio', 1, 0, 'C');
    $this->Cell(80, 10, 'Descripcion', 1, 1, 'C');

    // Cambiar la fuente para el contenido
    $this->SetFont('Arial', '', 10);

    // Verificar si hay registros en el inventario
    if (empty($inventario)) {
        $this->Cell(190, 10, 'No hay registros disponibles en el inventario.', 1, 1, 'C');
        return;
    }

    // Recorrer los productos
    foreach ($inventario as $producto) {
        // Guardar la posición inicial
        $yAntes = $this->GetY();

        // Obtener altura de la descripción usando MultiCell en un área temporal
        $xDescripcion = $this->GetX() + 90; // La posición X donde empieza la descripción
        $this->SetXY($xDescripcion, $yAntes);
        $this->MultiCell(80, 10, utf8_decode($producto['descripcion']), 0, 'L');
        $altoDescripcion = $this->GetY() - $yAntes; // Altura calculada de la descripción

        // Determinar la altura máxima (mínimo 10 para alineación)
        $alturaFila = max($altoDescripcion, 10);

        // Restaurar la posición para imprimir las otras celdas
        $this->SetY($yAntes);

        // Imprimir las celdas con alturas iguales
        $this->Cell(10, $alturaFila, $producto['id'], 1, 0, 'C');
        $this->Cell(50, $alturaFila, utf8_decode($producto['nombre']), 1, 0, 'C');
        $this->Cell(30, $alturaFila, number_format($producto['precio'], 2), 1, 0, 'C');

        // Imprimir la descripción en su posición correcta
        $this->SetXY($xDescripcion, $yAntes);
        $this->MultiCell(80, 10, utf8_decode($producto['descripcion']), 1, 'L');

        // Mover el cursor a la siguiente fila
        $this->SetY($yAntes + $alturaFila);
    }
}



    
    


    
}

// Incluir el modelo de Usuario para obtener los datos
require_once('../models/inventariomodel.php');
$inventariomodel = new inventariomodel();
$inventario = $inventariomodel->consultarTodos();

// Generar el PDF
$pdf = new ReportePDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->generarTablainventario($inventario,$inventariomodel);


// Forzar la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reporte_usuarios.pdf"');
$pdf->Output();
