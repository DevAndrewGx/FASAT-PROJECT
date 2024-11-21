<?php 
    // Esta clase nos permitira realzar la relación entre pedidos y productos
    class pedidosProductosModel extends Model { 
        
        // creamos los atrbutos de la clase
        private $id_pedido;
        private $id_producto;
        private $cantidad;
        private $precio;
        private $notas_producto;


        // creamos el constructor para inicializar los atributos
        public function __construct()
        {

            parent::__construct();

            // inicializar los atributos
            $this->id_pedido = 0;
            $this->id_producto = 0;
            $this->cantidad = 0;
            $this->precio = 0;
            $this->notas_producto = 0;
            
        }

        // esta funcion nos permitira insertar data en la tabla pedidosProductos
        public function crear() { 
        
        }
    }
?>