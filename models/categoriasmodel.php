<?php 

    class CategoriasModel extends Model {
        
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


        public function saveSubCategory() {
        try {
            // creamos la consulta
            $query = $this->prepare("INSERT INTO sub_categorias(nombre, id_categoria) VALUES (:nombre, :id)");

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