<?php 

    class CategoriasModel extends Model implements JsonSerializable {
        
        // atributos de la clase
        private $id_categoria;
        private $nombre_categoria;
        // atributos adicionales para las subcategorias
        private $nombre_subcategoria;
        private $tipo;


        // constructor para inicializar parametros
        public function __construct() {
            parent::__construct();

            $id_categoria = 0;
            $nombre_categoria = "";
            $tipo = "";
        }

        // funcion para crear una nueva categoria
    
        public function saveCategory() { 
            
            try {
                $conn = $this->db->connect();
                 // creamos la consulta
                $query = $conn->prepare("INSERT INTO categorias(nombre_categoria, tipo_categoria) VALUES (:nombre_categoria, :tipo_categoria)");

                // Ejecutamos la consulta con los atributos seteados anteriormente
                $query->execute([
                    'nombre_categoria'=>$this->nombre_categoria,
                    'tipo_categoria'=> $this->tipo,
                ]);

                $getLastInsertId = $conn->lastInsertId();
                error_log('FotoModel::save -> lastId -> ' . $getLastInsertId);

                // Asignar el ID de la foto al modelo actual
                $this->setIdCategoria($getLastInsertId);
                // saliimos de la funcion
                return true;
            }catch(PDOException $e) {
                error_log('CategoriasModel::save->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }


        
        // Funcion paraa crear subCategorias
        public function saveSubCategory() {
            try {
                // creamos la consulta
                $query = $this->prepare("INSERT INTO sub_categorias(nombre_subcategoria, id_categoria) VALUES (:nombre, :id)");

                // Ejecutamos la consulta con los atributos seteados anteriormente
                $query->execute([
                    'nombre' => $this->nombre_subcategoria,
                    'id' => $this->id_categoria,
                ]);

                // saliimos de la funcion
                return true;
            } catch (PDOException $e) {
                error_log('CategoriasModel::save->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }


        // La funcion getAll() nos permitira obtener todos los usuarios medo un arreglo de objetos

        public function getAll() { 

            $items = [];


            try { 
                // ejecutamos la consulta con query porque no se estan enviando parametros
                $query = $this->query("SELECT * FROM categorias c INNER JOIN sub_categorias s ON c.id_categoria = s.id_categoria");
                
                  // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
                // FETCH_ASSOC retorna un objeto de clave y valor
                while($row = $query->fetch(PDO::FETCH_ASSOC)) { 

                    // creamos un objeto de categorias para que cada vez que itere guarde la data 

                    $item = new CategoriasModel();

                    $item->setIdCategoria($row['id_categoria']);
                    $item->setNombreCategoria($row['nombre_categoria']);
                    $item->setNombreSubCategoria($row['nombre_subcategoria']);
                    $item->setTipoCategoria($row['tipo_categoria']);
                    
                    // ya que seteamos la data en cada objeto, lo agregamos al objeto principal
                    array_push($items, $item);
                    // finalmente retornamos el objeto
                   
                }

                return $items;
            }catch(PDOException $e) {
                error_log('CategoriasModel::getAll -> SQL error '.$e);
            }
        }


        // funciones para dibujar los datos con datatables
        public function cargarDatosCategorias($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName) {
            $items = [];

            try {
                $sql = "SELECT c.*, s.nombre_subcategoria FROM categorias c LEFT JOIN sub_categorias s ON c.id_categoria = s.id_categoria";  
                error_log('ejecucion de la query cargarCategorias'.$sql);
                if (!empty($busqueda)) {
                    $searchValue = $busqueda;
                    $sql .= " WHERE 
                    c.nombre_categoria LIKE '%$searchValue%' OR 
                    s.nombre_subcategoria LIKE '%$searchValue%' OR 
                    c.tipo_categoria LIKE '%$searchValue%'";
                }
                if ($columna != null && $orden != null) {
                    $sql .= " ORDER BY $columnName $orden";
                } else {
                    $sql .= " ORDER BY c.nombre_categoria DESC";
                }

                if ($registrosPorPagina != null && $registrosPorPagina != -1 && $inicio != null) {
                    $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
                }

                error_log('Query....'.$sql);
                $query = $this->query($sql);

                while ($p = $query->fetch(PDO::FETCH_ASSOC)) {  
                    $item = new CategoriasModel();

                    $item->setIdCategoria($p['id_categoria']); 
                    $item->setNombreCategoria($p['nombre_categoria']);
                    $item->setNombreSubCategoria($p['nombre_subcategoria']);
                    $item->setTipoCategoria($p['tipo_categoria']);
                    error_log("Item: " . print_r($item, true));

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
                $query = $this->query("SELECT COUNT(*) as total FROM categorias");
                return $query->fetch(PDO::FETCH_ASSOC)['total'];
            } catch (PDOException $e) {
                error_log('CategoriasModel::cargarDataosCategorias - ' . $e->getMessage());
                return 0;
            }
        }

        public function totalRegistrosFiltrados($busqueda)
        {
            try {
                $sql = "SELECT COUNT(*) as total FROM categorias c JOIN sub_categorias s ON c.id_categoria = s.id_categoria";

                if (!empty($busqueda)) {
                    $searchValue = $busqueda;
                    $sql .= " WHERE 
                        c.nombre_categoria LIKE '%$searchValue%' OR 
                        c.nombre_subcategoria LIKE '%$searchValue%' OR 
                        u.tipo_categoria LIKE '%$searchValue%'";
                }

                $query = $this->query($sql);
                return $query->fetch(PDO::FETCH_ASSOC)['total'];
            } catch (PDOException $e) {
                error_log('JoinUserRelationsModel::totalRegistrosFiltrados - ' . $e->getMessage());
                return 0;
            }
        }

        public function jsonSerialize()
        {
            return [
                'id_categoria' => $this->id_categoria,
                'nombre_categoria' => $this->nombre_categoria,
                'nombre_subcategoria' => $this->nombre_subcategoria,
                'tipo_categoria' => $this->tipo
            ];
        }

        public function from($array) {
            // $this->id_categoria             = $array['id_categoria'];
            $this->nombre_categoria         = $array['nombre_categoria'];
            $this->nombre_subcategoria      = $array['nombre_subcategoria'];
            $this->tipo                     = $array['tipo_categoria'];
        }
        public function getIdCategoria() { return $this->id_categoria;}
        public function getNombreCategoria() { return $this->nombre_categoria;}
        public function getNombreSubCategoria() { return $this->nombre_subcategoria;}
        public function getTipoCategoria() { return $this->tipo;}
        public function setIdCategoria($id) { return $this->id_categoria = $id;}
        public function setNombreCategoria($nombre) { $this->nombre_categoria = $nombre;}
        public function setTipoCategoria($tipo) { $this->tipo = $tipo;}
        public function setNombreSubCategoria($nombre) { return $this->nombre_subcategoria = $nombre;}
    }
?>