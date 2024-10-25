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
        $this->view->render('admin/gestionEmpleados', [
            'user' => $this->user
        ]);
    }

    // Metodo para crear un nuevo usuario
    function createUser()
    {

        error_log('Users::createUser -> Funcion para crear un nuevo usuario');
        // validamos la data que viene del formulario, en este caso la negamos para el primer caso
        if (!$this->existPOST(['documento', 'nombres', 'apellidos', 'telefono', 'email', 'rol', 'estado', 'password', 'validarPassword'] && !$this->existFILES('foto'))) {
            // Redirigimos otravez al dashboard
            error_log('Users::createUser -> Hay algun error en los parametros enviados en el formulario');

            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER_EMPTY]);
            return;
        }

        if ($this->user == NULL) {
            error_log('Users::createUser -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('Users::createUser -> Es posible crear un nuevo usuario');
        // creamos un objeto de tipo user
        $userModel = new UsersModel();
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
        $this->createPhoto($fotoModel, "Users");

        // Primero validamos que el usuario que se esta tratando de ingresar no exista en la bd
        if (!$userModel->existUser($this->getPost('documento'), $this->getPost('email'))) {
            // insertamos primero la foto
            if ($fotoModel->crear()) {
                error_log('Users::createUser -> Se guardó la foto correctamente');
                $idFoto = $fotoModel->getIdFoto();
                error_log('Users::createUser -> idFoto: ' . $idFoto);

                if ($idFoto) {
                    $userModel->setIdFoto($idFoto);
                    if ($userModel->crear()) {
                        error_log('Users::createUser -> Se guardó el usuario correctamente');
                        echo json_encode(['status' => true, 'message' => "El usuario fue creado exitosamente!"]);
                        return;
                    } else {
                        error_log('Users::createUser -> No se guardó el usuario');
                        echo json_encode(['status' => false, 'message' => "Hubo un problema al agregar usuario, intentalo nuevamente"]);
                        return;
                    }


                } else {
                    error_log('Users::createUser -> No se obtuvo el id de la foto');
                    echo json_encode(['status' => false, 'message' => "No se guardo la foto correctamente code: 500"]);
                }
            } else {
                error_log('Users::createUser -> No se guardó la foto correctamente');
                echo json_encode(['status' => false, 'message' => "No se guardo la foto correctamente code: 500"]);
            }
        } else {
            error_log('Users::createUser -> El documento o email ya existen en la db');
            echo json_encode(['status' => false, 'message' => "El documento o correo ya existen en el sistema, intentelo nuevamente"]);
            return;
        }

    }


    public function getUsers()
    {
        try {
            header('Content-Type: application/json');

            // Verificar si el usuario está autenticado
            if (!$this->existsSession()) {
                http_response_code(401); // Código de estado HTTP 401: No autorizado
                echo json_encode(['error' => 'No autenticado']);
                die();
            }

            // Obtener los parámetros enviados por DataTables
            $draw = intval($_GET['draw']);
            $start = intval($_GET['start']);
            $length = intval($_GET['length']);
            $search = $_GET['search']['value'];
            $orderColumnIndex = intval($_GET['order'][0]['column']);
            $orderDir = $_GET['order'][0]['dir'];
            $columns = $_GET['columns'];
            $orderColumnName = $columns[$orderColumnIndex]['data'];

            // Crear objeto del modelo
            $userRelationObject = new JoinUserRelationsModel();

            // Obtener datos filtrados
            $usersData = $userRelationObject->cargarDatosEmpleados($length, $start, $orderColumnIndex, $orderDir, $search, $orderColumnName);

            // Total de registros después de aplicar filtros de búsqueda
            $totalFiltered = $userRelationObject->totalRegistrosFiltrados($search);

            // Total de registros en la tabla
            $totalRecords = $userRelationObject->totalRegistros();

            $arrayDataUsers = json_decode(json_encode($usersData, JSON_UNESCAPED_UNICODE), true);

            // Iterar sobre el arreglo y agregar 'options' a cada usuario
            for ($i = 0; $i < count($arrayDataUsers); $i++) {
                $arrayDataUsers[$i]['checkmarks'] = '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
                $arrayDataUsers[$i]['options'] = '
                <a class="me-3 confirm-text" href="#" data-id="' . $arrayDataUsers[$i]['documento'] . '" >
                    <img src="' . constant("URL") . '/public/imgs/icons/eye.svg" alt="eye">
                </a>
                <a class="me-3 botonActualizar" data-id="' . $arrayDataUsers[$i]['documento'] . '" data-idfoto="' . $arrayDataUsers[$i]['idFoto'] . '" href="editarEmpleado.php">
                    <img src="' . constant("URL") . '/public/imgs/icons/edit.svg" alt="eye">
                </a>
                <a class="me-3 confirm-text botonEliminar" data-id="' . $arrayDataUsers[$i]['documento'] . '" data-idfoto="' . $arrayDataUsers[$i]['idFoto'] . '" href="editarEmpleado.php">
                    <img src="' . constant("URL") . '/public/imgs/icons/trash.svg" alt="trash">
                </a>
            ';
            }

            $response = [
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $arrayDataUsers,
                "status" => true
            ];

            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            error_log('Error en getUsers: ' . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

    // funcion para verificar y borrar usuarios
    function borrar()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Verificar si los datos fueron recibidos correctamente
        if (isset($data['id_usuario']) && isset($data['id_foto'])) {

            $idUser = $data['id_usuario'];
            $idFoto = $data['id_foto'];
            // Creando un objeto de tipo FotoModel
            $fotoModel = new FotoModel();
            // Eliminar la foto asociada
            if ($fotoModel->borrar($idFoto)) {
                // Eliminar el usuario
                $res = $this->model->borrar($idUser);
                if ($res) {
                    error_log('Users::borrarUser -> Se eliminó el usuario correctamente');
                    echo json_encode(['status' => true, 'message' => "El usuario fue eliminado exitosamente!"]);
                    return true;
                } else {
                    error_log('Users::borrarUser -> No se pudo eliminar el usuario, intente nuevamente');
                    echo json_encode(['status' => false, 'message' => "No se pudo eliminar el usuario, intente nuevamente!"]);
                    return false;
                }
            } else {
                error_log('Users::borrar -> No se pudo eliminar la foto, el ID de la foto es -> ' . $idFoto);
                echo json_encode(['status' => false, 'message' => "No se eliminó la foto correctamente. Código: 500"]);
            }

        }
    }

    function getUser()
    {
        // recuperamos la data del cuerpo de la request
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id_usuario'])) {
            $idUser = $data['id_usuario'];
            // Eliminar traer usuario
            $res = $this->model->get($idUser);
            $arrayData = json_decode(json_encode($res, JSON_UNESCAPED_UNICODE), true);
            if ($arrayData) {
                error_log('Users::get -> El usuario se trajo correctamente-> ' . $res);
                $response = [
                    "data" => $arrayData,
                    "status" => true,
                    "message" => "Se obtuvo la data correctamente"
                ];
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                die();
            } else {
                error_log('Users::borrarUser -> No se pudo obtener el usuario correctamente');
                echo json_encode(['status' => false, 'message' => "No se pudo obtener el usuario!"]);
                return false;
            }
        } else {
            error_log('Users::borrarUser -> No se obtuvo el id del usuario ');
            echo json_encode(['status' => false, 'message' => "No se pudo eliminar el usuario, intente nuevamente!"]);
            return false;
        }
    }

    // funcion para actualizar data
    function actualizarUser()
    {
        error_log('Users::actualizarUser -> Funcion para actualizar un usuario');
        // validamos la data que viene del formulario, en este caso la negamos para el primer caso
        if (!$this->existPOST(['documento', 'nombres', 'apellidos', 'telefono', 'email', 'rol', 'estado', 'password', 'validarPassword'] && !$this->existFILES('foto'))) {
            // Redirigimos otravez al dashboard
            error_log('Users::udpateUser -> Hay algun error en los parametros enviados en el formulario');

            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER_EMPTY]);
            return;
        }
        if ($this->user == NULL) {
            error_log('Users::actualizarUser -> El usuario de la session esta vacio');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => ErrorsMessages::ERROR_ADMIN_NEWDATAUSER]);
            return;
        }
        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('Users::actualizarUser -> Es posible actualizar un usaurio');

        // creamos un objeto de tipo user
        $userModel = new UsersModel();
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
        // llamamos la funcion para crear una imagen ya que nos permitira setear la nueva data en nuevo objeto
        $this->createPhoto($fotoModel, "Users");

        // validamos primero si la foto se actualiza en la tablas fotos y despues actualiamos la data del usuario
        // idFoto para actualizar la data
        $idFoto = $this->getPost('id_foto');
        if ($fotoModel->actualizar($idFoto)) {
            error_log("Users::actualizarUser -> el id de la foto es -> " . $idFoto);
            $userModel->setIdFoto($idFoto);
            // actualizamos la data del usuario
            $res = $userModel->actualizar($this->getPost("id_usuario"));
            // validamos si la consulta o la respuesta es correcta
            if ($res) {
                error_log('Users::actualizarUser -> Se actualizo el usuario correctamente');
                echo json_encode(['status' => true, 'message' => "El usuario fue actualizado exitosamente!"]);
                return;
            } else {
                error_log('Users::actualizarUser -> Error en la consulta del Back');
                echo json_encode(['status' => false, 'message' => "Error 500, nose actualizo la data!"]);
                return;
            }
        } else {
            error_log('Users::actualizarUser -> No se pudo actualizar la foto');
            echo json_encode(['status' => false, 'message' => "Error 500, NO se actualizo la foto!"]);
            return;
        }
    }
}


