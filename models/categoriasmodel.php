<?php 

    class CategoriasModel extends Model {
        
        // atributos de la clase
        private $id_categoria;
        private $id_subcategoria;
        private $nombre_categoria;
        private $tipo;


        // constructor para inicializar parametros
        public function __construct() {
            parent::__construct();

            $id_categoria = 0;
            $id_subcategoria = 0; 
            $nombre_categoria = "";
            $tipo = "";
        }

        // funcion para crear una nueva categoria
        

        public function save() { 
            
            try {
                 // creamos la consulta
                $query = $this->prepare("INSERT INTO categorias('id_subcategoria, nombre_categoria, tipo_categoria')");

                // Ejecutamos la consulta con los atributos seteados anteriormente
                $query->execute([
                    'id_subcategoria'=>$this->id_subcategoria,
                    'nombre_categoria'=>$this->nombre_categoria,
                    'tipo_categoria'=> $this->tipo,
                ]);

                // saliimos de la funcion
                return true;
            }catch(PDOException $e) {
                error_log('CategoriasModel::save->PDOException' . $e);
                // salimos de la funcion
                return false;
            }
        }


        public function getIdCategoria() { return $this->id_categoria;}
        public function getIdSubCategoria() { return $this->id_subcategoria;}
        public function getNombreCategoria() { return $this->nombre_categoria;}
        public function getTipoCategoria() { return $this->tipo;}
        public function setIdSubCategoria($id) { $this->id_subcategoria = $id;}
        public function setNombreCategoria($nombre) { $this->nombre_categoria = $nombre;}
        public function setTipo($tipo) { $this->tipo = $tipo;}
    }
?>