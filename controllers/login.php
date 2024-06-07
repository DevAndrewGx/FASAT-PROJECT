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
    }
?>