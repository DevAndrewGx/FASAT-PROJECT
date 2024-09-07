<?php

$host = "localhost";
$nombre = "test_fast5";
$usuario = "root";
$password = "";

// Fecha y nombre del archivo SQL
$fecha = date('Ymd_His');
$nombre_sql = $nombre . '_' . $fecha . '.sql';

// Comando para crear el dump de la base de datos


$dump = "$mysqldump -h$host -u$usuario -p$password $nombre > $nombre_sql";

// Ejecutar el comando mysqldump
exec($dump);

// // Crear el archivo ZIP
$zip = new ZipArchive();
$nombre_zip = $nombre . '_' . $fecha . '.zip';

 if ($zip->open($nombre_zip, ZipArchive::CREATE) === true) {
    $zip->addFile($nombre_sql);
    $zip->close();
    unlink($nombre_sql);
    header("Location: $nombre_zip"); 
 }
 ?>
