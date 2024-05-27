<?php
// Creamos nuestra clase database para realizar la conexion con PDO a la bd
class Database
{
    
     // creamos la variables de conexion
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
        // asignamos las variables de conexion a sus respectivos valores que estan como constantes
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }

    function connect()
    {
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}
