<?php
    // Todos los modelos heredan de la clase model y implementar la interfaz IModel la cual nos permitira hacer el crud.
    class UserModel extends Model implements IModel{

        // creamos los atributos de nuestra clase que son las columnas de nuestra base de datos
        private $idRol;
        private $idEstado;
        private $idFoto;
        private $idHorario;
        private $documento;
        private $tipoDocumento;
        private $nombres;
        private $apellidos;
        private $telefono;
        private $direccion;
        private $correo;
        private $password;

        public function __construct() {
            parent::__construct();

            // Inicializamos los atributos
            $this->idRol = 0;
            $this->idEstado = 0;
            $this->idFoto = 0;
            $this->idHorario = 0;
            $this->documento = '';
            $this->tipoDocumento = '';
            $this->nombres = '';
            $this->apellidos = '';
            $this->telefono = '';
            $this->direccion = '';
            $this->correo = '';
            $this->password = '';


        }

        // Implemenatmos los metodos de la interfaz
        public function save() {
            // Save is going to help to insert new data

            try {
                // guardamos la consulta y la preparamos antes de ejecutarla para evitar problemas de seguridad
                $query = $this->prepare('INSERT INTO usuarios(id_rol, id_estado, documento, tipo_documento, nombres, apellidos, telefono, direccion, correo, password, id_foto, id_horario)
                VALUES (:id_rol, :id_estado, :documento, :tipo_documento, :nombres, :apellidos, :telefono, :direccion, :correo, :password, :id_foto, id_horario)');

                // Ejecutamos la query y hacemos la referencia de los placeholders a los atributos de la clase
                $query->execute([
                    'id_rol' => $this->idRol,
                    'id_estado' => $this->idEstado,
                    'documento' => $this->documento,
                    'tipo_documento' => $this->tipoDocumento,
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion,
                    'correo' => $this->password,
                    'id_foto' => $this->idFoto,
                    'id_horario' => $this->idHorario,
                ]);
                // salimos de la funcion
                return;
            }catch(PDOException $e) {
                error_log('USERMODEL::save->PDOException'.$e);
                // salimos de la funcion
                return;
            }
        }

        // la funcion getAll() nos permitira obtenr todos los usuarios medio un arreglo de objetos
        public function getAll() {

            // getAll() is going to return an object array so we must create a variable to store that data
            $items = [];
            try {
                // guardamos la consulta con query porque no estamos insertando data
                $query = $this->query('SELECT * FROM usuarios');
                // iteramos con un while para extraer la data con fetch y FETCH_ASSOC para almacenarla
                // FETCH_ASSOCretorna un objeto de clave y valor
                while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    // // a cada elemento de la db le creamos un nuevo UserModel para rellenar sus respectivos campos con los setters
                    $item = new UserModel();

                    $item->setIdRol($row['id_rol']);
                    $item->setIdEstado($row['id_estado']);
                    $item->setIdFoto($row['id_foto']);
                    $item->setIdHorario($row['id_horario']);
                    $item->setDocumento($row['documento']);
                    $item->setTipoDocumento($row['tipo_documento']);
                    $item->setNombres($row['nombres']);
                    $item->setApellidos($row['apellidos']);
                    $item->setTelefono($row['telefono']);
                    $item->setDireccion($row['direccion']);
                    $item->setCorreo($row['correo']);
                    $item->setPassword($row['password'], false);
                    
                    // Ya que asignamos todo lo necesario, lo vamos agregar a items para que al final tenga de elementos de tipo userModel
                    array_push($items, $item);
                }

                // finalmente reotrnamos el arreglo
                return $items;

            }catch(PDOException $e) {
                error_log('USERMODEL::getAll->PDOException' . $e);
            }
        }



        // funcion para obtener un usuario en especifico
        public function get($documento) {


            try {
                // we have to use prepare because we're going to assing
                $query = $this->prepare('SELECT * FROM usuarios WHERE documento = :documento');
                $query->execute([
                    'documento'=> $documento
                ]);
                // Como solo queremos obtener un valor, no hay necesidad de tener un while
                $user = $query->fetch(PDO::FETCH_ASSOC);
                
                // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
                $this->setIdRol($user['id_rol']);
                $this->setIdEstado($user['id_estado']);
                $this->setIdFoto($user['id_foto']);
                $this->setIdHorario($user['id_horario']);
                $this->setDocumento($user['documento']);
                $this->setTipoDocumento($user['tipo_documento']);
                $this->setNombres($user['nombres']);
                $this->setApellidos($user['apellidos']);
                $this->setTelefono($user['telefono']);
                $this->setDireccion($user['direccion']);
                $this->setCorreo($user['correo']);
                $this->setPassword($user['password'], false);
                
                //retornamos this porque es el mismo objeto que ya contiene la informacion
                return $this;
            } catch (PDOException $e) {
                error_log('USERMODEL::getId->PDOException' . $e);
            }
        }
        
        // funcion para eliminar un usuario
        public function delete($documento) {
            try {
                $query = $this->prepare('DELETE FROM usuarios WHERE documento= :documento');
                $query->execute([
                    'documento'=> $documento
                ]);


                return;
            }catch(PDOException $e) {
                error_log('USERMODEL::delete->PDOException' . $e);
                return;
            }
        }

        // function para actualizar un usuario
        // no recibe parametro porque va llamar get primero para obtener la data 
        // entonces alli get va asignar los valores para evitar traerlos en este caso.
        public function update() {

            try {
                // we have to use prepare because we're going to assing
                $query = $this->prepare('UPDATE usuarios SET id_rol = :id_rol, id_estado = :id_estado, id_foto = :id_foto, id_horario = :id_horario, tipo_documento = :tipo_documento, nombres = :nombres, apellidos = :apellidos, telefono = :telefono, direccion = :direccion, correo = :correo, password = :password WHERE documento = :documento');
                $query->execute([
                    'documento'=> $this->documento,
                    'id_rol' => $this->idRol,
                    'id_estado' => $this->idEstado,
                    'id_foto' => $this->idFoto,
                    'id_horario' => $this->idHorario,
                    'tipo_documento' => $this->tipoDocumento,
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion,
                    'correo' => $this->correo,
                    'password' => $this->password,
                ]);

                return true;
            } catch (PDOException $e) {
                error_log('USERMODEL::update->PDOException' . $e);

                return false;
            }
        }

        // esta funcion va asignar los campos de un arreglo a los atributos de mi clase
        public function from($array) {


            $this->idRol         = $array['id_rol'];
            $this->idEstado      = $array['id_estado'];
            $this->idFoto        = $array['id_foto'];
            $this->idHorario     = $array['id_horario'];
            $this->documento     = $array['documento'];
            $this->tipoDocumento = $array['tipo_documento'];
            $this->nombres       = $array['nombres'];
            $this->apellidos     = $array['apellidos'];
            $this->telefono      = $array['telefono'];
            $this->direccion     = $array['direccion'];
            $this->correo        = $array['correo'];
            $this->password      = $array['password'];
        }

        // esta funcion nos permitira validar si ya existe un usuario con ese documento o correo
        public function existUser($documento, $correo) {
            // this method is going to return true or false if the registered user is already in the database
            try { 
                $query = $this->prepare('SELECT documento, correo FROM usuarios WHERE documento = :documento OR  correo = :correo');
                $query->execute([
                    'documento'=>$documento, 
                    'correo' => $correo
                ]);

                //Si al momento de contar el resultado de la query y es mayor a cero eso significa que 
                // ya existe un usuario con ese correeo o documento
                if($query->rowCount() > 0) {
                    return true;
                }else { 
                    return false;
                }
            }catch(PDOException $e) {
                error_log('USERMODEL::existsUser->PDOException' . $e);
                return;
            }
        }

        public function comparePasswords($password, $documento) { 
            try {
                // no hay la necesidad de hacer la consulta para traer el usuario porque ya tenemos un metodo que hace eso
                $user = $this->get($documento);

                // la funcion password_verify() nos permite validar dado un hash y un password si son los mismos
                // validando que el password que ingrese el usuario sea el mismo que tenemos almacenado en la base de datos
                return password_verify($password, $user->getPassword());

            }catch(PDOException $e) { 
                error_log('USERMODEL::comparepasswords->PDOException' . $e);
                return false;
            }
        }

        // esta funcion nos permitira crear un hash para la seguridad de la contraseña
        private function getHashedPassword($password) {
            // password_hash nos retorna un hash basado en unas condiciones que le demos
            // con PASSWORD_DEFAULT le decimos a php que escoja el mejor algoritmo
            // cost son las veces que va aplicar el algoritmo, pero se debe tener cuidado 
            // por que al decirle demasiadas veces va tener un constro de procesamiento mayor
            return password_hash($password, PASSWORD_DEFAULT,['cost' => 10]);
        }


        // Create getters and setters

        public function setIdRol($id){             $this->idRol = $id;}
        public function setIdEstado($id){         $this->idEstado = $id;}
        public function setIdFoto($id){     $this->idFoto = $id;}
        public function setIdHorario($id){       $this->idHorario = $id;}
        public function setDocumento($documento){         $this->documento = $documento;}
        public function setTipoDocumento($tipoDoc){         $this->tipoDocumento = $tipoDoc;}
        public function setNombres($nombres){         $this->nombres = $nombres;}
        public function setApellidos($apellidos){         $this->apellidos = $apellidos;}
        public function setTelefono($telefono){         $this->telefono = $telefono;}
        public function setDireccion($direccion){         $this->direccion = $direccion;}
        public function setCorreo($correo){         $this->correo = $correo;}


        // la funcion para establecer el password va ser diferentee ya que tenemos que darle un hash para la bd
        public function setPassword($password, $hash = true){ 
            if($hash){
                // asignamos una funcion que nos permitira hacer el hash de la constraseña
                $this->password = $this->getHashedPassword($password);
            }else{
                $this->password = $password;
            }
        }

        public function getIdRol(){           return $this->idRol;}
        public function getIdEstado(){        return $this->idEstado;}
        public function getIdFoto(){          return $this->idFoto;}
        public function getIdHorario(){       return $this->idHorario;}
        public function getDocumnto(){        return $this->documento;}
        public function getTipoDocumento(){   return $this->tipoDocumento;}
        public function getNombres(){         return $this->nombres;}
        public function getApellidos(){       return $this->apellidos;}
        public function getTelefono(){        return $this->telefono;}
        public function getDireccion(){       return $this->direccion;}
        public function getCorreo(){          return $this->correo;}
        public function getPassword(){        return $this->password;}
    }

?>