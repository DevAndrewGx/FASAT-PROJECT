<?php

class JoinUserRelationsModel extends Model implements JsonSerializable
{
    private $documento;
    private $nombres;
    private $apellidos;
    private $idFoto;
    private $foto;
    private $telefono;
    private $correo;
    private $idEstado;
    private $estado;
    private $fechaCreacion;
    private $idRol;
    private $rol;
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->documento = '';
        $this->nombres = '';
        $this->idFoto = 0;
        $this->foto = '';
        $this->apellidos = '';
        $this->telefono = '';
        $this->correo = '';
        $this->estado = '';
        $this->fechaCreacion = '';
        $this->idRol = 0;
        $this->rol = '';
    }

    public function get($correo)
    {

        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT u.*, r.id_rol, r.rol, e.id_estado, e.tipo, f.id_foto, f.foto FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol JOIN estados_usuarios e ON e.id_estado = u.id_estado JOIN fotos f ON f.id_foto = u.id_foto WHERE u.correo  = :correo');
            $query->execute([
                'correo' => $correo
            ]);
            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setIdRol($user['id_rol']);
            $this->setRol($user['rol']);
            $this->setDocumento($user['documento']);
            $this->setCorreo($user['correo']);
            $this->setNombres($user['nombres']);
            $this->setFoto($user['foto']);
            $this->setPassword($user['password'], false);
            $this->setEstado($user['tipo']);

            // print_r($this->getEstado());
            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $this;
        } catch (PDOException $e) {
            error_log('USERMODEL::getId->PDOException' . $e);
        }
    }

    public function getAll()
    {
        $items = [];

        try {
            $query = $this->query('SELECT u.documento, u.nombres, u.apellidos, u.correo, u.telefono, u.fecha_de_creacion, r.id_rol, r.rol, e.id_estado, e.tipo, f.id_foto, f.foto FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol JOIN estados_usuarios e ON e.id_estado = u.id_estado JOIN fotos f ON f.id_foto = u.id_foto');

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new JoinUserRelationsModel();
                $item->from($row);
                
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            error_log('JoinUserRelationsModel::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public function from($array)
    {
        $this->documento = $array['documento'] ?? null;
        $this->nombres = $array['nombres'] ?? '';
        $this->apellidos = $array['apellidos'] ?? null;
        $this->correo = $array['correo'] ?? '';
        $this->telefono = $array['telefono'] ?? '';
        $this->fechaCreacion = $array['fecha_de_creacion'] ?? '';
        $this->idRol = $array['id_rol'] ?? 0;
        $this->rol = $array['rol'] ?? '';
        $this->idEstado = $array['id_estado'] ?? '';
        $this->estado = $array['estado'] ?? '';            // Asegúrate de que el campo 'estado' se asigna correctamente
        $this->idFoto = $array['id_foto'] ?? 0;
        $this->foto = $array['foto'] ?? '';
    }


    public function jsonSerialize():mixed
    {
        return [
            'documento' => $this->documento,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'fechaCreacion' => $this->fechaCreacion,
            'idRol' => $this->idRol,
            'rol' => $this->rol,
            'idEstado' => $this->idEstado,
            'estado' => $this->estado,
            'idFoto' => $this->idFoto,
            'foto' => $this->foto,
        ];
    }


    public function cargarDatosEmpleados($registrosPorPagina, $inicio, $columna, $orden, $busqueda, $columnName)
    {
        $items = [];

        try {
            $sql = "SELECT u.*, r.rol, e.tipo as estado, f.foto FROM usuarios u 
                JOIN roles r ON u.id_rol = r.id_rol 
                JOIN estados_usuarios e ON u.id_estado = e.id_estado 
                JOIN fotos f ON u.id_foto = f.id_foto";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                u.nombres LIKE '%$searchValue%' OR 
                u.apellidos LIKE '%$searchValue%' OR 
                u.telefono LIKE '%$searchValue%' OR 
                u.documento LIKE '%$searchValue%' OR 
                u.correo LIKE '%$searchValue%' OR 
                r.rol LIKE '%$searchValue%' OR 
                e.tipo LIKE '%$searchValue%' OR 
                u.fecha_de_creacion LIKE '%$searchValue%'";
            }

            if ($columna != null && $orden != null) {
                $sql .= " ORDER BY $columnName $orden";
            } else {
                $sql .= " ORDER BY u.documento DESC";
            }

            if ($registrosPorPagina != null && $registrosPorPagina != -1 || $inicio != null) {
                $sql .= " LIMIT " . $registrosPorPagina . " OFFSET " . $inicio;
            }

            $query = $this->query($sql);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new JoinUserRelationsModel();
                $item->from($p);
                array_push($items, $item);
            }
            return $items;
            
        } catch (PDOException $e) {
            error_log('JoinUserRelationsModel::cargarDatosEmpleados - ' . $e->getMessage());
            return [];
        }
    }


    public function totalRegistros()
    {
        try {
            $query = $this->query("SELECT COUNT(*) as total FROM usuarios");
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('JoinUserRelationsModel::totalRegistros - ' . $e->getMessage());
            return 0;
        }
    }

    public function totalRegistrosFiltrados($busqueda)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol JOIN estados_usuarios e ON u.id_estado = e.id_estado JOIN fotos f ON u.id_foto = f.id_foto";

            if (!empty($busqueda)) {
                $searchValue = $busqueda;
                $sql .= " WHERE 
                    u.nombres LIKE '%$searchValue%' OR 
                    u.apellidos LIKE '%$searchValue%' OR 
                    u.telefono LIKE '%$searchValue%' OR 
                    u.documento LIKE '%$searchValue%' OR 
                    u.correo LIKE '%$searchValue%' OR 
                    r.rol LIKE '%$searchValue%' OR 
                    e.tipo LIKE '%$searchValue%' OR 
                    u.fecha_de_creacion LIKE '%$searchValue%'";
            }

            $query = $this->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log('JoinUserRelationsModel::totalRegistrosFiltrados - ' . $e->getMessage());
            return 0;
        }
    }

    // Getters
    public function getDocumento() { return $this->documento; }
    public function getNombres() { return $this->nombres; }
    public function getApellidos() { return $this->apellidos; }
    public function getCorreo() { return $this->correo; }
    public function getPassword() { return $this->password; }
    public function getIdFoto() { return $this->idFoto; }
    public function getFoto() { return $this->foto; }
    public function getTelefono() { return $this->telefono; }
    public function getIdRol() { return $this->idRol; }
    public function getRol() { return $this->rol; }
    public function getEstado() { return $this->estado; }

    
    public function setIdRol($id){             $this->idRol = $id;}
    public function setRol($rol){         $this->rol = $rol;}
    public function setDocumento($documento){         $this->documento = $documento;}
    public function setCorreo($correo){     $this->correo = $correo;}
    public function setFoto($foto){     $this->foto = $foto;}
    public function setNombres($nombres){       $this->nombres = $nombres;}
    public function setPassword($password){       $this->password = $password;}
    public function setEstado($estado) { return $this->estado = $estado; }

}
?>
