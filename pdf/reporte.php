<?php
// views/ReportePDF.php
require_once 'pdf/fpdf.php';

class ReportePDF extends FPDF
{
    function Header()
    {
        $this->Image('logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Reporte', 1, 0, 'C');
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
