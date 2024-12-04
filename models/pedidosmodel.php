<?php

use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Week;

    class PedidosModel extends Model { 


        // creamos los atributos de la clase
        private $id_pedido; 
        private $id_mesa;
        private $id_mesero;
        private $codigo_pedido;
        private $estado;
        private $personas;
        private $notas_pedido;
        private $total;
        private $fecha_hora_vista;
        private $fecha;
      

        // creamos el constructor para inicializar los atributos
        public function __construct()
        {

            parent::__construct();

            // inicializar los atributos
            $this->id_pedido = 0;
            $this->id_mesa = 0;
            $this->id_mesero = 0;
            $this->codigo_pedido = 0;
            $this->estado = 0;
            $this->personas = 0;
            $this->notas_pedido;
            $this->total = 0;
            $this->fecha_hora_vista = "";
            $this->fecha = 0;
        }

        // esta funcion nos permitira crear un nuevo pedido
        public function crear() { 
            
            // utilizamos try catch para evaluar la consulta ya que vamos a interactuar con la bd
            try {

                // en este caso como necesitamos la conexión, la crearemos manual
                $conn = $this->db->connect();
                // creamos la query para insertar la data en pedidos
                $query = $conn->prepare("INSERT INTO pedidos(id_mesero, id_mesa, codigo_pedido, estado, total, personas, notas_pedidos, fecha_hora_vista, fecha)VALUES (:id_mesero, :id_mesa, :codigo, :estado, :total, :personas, :notas, :fecha_vista, :fecha)");
                

                // asignamos los datos a los placeholders y la ejecutamos
                $query->execute([
                   ":id_mesero"=>$this->id_mesero, 
                   ":id_mesa"=>$this->id_mesa, 
                   ":codigo"=> $this->codigo_pedido, 
                   ":estado"=> $this->estado, 
                   ":total" => $this->total, 
                   ":personas" => $this->personas, 
                   ":notas" => $this->notas_pedido, 
                   ":fecha_vista" => $this->fecha_hora_vista,
                   ":fecha" => $this->fecha
                ]);

                // obtenemos el id del pedido que se inserto en pedidos para insertarlo en pedidosProductos
                $lastInsertId = $conn->lastInsertId();
                $this->setIdPedido($lastInsertId);

                // retornamos true ya que la consulta se ejecuto correctamente
                return $this->id_pedido;
            }catch(PDOException $e) {
                error_log('PredidosModel::crear->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }

        // Esta funcion nos permitira borrar un pedido en la bd
        public function borrar($id) {

            // utilizamos try catch ya que vamos a interactuar con la bd y ademas para capturar cualquier exception sin afectar el aplicativo
            try {
                error_log("PedidosModel::borrar -> funcion para borrar el pedido");
                $query = $this->prepare('DELETE FROM pedidos WHERE id_pedido = :id_pedido');
                $query->execute([
                    'id_pedido' => $id
                ]);

                return true;
            } catch (PDOException $e) {
                error_log('PedidosModel::borrar -> PDOException' . $e);
                return false;
            }
        }


        // Esta funcion nos permitira actualizar la data de un pedido
        public function actualizar($codigo) { 
            
            // usamos try catch ya que vamos a interactuar con la bd, entonces no queremos que en ningun momento se pare la consulta
            try {

            // Consulta de actualización
                $query = $this->prepare("UPDATE pedidos 
                SET 
                    id_mesero = :id_mesero, 
                    id_mesa = :id_mesa, 
                    codigo_pedido = :codigo_pedido, 
                    estado = :estado, 
                    total = :total, 
                    personas = :personas, 
                    notas_pedidos = :notas_pedido 
                WHERE 
                    codigo_pedido = :codigo
            ");

                // Ejecutar la consulta
                $query->execute([
                    "codigo" => $codigo,
                    "id_mesero" => $this->id_mesero,
                    "id_mesa" => $this->id_mesa,
                    "codigo_pedido" => $this->codigo_pedido,
                    "estado" => $this->estado,
                    "total" => $this->total,
                    "personas" => $this->personas,
                    "notas_pedido" => $this->notas_pedido
                ]);

                // Verificar si se actualizó alguna fila
                if ($query->rowCount() >= 0) { // >= 0 es válido porque no siempre habrá cambios
                    return true;
                } else {
                    error_log('PedidosModel::actualizar -> No se actualizó ninguna fila');
                    return false;
                }
            }catch(PDOException $e)  {
            error_log("PedidosModel::actualizar -> PDOException " . $e->getMessage());
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
                    $ultimoCodigo = $ultimoPedido['codigo_pedido'];
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


        // Getters y setters
        public function getIdPedido() { return $this->id_pedido;}
        public function getIdMesa() { return $this->id_mesa;}
        public function getIdMesero() { return $this->id_mesero;}
        public function getCodigoPedido() { return $this->codigo_pedido;}
        public function getEstadoPedido() { return $this->estado;}
        public function getPersonas() { return $this->personas;}
        public function getTotal() { return $this->total;}
        public function getNotasPedido() { return $this->notas_pedido;}
        public function getFechaHora() { return $this->fecha_hora_vista;}
        public function getFecha() { return $this->fecha;}

        public function setIdPedido($idPedido) {  $this->id_pedido = $idPedido;}
        public function setIdMesa($idMesa) {  $this->id_mesa = $idMesa;}
        public function setIdMesero($idMesero) {  $this->id_mesero = $idMesero;}
        public function setCodigoPedido($codigoPedido) {  $this->codigo_pedido = $codigoPedido;}
        public function setEstadoPedido($estadoPedido) {  $this->estado = $estadoPedido;}
        public function setPersonas($personas) {  $this->personas = $personas;}
        public function setTotal($total) {  $this->total = $total;}
        public function setNotasPedido($notasPedido) { return $this->notas_pedido = $notasPedido;}
        public function setFechaHora($fechaHora) {  $this->fecha_hora_vista = $fechaHora;}
        public function setFecha($fecha) {  $this->fecha = $fecha;}
    
    }
?>