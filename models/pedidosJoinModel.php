<?php 
// Este modelo nos ayudara a traer la data de varias tablas para mostrarla en la vista de pedidos de la visualización de los pedidos
// quedara muy extenso y largo, lo cual no es recomendable 

class PedidosJoinModel extends Model implements JsonSerializable {
    
    private $id_pedido;
    private $id_producto;
    private $id_mesero;
    private $id_mesa; 
    private $numero_mesa;
    private $nombre_mesero;
    private $codigo_pedido;
    private $estado;
    private $total;
    private $personas;
    private $notas_general_pedido;
    private $notas_producto;
    private $cantidad;
    private $precio;
    private $fecha_hora;


    // Inicializamos los parametros del objeto para no tener dificultades por datos nullos
    public function __construct()
    {
        parent::__construct();

        $this->id_pedido = 0;
        $this->id_producto = 0;
        $this->id_mesero = 0;
        $this->id_mesa = 0;
        $this->numero_mesa = 0;
        $this->nombre_mesero = 0;
        $this->codigo_pedido = 0;
        $this->estado = "";
        $this->total = 0;
        $this->personas = 0;
        $this->notas_general_pedido = "";
        $this->notas_producto = "";
        $this->cantidad = 0;
        $this->precio = 0;
        $this->fecha_hora = "";
       
    }

    // esta funcion nos permitira buscar un pedido en especifico
    public function consultar() {
       
    }

    // esta funcion nos permitira listar todos los pedidos con sus respectivo datos y detalles
    public function cargarDatosPedidos($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName) {
        $items = [];

        try {

            // En este caso tenemos que crear una consulta con parametros mas complejos ya que necesitamos concatenar los producto en una sola columna
            $sql = "SELECT 
                    m.id_mesa,
                    m.numero_mesa,
                    m.estado AS estado_mesa,
                    m.capacidad,
                    p.id_pedido,
                    p.codigo_pedido,
                    p.total,
                    p.estado AS estado_pedido,
                    p.notas_pedidos,
                    u.documento,
                    u.nombres,
                    GROUP_CONCAT(pp.id_producto) AS productos,
                    GROUP_CONCAT(pp.cantidad) AS cantidades,
                    GROUP_CONCAT(pp.precio) AS precios
                FROM pedidos p 
                INNER JOIN mesas m ON p.id_mesa = m.id_mesa 
                INNER JOIN usuarios u ON p.id_mesero = u.documento 
                INNER JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido
                GROUP BY m.id_mesa, p.id_pedido ";
            error_log('ejecucion de la query de cargaDatosPedidos' . $sql);
            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    m.mesa LIKE '%$searchValue%' OR 
                    m.nombres LIKE '%$searchValue%' OR 
                    p.codigo_pedido LIKE '%$searchValue%' OR 
                    p.total LIKE '%$searchValue%' OR 
                    p.estado LIKE '%$searchValue%'";
            }


            if ($columna != null && $orden != null) {
                $sql .= " ORDER BY $columnName $orden";
            } else {
                $sql .= " ORDER BY p.codigo_pedido DESC";
            }

            error_log("Registros por pagina: ->>>>>>>>>>>>>>>>> " . $registrosPorPagina);
            error_log("Inicio por pagina: ->>>>>>>>>>>>>>" . $inicio);

            if ($registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }
            error_log("Consulta 1 : ->>>>>>>>>>>>>>" . $registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null);
            error_log("Consulta 2 : ->>>>>>>>>>>>>>" . $registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null);
            error_log("Consulta: ->>>>>>>>>>>>>>" . $sql);
            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new PedidosJoinModel();

                // utilizamos esta funcion para asignar los atributos del registro a un objeto de este modelo
                $item->asignarDatosArray($p);
                array_push($items, $item);
            }
   
