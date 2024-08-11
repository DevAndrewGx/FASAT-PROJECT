
<?php 

    // Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
    class ProductoModel extends Model {


        // creamos los atributos de la clase

        private $id_foto;
        private $id_stock;
        private $id_provedor;
        private $id_categoria;
        private $precio;
        private $tipo;
        private $nombre;
        private $unidad_medida;
        private $descripcion;
        
        
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
        }

        

        // creamos la funcion para crear un nuevo producto 
        
        public function save() { 
            
            // utilizamos siempre el try catch ya que vamos a crear consultas para manipular la bd
            
            try { 
                // creamos la query para insertar datos dentro de la bd
                $query = $this->prepare("INSERT INTO productos(id_foto, id_stock, id_proveedor, id_categoria, nombre, precio_unitario, descripcion) VALUES(:id_foto, :id_stock, :id_proveedor, :id_categoria :nombre, :precio_unitario, :descripcion)");

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
        
    }

?>