<?php 

    class Login extends SessionController{
        
        function __construct() { 
            
            // llamamos al constructor de controller para tener sus caracteritisticas
            parent::__construct();
            error_log('Login::construct -> inicio de login');  
        }

        function render() { 
            error_log('Login::render -> Carga la pagina principal del login');
            $this->view->render('login/index');
        }

        // la funcion autenticar nos va ayudar a validar si existen el usuario el password
        function authenticate()
        {
            // validamos si existe la data
            if ($this->existPOST(['correo', 'password'])) {
                $correo = $this->getPost('correo');
                $password = $this->getPost('password');
                // $documento = $this->getPost('documento');

                // validamos que la data no este vacia ni nulla
                if ($correo == '' || empty($correo) || $password == '' || empty($password)) {
                    //$this->errorAtLogin('Campos vacios');
                    error_log('Login::authenticate() empty');
                    // redirigimos al usuario al login
                    $this->redirect('login', ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
                    return;
                }

                $user = NULL;
                // error_log('Login::documento '. $documento);
                // si el login es exitoso regresa solo el ID del usuario
               
                $user = $this->model->loginBycorreo($correo, $password);
                
                // error_log("Login::error -> ". $user);
                // si el usuario es diferente de null eso significa que si se autentico el usuario
                if ($user != NULL) {


                    // Verificamos si la cuenta está bloqueada
                    if ($user->getEstado() === 'Bloqueado') {
                        error_log('Login::authenticate() user blocked');
                        // Si la cuenta está bloqueada, respondemos con un mensaje de error
                        if ($this->isAjaxRequest()) {
                            echo json_encode(['status' => false, 'errorCode' => 'ACCOUNT_BLOCKED', 'message' => 'Tu cuenta está bloqueada.']);
                            exit;
                        } else {
                            // Redirigimos a una página de error para cuentas bloqueadas
                            $this->redirect('login', ['error' => 'Tu cuenta está bloqueada.']);
                            return;
                        }
                    }

                    // inicializa el proceso de las sesiones
                    error_log('Login::authenticate() passed');
                    $this->initialize($user);
                } else {
                    //error al registrar, que intente de nuevo
                    //$this->errorAtLogin('Nombre de usuario y/o password incorrecto');
                    error_log('Login::authenticate() user and/or password wrong');
                    $this->redirect('login', ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
                    return;
                }
            } else {
                // error, cargar vista con errores
                //$this->errorAtLogin('Error al procesar solicitud');
                error_log('Login::authenticate() error with params');
                $this->redirect('login', ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE]);
            }
        }


         // Función para cambiar la contraseña del usuario

    public function setPassword() {
        // Definición de la función strClean dentro de setPassword
        function strClean($str) {
            return trim($str); 
        }   

        // setPassword
        if (empty($_POST['identificacion']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {
            $arrResponse = array(
                'status' => false,
                'msg' => 'Error de datos'
            );
        } else {
            $intIdpersona = intval($_POST['identificacion']);
            $strPassword = $_POST['txtPassword'];
            $strPasswordConfirm = $_POST['txtPasswordConfirm'];
            $strEmail = strClean($_POST['txtEmail']);
            $strToken = strClean($_POST['txtToken']);

            if ($strPassword != $strPasswordConfirm) {
                $arrResponse = array(
                    'status' => false,
                    'msg' => 'Las contraseñas no son iguales.'
                );
            } else {
                $arrResponseUser = $this->model->getUsuario($strEmail, $strToken, $intIdpersona);
                if (empty($arrResponseUser)) {
                    $arrResponse = array(
                        'status' => false,
                        'msg' => 'Error de datos.'
                    );
                } else {
                    $strPassword = hash("SHA256", $strPassword);
                    $requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

                    if ($requestPass) {
                        $arrResponse = array(
                            'status' => true,
                            'msg' => 'Contraseña actualizada con éxito.'
                        );
                    } else {
                        $arrResponse = array(
                            'status' => false,
                            'msg' => 'No es posible realizar el proceso, intente más tarde.'
                        );
                    }
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Función para verificar si la solicitud es AJAX
    private function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    }
?>