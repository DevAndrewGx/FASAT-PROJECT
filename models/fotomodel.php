<?php 

    class FotoModel extends Model  { 
        
        // creamos los atributos de la clase

        private $idFoto;
        private $foto;
        private $tipo;
        // setters y getters
        public function setIdFoto($id){             $this->idFoto = $id;}
        public function setFoto($foto){         $this->foto = $foto;}
        public function setTipo($tipo){     $this->tipo = $tipo;}

        public function getIdFoto(){           return $this->idFoto;}
        public function getFoto(){        return $this->foto;}
        public function getTipo(){          return $this->tipo;}


        public function __construct() { 
        
            $this->foto = '';
            $this->tipo = '';
        }


        // function para insertar una nueva foto en la db
        public function save() {

            try {
                // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
                $query = $this->prepare('INSERT INTO fotos(foto, tipo)
                VALUES (foto, tipo)');

                // Ejecutamos la query y hacemos la referencia de los placeholders a los atributos de la clase
                $query->execute([
                    'foto' => $this->foto,
                    'tipo' => $this->tipo
                ]);
                // salimos de la funcion
                return;
            }catch(PDOException $e) {
                error_log('FOTOMODEL::save->PDOException'.$e);
                // salimos de la funcion
                return;
            }
        }

        public function getAll() {

            $items = [];
            try {
                // guardamos la consulta con query porque no estamos insertando data
                $query = $this->query('SELECT * FROM fotos');

                // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
                // FETCH_ASSOCretorna un objeto de clave y valor
                while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    // // a cada elemento de la db le creamos un nuevo UserModel para rellenar sus respectivos campos con los setters
                    $item = new FotoModel();
                    $item->setFoto($row['foto']);
                    $item->setTipo($row['tipo']);
                    
                    // Ya que asignamos todo lo necesario, lo vamos agregar a items para que al final tenga de elementos de tipo userModel
                    array_push($items, $item);
                }
                // finalmente reotrnamos el arreglo
                return $items;
            }catch(PDOException $e) {
                error_log('FOTOMODEL::getAll->PDOException'.$e);
                // salimos de la funcion
                return;
            }
        }

        public function get($id) {

        
            try {
                // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
                $query = $this->prepare('SELECT * FROM fotos WHERE id_foto = :id');
                $query->execute([
                    'id'=> $id
                ]);

                // Como solo queremos obtener un valor, no hay necesidad de tener un while
                $foto = $query->fetch(PDO::FETCH_ASSOC);

                // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
                $this->setIdFoto($foto['id_foto']);
                $this->setFoto($foto['foto']);
                $this->setTipo($foto['tipo']);
                
                //retornamos this porque es el mismo objeto que ya contiene la informacion
                return $this;
            }catch(PDOException $e) {
                error_log('FOTOMODEL::getAll->PDOException'.$e);
                // salimos de la funcion
                return;
            }
        }

        public function update() {

            try {
                // we have to use prepare because we're going to assing
                $query = $this->prepare('UPDATE usuarios SET foto = :foto, tipo = :tipo WHERE id_foto = :id');
                $query->execute([
                    'id'=> $this->idFoto,
                    'foto' => $this->foto,
                    'tipo' => $this->tipo,
                ]);
                return true;
            } catch (PDOException $e) {
                error_log('USERMODEL::update->PDOException' . $e);

                return false;
            }
        }
        // funcioin para traer y consultar todas las fotos
    }
?>