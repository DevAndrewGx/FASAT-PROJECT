<?php 

    // esta es la clase base de donde van extender todos nuestros modelos
    // ademas que aqui vamos a implementar la conexion con la base de datos

    // requerimos nuestro archivo de IModel para implementarlo en cada modelo
    class Model { 
        
        protected $db;
        function __construct() { 
            $this->db = new Database();
        }


        // creamos una function query para ahorrarnos la tarea de escribir la misma funcion cuando queramos ejecutar la consulta para traer data
        function query($query) { 
            return $this->db->connect()->query($query);
        }

        // creamos de la misma manera la funcion prepare para ejecutar consultas cuando tengan placeholders, para protejer la bd de SQL INJECTION

        function prepare($query) { 
            return $this->db->connect()->prepare($query);
        }
    }
?>