<?php 

    class StockModel extends Model implements JsonSerializable  {

        private $id_inventario;
        private $nombre_producto;
        private $cantidad;
        private $cantidad_minima;
        private $cantidad_disponible;

        public function __construct() { 
            
            parent::__construct();


            // inicializamos los atributos
            $this->id_inventario = 0;
            $this->cantidad = 0; 
            $this->cantidad_minima = 0;
            $this->cantidad_disponible = 0;

        }


        public function getAll() { 
            
            // creamos un arreglo para almacenar los datos que vengan de la bd
            $item = [];

            try {
                // guardamos la consulta con query ya que no estamos preparando valores y hacemos un JOIN para traer los valores 
                // Ambas tablas tanto de productos como de stock
                $query = $this->query("SELECT * FROM stock_inventario");

                // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
                // FETCH_ASSOCretorna un objeto de clave y valor

                while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    // // a cada elemento de la db le creamos un nuevo UserModel para rellenar sus respectivos campos con los setters
                    $item = new StockModel();
                    
                    $this->setNombreProducto($item["nombre"]);
                    $this->setCantidad($item["cantidad"]);
                    $this->setCantidadMinima($item["cantidad_minima"]);
                    $this->setCantidadDisponible($item["cantidad_disponible"]);
                    
                    // Ya que asignamos todo lo necesario, lo vamos agregar a items para que al final tenga de elementos de tipo userModel
                    array_push($items, $item);
                }

                // finalmente reotrnamos el arreglo
                return $items;
            }catch(PDOException $e) {
                error_log('InventarioModel::getId->PDOException' . $e);
            }
        }

        public function cargarDatosProductosEnStock($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $nombreColumna) {
        $items = [];

            try {
                $sql = "SELECT pd.nombre, st.cantidad, st.cantidad_minima, st.cantidad_disponible FROM stock_inventario st INNER JOIN productos_inventario pd ON pd.id_stock = st.id_stock";

                if (!empty($busqueda)) {
                    $searchValue = $busqueda;
                    $sql .= " WHERE 
                    pd.nombre LIKE '%$searchValue%' OR 
                    st.cantidad LIKE '%$searchValue%' OR 
                    st.cantidad_minima LIKE '%$searchValue%' OR 
                    st.cantidad_disponible LIKE '%$searchValue%'";
                }

                if ($columna != null && $orden != null) {
                    $sql .= " ORDER BY $nombreColumna $orden";
                } else {
                    $sql .= " ORDER BY u.cantidad DESC";
                }

                if ($registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null) {
                    $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
                }

                $query = $this->query($sql);

                while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                    $item = new StockModel();
                    $item->from($p);
                    array_push($items, $item);
                }
                return $items;
            } catch (PDOException $e) {
                error_log('StockModel::cargarDatosProductoEnStock - ' . $e->getMessage());
                return [];
            }
        }

        // funcion para cargar el total de los registros

        public function totalRegistros() { 

            try {
                $query = $this->query("SELECT COUNT(*) as total FROM stock_inventario");
                return $query->fetch(PDO::FETCH_ASSOC)['total'];
            }catch(PDOException $e) { 
                error_log("StockModel::totalRegistros -".$e->getMessage());
            }
        }


        // funcion para cargar los registros despues de los filtros
        public function totalRegistrosFiltrados($busqueda) { 
            $sql = "SELECT COUNT(*) as total FROM stock_inventario st INNER JOIN productos_inventario pd ON pd.id_stock = st.id_stock";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                pd.nombre LIKE '%$searchValue%' OR 
                st.cantidad LIKE '%$searchValue%' OR 
                st.cantidad_minima LIKE '%$searchValue%' OR 
                st.cantidad_disponible LIKE '%$searchValue%'";

                $query = $this->query($sql);
                return $query->fetch(PDO::FETCH_ASSOC)['total'];
            }
        }


        // funcion para actualizar el stock
        public function update() { 
            
        }

        // funcion para pasar la data del array a los atributos de la clase
        public function from($array) { 
            
            $this->nombre_producto = $array['nombre'] ?? null;
            $this->cantidad = $array['cantidad'] ?? null;
            $this->cantidad_minima = $array['cantidad_minima'] ?? null;
            $this->cantidad_disponible = $array['cantidad_disponible'] ?? null;
        }


        // funcion para enviar la respuesta al front
        public function jsonSerialize(): mixed
        {
            return [
                'nombre_producto' => $this->nombre_producto,
                'cantidad' => $this->cantidad,
                'cantidad_minima' =>$this->cantidad_minima, 
                'cantidad_disponible' =>$this->cantidad_disponible
            ];
        }

        // GETTERS Y SETTERS
        public function setNombreProducto($nombre) {$this->nombre_producto = $nombre;}
        public function setCantidad($cantidad) { $this->cantidad = $cantidad;}
        public function setCantidadMinima($minima) {$this->cantidad_minima = $minima;}  
        public function setCantidadDisponible($disponible) {$this->cantidad_disponible = $disponible;}  

        public function getNombreProducto() { return $this->nombre_producto;}
        public function getCantidad() { return $this->cantidad;}
        public function getCantidadMinima() { return $this->cantidad_minima;}
        public function getCantidadDisponible() { return $this->cantidad_disponible;}

    }

?>