<?php 
    // Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
    class VentasModel extends model { 

        // atributos de la clase ventas
        private $id_venta;
        private $id_pedido;
        private $total;
        private $fecha;
        private $estado_pago;


        public function __construct() { 
            parent::__construct();

            // inicializamos los atributos
            $this->id_venta = 0;    
            $this->id_pedido = 0;
            $this->total = 0;
            $this->fecha = "";
            $this->estado_pago = "";
        }

        // creamos una funcion para crear una nueva venta y insertarla en la tabla ventas
        public function crear() {
            
            try {
                // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
                $query = $this->prepare('INSERT INTO ventas (id_pedido, total, fecha, estado_pago) VALUES (:id_pedido, :total, :fecha, :estado)');

                // ejecutamos la query y hacemos la referencia a los placeholders a los atributos de la clase
                $query->execute([
                    ':id_pedido' => $this->id_pedido, 
                    'total' => $this->total, 
                    'fecha' => $this->fecha, 
                    'estado' => $this->estado_pago
                ]);
                
                // retornamos true s la consulta se ejecuta correctamente
            }catch(PDOException $e) {
                error_log('VentasModel::crear->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }


        // GETTERS Y SETTERS
        public function getIdPedido() { return $this->id_pedido;}
        public function getTotal() { return $this->total; }
        public function getFecha() { return $this->fecha; }
        public function getEstado() { return $this->estado_pago; }

        public function setIdPedido($idPedido) { return $this->id_pedido = $idPedido;}
        public function setTotal($total) { return $this->total = $total; }
        public function setFecha($fecha) { return $this->fecha = $fecha; }
        public function setEstado($estado) { return $this->estado_pago = $estado; }

    }

    
?>