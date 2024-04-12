<?php
require_once("../models/Conexion.php");
require_once("../models/Consultas.php");

// Verificar si las claves existen en $_POST antes de acceder a ellas
$registrosPorPagina = isset($_POST['length']) ? $_POST['length'] : null;
$inicio = isset($_POST['start']) ? $_POST['start'] : null;
$columna = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : null;
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : null;
$columnName = isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data'] : null;
$orden = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : null;
$busqueda = isset($_POST['search']['value']) ? $_POST['search']['value'] : null;

$objConsultas = new Consultas();
$datos = $objConsultas->cargarDatosEmpleados($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName);

$respuesta = array(
    "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : null,
    "recordsTotal" => $objConsultas->totalRegistros(),
    "recordsFiltered" => $objConsultas->totalRegistrosFiltrados($busqueda),
    "data" => $datos
);

echo json_encode($respuesta);
