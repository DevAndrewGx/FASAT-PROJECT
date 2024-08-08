<?php

class CambiarPassword extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        error_log('CambiarPassword::render -> Carga la pagina principal para cambiar password');
        $this->view->render('login/resetPassword', []);
    }


    function sendEmail()
    {
        error_log('Email::SendEmail -> Funcion para enviar un email');


        if (!$this->existPOST("email")) {
            // Redirigimos otravez al dashboard
            error_log('CambiarPassword::sendEmal -> No existen parametros');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "Hay algo mal en los parametros"]);
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('CambiarPassword::sendEmail -> Se puede enviar un correo');


        // creamos el objeto de email para hacer las validaciones y enviar el correo

        $emailObject = new EmailModel();
        $emailObject->setEmail($this->getPost("email"));

        if ($emailObject->emailExiste()) {

            // En esta caso solicitamos un nuevo password y realizar la respectiva validación
            if ($emailObject->solicitaPassword()) {


                error_log("CambiarPassword::sendEmail -> se solicito correctamente el tocken para el ingreso");


                // Validamos que el correo sea diferente de nulo para enviar el correo
                if ($emailObject->getToken() != null) {

                    $emailObject->getuserDocumento();
                    // Creamos un objeto de tipo mailer para hacer el envio de correo
                    $mailer = new Mailer();
                    // Creamos un objeto de tipo user para traer y mostrar la data en el correo generado
                    $userObject = new UsersModel();
                    // $userObject->setDocumento($emailObject->getDocumento());
                    $userObject->get($emailObject->getDocumento());


                    $url = URL . 'cambiarpassword?documento=' . $userObject->getDocumento() . '&token=' . $emailObject->getToken();


                    $asunto = "Recuperar password - Fast";
                    $cuerpo = "Estimado " . $userObject->getNombres() . ": <br> Si has solicitado el cambio de tu contraseña da click en el 
                    <a href='$url'>siquiente link</a> <br><p style='color: red'>Si no hiciste esta solicitud puedes ignorar este correo.</p> ";
                    // $cuerpo = "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

                    if ($mailer->enviarEmail($emailObject->getEmail(), $asunto, $cuerpo)) {
                        echo "<p><b>Correo enviado</b></p>" . $emailObject->getEmail();
                        echo "<p>Hemos enviado un correo electronico a la siquiente diireccion" . $emailObject->getEmail() . "para restablecer la contraseña</p>";
                        echo json_encode(['status' => true, 'message' => "El correo fue enviado correctamente"]);
                        exit;
                    }
                }
            }
        }
    }

    function changePassword()
    {

        // validamos el token y el documento que vienen de la url
        if (!$this->existGET('documento', 'token')) {
            // Redirigimos otravez al dashboard
            error_log('CambiarPassword::changePasswor -> No existen parametros');
            // enviamos la respuesta al front para que muestre una alerta con el mensaje
            echo json_encode(['status' => false, 'message' => "Hay algo mal en los parametros"]);
            return;
        }

        // si no entra a niguna validacion, significa que la data y el usuario estan correctos
        error_log('CambiarPassword::changePassword -> se puede cambiar la contraseña');

        // creamos un objeto de emailModel para validar el token
        $emailObject = new EmailModel();
        if (!$emailObject->verificarTokenRequest($this->getPost('token'), $this->getPost('documento'))) {
            echo json_encode(['status' => false, 'message' => "No se puede obtener los parametros de la URL"]);
            var_dump($this->getPost('token'));
            var_dump($this->getPost('documento'));
            var_dump($this->getPost('password'));
            var_dump($this->getPost('repassword'));
            return;
        }

        // verificamos que las contraseñas vengan del formulario

        if ($this->getPost('password') && $this->getPost('repassword')) {

            $password = trim($this->getPost('password'));
            $repassword = trim($this->getPost('repassword'));

            // verificamos que las contraseñas sean iguales
            if ($this->validarPassword($password, $repassword)) {
                // Se crea un nuevo hash para la contraseña nueva
                $pass_hash = password_hash($password, PASSWORD_DEFAULT);

                if ($emailObject->actualizaPassword($pass_hash)) {
                    echo json_encode(['status' => true, 'message' => "La contraseña fue actualizada correctamente"]);
                    return;
                }
            }
        }
    }

    // Utilizamos esta funcion para validar que las claves sean iguales atraves
    // del metodo strcmp que retorna 0 si los dos strings son iguales
    function validarPassword($password, $repassword)
    {
        if (strcmp($password, $repassword) === 0) {
            return true;
        }
        return false;
    }



    // $user_id = $_GET['documento'] ?? $_POST['user_id'] ?? '';
    // $documento = $_GET['token'] ?? $_POST['token'] ?? '';

    // if($user_id == '' || $token == '' ){
    //     header("Location: index.php"); //regresa al inicio
    //     exit;
    // }


    // $errors = [];

    // if(!verificarTokenRequest($user_id, $token, $con )){

    //     echo "No se pudo verificar la informacion";
    //     exit;
    // }

    // if (!empty($_POST)) {
    //     $password = trim($_POST['password']);
    //     $repassword = trim($_POST['repassword']);

    //     if (esNulo([$user_id, $token, $password, $repassword])) {
    //         $errors[] = "Debe llenar todos los campos";
    //     }

    //     if (!validarPassword([$password, $repassword])) {
    //         $errors[] = "Las contraseñas no coinciden";
    //     }

    //     if(count($errors)== 0){
    //         $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    //         if (actualizaPassword($user_id, $password, $conn)){
    //             echo "Contraseña modificada.<br><a href='login.php'>Iniciar sesion</a>";
    //             exit;
    //         }   else{
    //             $errors[] = "Error al modificar contraseña. Intentalo nuevamente";
    //         }
    //     }
    // }
}
