<?php
// models/Conexion.php

class Conexion
{
    private $host = 'localhost';   // Host de la base de datos
    private $db = 'fast';    // Nombre de la base de datos
    private $user = 'root';        // Usuario de la base de datos
    private $pass = '';            // Contraseña del usuario
    private $charset = 'utf8mb4';  // Codificación de caracteres
    private $pdo;                  // Objeto PDO para la conexión

    public function __construct()
    {
        $this->conectar(); // Llama al método conectar al crear la instancia
    }

    private function conectar()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo; // Devuelve el objeto PDO para realizar consultas
    }
}