            return $items;
        } catch (PDOException $e) {
            error_log('CategoriasModel::cargarDatosCategorias - ' . $e->getMessage());
            return [];
        }
    }


    public function totalRegistros()
    {
        try {
            $query = $this->query("SELECT COUNT(*) as total FROM pedidos");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('ProductosModel::totalRegistros - ' . $e->getMessage());
            return 0;
        }
    }


    // utilizamos esta funcion paras regresar la cantidad de registros filtrados
    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(DISTINCT p.id_pedido) as total
                FROM pedidos p 
                INNER JOIN mesas m ON p.id_mesa = m.id_mesa 
                INNER JOIN usuarios u ON p.id_mesero = u.documento 
                INNER JOIN pedido_producto pp ON p.id_pedido = pp.id_pedido;";
            
            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    m.mesa LIKE '%$searchValue%' OR 
                    m.nombres LIKE '%$searchValue%' OR 
                    p.codigo_pedido LIKE '%$searchValue%' OR 
                    p.total LIKE '%$searchValue%' OR 
                    p.estado LIKE '%$searchValue%'";
            }

            $query = $this->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('ProductosJoinModel:totalRegistrosFiltrados - ' . $e->getMessage());
            return 0;
        }
    }
    


    // implementamos jsonSerialize para devolver la data a la vista en JSON para ser utilizada con facilidad
    public function jsonSerialize(): mixed
    {
        return [
            'id_pedido' => $this->id_pedido,
            'id_producto' => $this->id_producto,
            'id_mesero' => $this->id_mesero,
            'id_mesa' => $this->id_mesa,
            'numero_mesa' => $this->numero_mesa,
            "nombre_mesero" => $this->nombre_mesero,
            'codigo_pedido' => $this->codigo_pedido,
            'estado' => $this->estado,
            'total' => $this->total,
            'personas' => $this->personas,
            'notas_general_pedido' => $this->notas_general_pedido,
            'notas_producto' => $this->notas_producto,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'fecha_hora' => $this->fecha_hora
        ];
    }

    // creamos el metodo asignarDatosArray para facilitar el establecimiento de datos de los objetos al momento de recorrer el while
    public function asignarDatosArray($array)
    {
        $this->id_pedido = $array['id_mesa'];
        $this->id_producto = $array['id_producto'];
        $this->id_mesero = $array['id_mesero'];
        $this->id_mesa = $array['id_mesa'];
        $this->numero_mesa = $array['numero_mesa'];
        $this->nombre_mesero = $array['nombres'];
        $this->codigo_pedido = $array['codigo_pedido'];
        $this->estado = $array['estado_pedido'];
        $this->total = $array['total'];
        $this->personas = $array['personas'];
        $this->notas_general_pedido = $array['notas_pedido'];
        $this->notas_producto = $array['notas_producto'];
        $this->cantidad = $array['cantidad'];
        $this->precio = $array['precio'];
        $this->fecha_hora = $array['fecha_hora'];
    }
    
    // getters y setters
    public function getIdPedido() { return $this->id_pedido;}
    public function getIdProducto() { return $this->id_producto;}
    public function getIdMesero() {return $this->id_mesero;}
    public function getIdMesa() {return $this->id_mesa;}
    public function getCodigoPedido() {return $this->codigo_pedido;}
    public function getEstado() {return $this->estado;}
    public function getTotal() { return $this->total;}
    public function getPersonas() { return $this->personas;}
    public function getNotasGeneralPedido() { return $this->notas_general_pedido;}
    public function getNotasProducto() { return $this->notas_producto;}
    public function getCantidad() { return $this->cantidad;}
    public function getPrecio() { return $this->precio;}
    public function getFechaHora() { return $this->fecha_hora;}

    public function setIdPedido($idPedido) { return $this->id_pedido = $idPedido;}
    public function setIdProducto($idProducto) { return $this->id_producto = $idProducto;}
    public function setIdMesero($idMesero) {return $this->id_mesero = $idMesero;}
    public function setIdMesa($idMesa) {return $this->id_mesa = $idMesa;}
    public function setCodigoPedido($idCodigo) {return $this->codigo_pedido = $idCodigo;}
    public function setEstado($estado) {return $this->estado = $estado;}
    public function setTotal($total) { return $this->total = $total;}
    public function setPersonas($personas) { return $this->personas = $personas;}
    public function setNotasGeneralPedido($notasGeneralPedido) { return $this->notas_general_pedido = $notasGeneralPedido;}
    public function setNotasProducto($notasProducto) { return $this->notas_producto = $notasProducto;}
    public function setCantidad($cantidad) { return $this->cantidad = $cantidad;}
    public function setPrecio($precio) { return $this->precio = $precio;}
    public function setFechaHora($fechaHora) { return $this->fecha_hora = $fechaHora;}

}

?>