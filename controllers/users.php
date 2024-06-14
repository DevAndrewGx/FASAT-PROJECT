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
        error_log('Users::render -> Carga la pagina principal de los empleados');
        $this->view->render('admin/gestionEmpleados');
    }

    // Metodo para crear un nuevo usuario
    function createUser() { 

        error_log('Users::createUser -> Funcion para crear un nuevo usuario');
        // validamos la data que viene del formulario, en este caso la negamos para el primer caso
        if(!$this->existPOST(['documento', 'nombres', 'apellidos', 'telefono', 'email', 'rol', 'estado', 'password', 'validarPassword','foto'])) {
            // Redirigimos otravez al dashboard
            error_log('Users::createUser -> Hay algun error en los parametros enviados en el formulario');
            return;
        }

        if($this->user == NULL) {
            error_log('Users::createUser -> El usuario de la session esta vacio');
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('Users::createUser -> Es posible crear un nuevo usuario');
        // creamos un objeto de tipo user
        $userModel = new UserModel();
        // seteamos la data de un nuevo objeto
        $userModel->setDocumento($this->getPost('documento'));
        $userModel->setNombres($this->getPost('nombres'));
        $userModel->setApellidos($this->getPost('apellidos'));
        $userModel->setTelefono($this->getPost('telefono'));
        $userModel->setCorreo($this->getPost('email'));
        $userModel->setIdRol($this->getPost('rol'));
        $userModel->setIdEstado($this->getPost('estado'));
        $userModel->setPassword($this->getPost('password'));

        
        // creamos un objeto de tipo foto
        $fotoModel = new FotoModel();
        $fotoModel->setFoto($this->getPost('foto'));
        $fotoModel->setTipo('Usuario');

        // insetamos primero la foto
        if($fotoModel->save()) {
            error_log('Users::createUser -> Se guardo la foto correctamente');
            $idFoto = $fotoModel->getLastInsertId();
            $userModel->setIdFoto($idFoto);

            $userModel->save();
            $this->redirect('users', []);
        }

        error_log('Users::createUser -> No se guardo la foto correctamente');
        


    }
}


