<?php
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../views/imgs/LOGOf.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Reporte',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'c');
    
}
}

    
        $user = "root";
        $pass = "";
        $host = "localhost";
        $db = "test_fast4";
        $charset = 'utf8';  // Añadido punto y coma
    try{
        // Creamos un objeto conexión PDO  // Corregido el comentario
        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);  // Añadido charset al DSN
        $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("conexion fallida: " .$e->getMessage());
    }


        $sql = "SELECT * FROM usuarios";
        $statement= $conexion->prepare($sql);
        $statement->execute();
        $rows=$statement->fetchALL(PDO::FETCH_ASSOC);
        // $statement = $conexion->query($sql);

        function estado($estado){
            switch($estado){
                case 1:
                    return 'Activo';
                    case 2:
                        return 'Inactivo';
                        default:
                            return 'Desconocido';

            }
        }
        function rol($estado){
            switch($estado){
                case 1:
                    return 'Administrador';
                    case 2:
                        return 'Mesero';
                        case 3:
                            return 'Cheff';
                            case 4:
                                return 'Cajero';

            }
        }

        $pdf = new PDF();
        $pdf -> AliasNbpages();//nuemero de pagina
        $pdf->AddPage('','letter',);
        $pdf->SetFont('Arial','B',12);
        
        



$pdf->Cell(25, 10, 'Nombres', 1, 0, 'C');
$pdf->Cell(25, 10, 'Apellidos', 1, 0, 'C');
$pdf->Cell(30, 10, 'Documento', 1, 0, 'C');
$pdf->Cell(25, 10, 'Teléfono', 1, 0, 'C');
$pdf->Cell(20, 10, 'Estado', 1, 0, 'C');
$pdf->Cell(25, 10, 'Rol', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha de Creación', 1, 1, 'C'); 

$pdf->SetFont('arial','',10);
if(!empty($rows)){
    foreach($rows as $rows){
        $pdf->Cell(25,10,$rows['nombres'],1);
        $pdf->Cell(25,10,$rows['apellidos'],1);
        $pdf->Cell(30,10,$rows['documento'],1);
        $pdf->Cell(25,10,$rows['telefono'],1);
        $pdf->Cell(20,10,estado($rows['id_estado']),1);
        $pdf->Cell(25,10,rol($rows['id_rol']),1);
        $pdf->Cell(40,10,$rows['fecha_de_creacion'],1,1,'c');
    }
}else{
    $pdf->Cell(190,10,'No se encontraron registros',1,0,'c');
}



$pdf->Output(); 
    ?>