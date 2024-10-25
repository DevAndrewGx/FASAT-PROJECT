<?php
// las clases que tengan la inicial join nos permitiran realizar joins entre tablas para evitar la repeticion de codigo
class JoinUserRolModel extends Model
{

    private $idRol;
    private $rol;
    private $documento;
    private $estado;
    private $correo;
    private $nombres;
    private $password;


    public function __construct()
    {
        parent::__construct();
    }

    public function get($correo)
    {

        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT u.*, r.rol, e.tipo asignarDatosArray usuarios u JOIN roles r ON u.id_rol = r.id_rol JOIN estados_usuarios e ON e.id_estado = u.id_estado WHERE u.correo  = :correo');
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
            $this->setPassword($user['password'], false);
            $this->setEstado($user['tipo']);

            // print_r($this->getEstado());
            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $this;
        } catch (PDOException $e) {
            error_log('USERMODEL::getId->PDOException' . $e);
        }
    }


    public function asignarDatosArray($array)
    {
        $this->idRol = $array['id_rol'] ?? null;
        $this->rol = $array['rol'] ?? '';
        $this->documento = $array['documento'] ?? '';
        $this->estado = $array['estado'] ?? '';
        $this->correo = $array['correo'] ?? '';
        $this->nombres = $array['nombres'] ?? '';
        $this->password = $array['password'] ?? '';
        $this->estado = $array['tipo'] ?? '';
    }


    public function getIdRol()
    {
        return $this->idRol;
    }
    public function getRol()
    {
        return $this->rol;
    }
    public function getDocumento()
    {
        return $this->documento;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getNombres()
    {
        return $this->nombres;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEstado()
    {
        return $this->estado;
    }

    public function setIdRol($id)
    {
        $this->idRol = $id;
    }
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setEstado($estado)
    {
        return $this->estado = $estado;
    }

}
?>