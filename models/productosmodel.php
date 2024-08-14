
<?php 

    // Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
    class ProductosModel extends Model {


        // creamos los atributos de la clase

        private $id_foto;
        private $id_stock;
        private $id_provedor;
        private $id_categoria;
        private $precio;
        private $nombre;
        private $descripcion;
        private $disponibilidad;
        
        
        // creamos el constructor para inicializar los atributos

        public function __construct() { 
            
            parent::__construct();

            // inicializar los atributos
            $id_foto = 0;
            $id_stock = 0;
            $id_provedore = 0;
            $id_categoria = 0;
            $precio = 0;
            $tipo = '';
            $nombre = '';
            $descripción = '';
            $disponibilidad = '';
        }

        

        // creamos la funcion para crear un nuevo producto 
        public function save() { 
            // utilizamos siempre el try catch ya que vamos a crear consultas para manipular la bd
            
            try { 
                // creamos la query para insertar datos dentro de la bd
                $query = $this->prepare("INSERT INTO productos(id_foto, id_stock, id_proveedor, id_categoria, nombre, precio_unitario, descripcion, permitir_sin_vender) VALUES(:id_foto, :id_stock, :id_proveedor, :id_categoria :nombre, :precio_unitario, :descripcion, :disponibilidad)");

                $query->execute([
                    'id_foto'=>$this->id_foto,
                    'id_stock'=>$this->id_stock,
                    'id_proveedor'=>$this->id_provedor,
                    'id_categoria' => $this->id_categoria,
                    'nombre'=>$this->nombre,
                    'precio_unitario'=>$this->precio,
                    'descripcion'=>$this->descripcion
                    
                ]);

                // retornamos true para salirnos de la funcion
                return true;
            }catch(PDOException $e) {
               error_log('ProductoModel::save->PDOException'.$e);
                // salimos de la funcion
                return false;
            }
        }


        // getters and setters

        public function setIdFoto($id) { $this->id_foto = $id;}
        public function setIdStock($id) { $this->id_stock = $id;}
        public function setIdProvedor($id) { $this->id_provedor = $id;}
        public function setIdCategoria($categoria) { $this->id_categoria = $categoria;}
        public function setPrecio($precio) { $this->precio = $precio;}
        public function setNombre($nombre) { $this->nombre = $nombre;}
        public function setDescripcion($descripcion) {  $this->descripcion = $descripcion;}
        public function setDisponibilidad($disponibilidad) { $this->disponibilidad = $disponibilidad;}


        public function getIdFoto() { return $this->id_foto;}
        public function getIdStock() { return $this->id_stock;}
        public function getIdProvedor() { return $this->id_provedor;}
        public function getIdCategoria() { return $this->id_categoria;}
        public function getPrecio() { return $this->precio;}
        public function getNombre() { return $this->nombre;}
        public function getDescripcion() { return $this->descripcion;}
        public function getDisponibilidad() { return $this->disponibilidad;}
        
    }

?>