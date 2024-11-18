<?php

use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Week;

    class PedidosModel extends Model { 


        // creamos los atributos de la clase
        private $id_pedido; 
        private $id_mesa;
        private $id_mesero;
        private $total;
        private $codigo_pedido;

        // creamos el constructor para inicializar los atributos
        public function __construct()
        {

            parent::__construct();

            // inicializar los atributos
            $this->id_pedido = 0;
            $this->id_mesa = 0;
            $this->id_mesero = 0;
            $this->total = 0;
            $this->codigo_pedido = 0;
        }

        // esta funcion nos permitira crear un nuevo pedido
        public function crear() { 
            
            try {
                
            }catch(PDOException $e) {
                error_log('PredidosModel::crear->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }

         // Esta funcion nos permtira crear los codigos de pedido para una mejor gestion
        public function generarCodigoPedido() {
            try {
                // creamos la consulta para obtener el último código de pedido
                $query = $this->query("SELECT codigo_pedido FROM pedidos ORDER BY id_pedido DESC LIMIT 1");
                
                // ejcutamos la query
                $query->execute();
                
                // traemos la data de la bd
                $ultimoPedido = $query->fetch(PDO::FETCH_ASSOC);
                // Si existe un último pedido, extraer el número secuencial
                if ($ultimoPedido) {
                    // Extraer el número secuencial del último código (suponiendo formato "ORD-001")
                    $ultimoCodigo = $ultimoPedido['codigo'];
                    $numeroSecuencial = intval(substr($ultimoCodigo, 4)) + 1; // Incrementar el número
                } else {
                    // Si no hay pedidos previos, comenzar desde 1
                    $numeroSecuencial = 1;
                }

                // Formatear el nuevo código con ceros a la izquierda (ej. ORD-001, ORD-002, ...)
                $nuevoCodigo = 'ORD-' . str_pad($numeroSecuencial, 3, '0', STR_PAD_LEFT);
                return $nuevoCodigo;

            } catch (PDOException $e) {
                error_log('PredidosModel::generarCodigoPedio->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }

        
    }
?>