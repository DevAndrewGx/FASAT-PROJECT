<?php 
    // las clases que tengan la inicial join nos permitiran realizar joins entre tablas para evitar la repeticion de codigo
    class JoinUserRolModel extends Model { 

        private $idRol;
        private $rol;
        private $documento;
        private $correo;
        private $nombres;
        private $password;


        public function __construct()
        {
            parent::__construct();
        }


        public function from($array) {
            $this->idRol= $array['id_rol'] ?? null;
            $this->rol = $array['rol'] ?? '';
            $this->documento = $array['documento'] ?? '';
            $this->correo = $array['correo'] ?? '';
            $this->nombres = $array['nombres'] ?? '';
            $this->password = $array['password'] ?? '';
        }


        public function getIdRol() { return $this->idRol; }
        public function getRol() { return $this->rol; }
        public function getDocumento() { return $this->documento; }
        public function getCorreo() { return $this->correo; }
        public function getNombres() { return $this->nombres; }
        public function getPassword() { return $this->password; }

        // public function setExpenseId($value) { $this->expenseId = $value; }
        // public function setTitle($value) { $this->title = $value; }
        // public function setCategoryId($value) { $this->categoryId = $value; }
        // public function setAmount($value) { $this->amount = $value; }
        // public function setDate($value) { $this->date = $value; }
        // public function setUserId($value) { $this->userId = $value; }
        // public function setNameCategory($value) { $this->nameCategory = $value; }
        // public function setColor($value) { $this->color = $value; }
    }
?>