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
        if(!$this->existPOST(['documento', 'nombres', 'apellidos', 'telefono', 'email', 'rol', 'estado', 'password', 'validarPassword'] && !$this->existFILES('foto'))) {
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
        // llamamos la funcion para crear una imagen
        // var_dump($this->getPost('foto'));
        $this->createPhoto($fotoModel, 'foto');

        // insertamos primero la foto
        if ($fotoModel->save()) {
            error_log('Users::createUser -> Se guardó la foto correctamente');
            $idFoto = $fotoModel->getIdFoto();
            error_log('Users::createUser -> idFoto: ' . $idFoto);

            if ($idFoto) {
                $userModel->setIdFoto($idFoto);

                if ($userModel->save()) {
                    error_log('Users::createUser -> Se guardó el usuario correctamente');
                    $this->redirect('users', []);
                } else {
                    error_log('Users::createUser -> No se guardó el usuario');
                }
            } else {
                error_log('Users::createUser -> No se obtuvo el id de la foto');
            }
        } else {
            error_log('Users::createUser -> No se guardó la foto correctamente');
        }
    }
    
    function createPhoto(FotoModel $fotoObjeto, $foto) {
        // En este caso que tenemos la foto podemos moverla a uploads y guardarla alli
        $foto = isset($_FILES[$foto]) ? $_FILES[$foto]: null;
        // creamos el directorio de destino donde queremos guardar la imagen
        $directorioDestino = 'public/imgs/uploads/'; 

        // obtenemos el nombre de la foto
        $nombreFoto = pathinfo($foto['name'], PATHINFO_FILENAME); // Nombre del archivo sin extensión
        $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION)); // Extensión del archivo en minúsculas

        // le damos un hash a la imagen por seguridad
        $hash = md5((Date('Ymdgi')) . $nombreFoto) . '.' . $ext;
        // construirmos el archivo final
        $archivoDestino = $directorioDestino . $hash;
        $uploadIsOk = false;
        
        // luego verificamos si el archivo que se subio es una imagen valida
        $check = getimagesize($foto['tmp_name']);

        if ($check != false) {
            // cambiabamos la variable bandera a true ya que es una imagen valida
            $uploadIsOk = true;
        } else {
            $uploadIsOk = false;
        }

        // validamos que la subida del archivo sea valida
        if (!$uploadIsOk) {
            $this->redirect('Users', []);
            return;
        } else {
            // ya que la imagen es valida la movemos y la establecemos
            if (move_uploaded_file($foto['tmp_name'], $archivoDestino)) {
                // seteamos la foto y el tipo
                $fotoObjeto->setFoto($hash);
                $fotoObjeto->setTipo($this->getPost('tipoFoto'));
            }
        }
    }
}


