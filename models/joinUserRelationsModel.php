<!-- Esta clase nos servira para realizar el JOIN entre las tablas principales con las que estan relacionadas USUARIOS (FOTOS, ESTADOS, ROLES, USUARIOS) -->
<?php
class JoinUserRelationsModel extends Model
{

    // atributos de la clase
    private $documento;
    private $nombres;
    private $apellidos;
    private $idFoto;
    private $foto;
    private $telefono;
    private $correo;
    private $estado;
    private $idRol;
    private $rol;


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
        $this->idRol = 0;
        $this->rol = '';
    }


    public function getAll()
    {
        $items = [];

        try {
            $query = $this->prepare('SELECT u.documento, u.nombres,u.apellidos, u.documento, u.telefono, u.fecha_de_creacion, r.rol, e.tipo, f.foto FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol JOIN estados_usuarios e ON e.id_estado = u.id_estado JOIN fotos f ON f.id_foto = u.id_foto');


            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item  = new JoinUserRelationsModel();
                $item->from($p);
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('JoinExpensesCategoriesModel::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public function from($array)
    {
        $this->documento = $array['documento'] ?? null;
        $this->nombres = $array['nombres'] ?? '';
        $this->apellidos = $array['apellidos'] ?? null;
        $this->idFoto = $array['id_foto'] ?? 0;
        $this->foto = $array['foto'] ?? '';
        $this->telefono = $array['telefono'] ?? null;
        $this->correo = $array['correo'] ?? '';
        $this->estado = $array['estado'] ?? '';
        $this->idRol = $array['id_rol'] ?? 0;
        $this->rol = $array['rol'] ?? '';
    }

    // FROM OBJECT TO ARRAY
    public function toArray()
    {
        $array = [];
        $array['documento'] = $this->documento;
        $array['nombres'] = $this->nombres;
        $array['apellidos'] = $this->apellidos;
        $array['id_foto'] = $this->idFoto;
        $array['foto'] = $this->foto;
        $array['telefono'] = $this->telefono;
        $array['correo'] = $this->correo;
        $array['estado'] = $this->estado;
        $array['id_rol'] = $this->idRol;
        $array['rol'] = $this->rol;

        return $array;
    }

    public function getDocumento() { return $this->documento; }
    public function getNombres() { return $this->nombres; }
    public function getApellidos() { return $this->apellidos; }
    public function getIdFoto() { return $this->idFoto; }
    public function getFoto() { return $this->foto; }
    public function getTelefono() { return $this->correo; }
    public function getIdRol() { return $this->idRol; }
    public function getRol() { return $this->rol; }
}


?>