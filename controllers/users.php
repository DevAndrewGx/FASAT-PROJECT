<?php
// controlador para modulos empleados

class Users extends SessionController
{
    private $user;

    function __construct()
    {
        parent::__construct();
        // obtenemos el usuario de la session
        $this->user = $this->getUserSessionData();
        error_log('Users::construct -> controlador usuarios');
    }

    function render()
    {
        error_log('Login::render -> Carga la pagina principal de los empleados');
        $this->view->render('admin/gestionEmpleados');
    }

    // Metodo para crear un nuevo usuario
    function createUser() { 

        error_log('Users::createUser');
        // validamos la data que viene del formulario, en este caso la negamos para el primer caso
        if(!$this->existPOST(['nombres', 'documento', 'tipoDocumento', 'email', 'apellidos', 'rol', 'telefono', 'direccion', 'desdeHorario', 'hastaHorario', 'password', 'validarPassword', 'foto'])) {
            // Redirigimos otravez al dashboard
            return;
        }

        if($this->user == NULL) { 
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos

        $userModel = new UserModel();

        // seteamos la data de un nuevo objeto
        $userModel->setNombres($this->getPost('nombres'));
        $userModel->setDocumento($this->getPost('documento'));
        $userModel->setTipoDocumento($this->getPost('tipoDocumento'));
        $userModel->setCorreo($this->getPost('email'));
        $userModel->setApellidos($this->getPost('apellidos'));
        $userModel->setIdRol($this->getPost('rol'));
        $userModel->setTelefono($this->getPost('telefono'));
        $userModel->setDireccion($this->getPost('direccion'));

        

    }
}


