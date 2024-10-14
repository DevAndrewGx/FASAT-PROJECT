<?php 
    class MesasModel extends Model implements IModel { 

        private $numeroMesa;
        private $estado;


        // inicializamos los atributos de la clas con el contstructor y llamamos el contructor padre
        public function __construct() { 

            parent::__construct();
            $this->numeroMesa = 0;
            $this->estado = "";

        }
        public function save() { 

            try { 
                // Creamos la query para guardar mesas, ademas de preparala porque vamos a insertar datos en la BD.
                $query = $this->prepare("INSERT INTO mesas (numero_mesa, estado) VALUES(:numero, :estado)");
                // ejecutamos query y hacemos la referencia de los placeholders a los atributos en la clase
                $query->execute([
                    "numero"=>$this->numeroMesa,
                    "estado"=> $this->estado
                ]);
                // retornamos true para salir de la funcion y para validar que la query se ejecuto correctamente.
                return true;
            }catch(PDOException $e) {
                error_log("Mesas::save -> error ".$e);
            }
        }
        public function get($id) {}
        public function getAll() {}
        public function update($id) {}
        public function delete($id) {}
        public function from($array) {}


        // GETTERS Y SETTERS
        
        public function getNumeroMesa() {return $this->numeroMesa;}
        public function getEstado() {return $this->estado;}

        public function setNumeroMesa($numero) {$this->numeroMesa = $numero;}
        public function setEstado($estado) {$this->estado = $estado;}
    }
?>