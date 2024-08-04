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
        $this->view->render('login/index#form-forgetpassword', []);
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


                    $url = URL . '/reset_password.php?documento' . $userObject->getDocumento() . '&token=' . $emailObject->getToken();


                    $asunto = "Recuperar password - Fast";
                    $cuerpo = "Estimado" . $userObject->getNombres() . ": <br> Si has solicitado el cambio de tu contraseña da click en el 
                    // siquiente link <a href='$url'</a>";
                    $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

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


    // $errors = [];
    // if (!empty($_POST)){
    //     $correo = trim(['correo']);

    //     if(esNulo([$correo])) {
    //         $errors[] = "Debe llenar todos los campos";
    //     }
    //$documento = $_GET['documento'] ?? $_POST['user_id'] ?? '';

    //     if((!esEmail()[$correo])) {
    //         $errors[] = "Debe llenar todos los campos";
    //     }

    //     if(count($errors)==0){
    //         if(emailExiste($correo)){
    //            $sql = $this->query("SELECT documento, nombre FROM usuarios WHERE correo LIKE ? LIMIT 1");
    //            $sql->execute([$correo]);
    //            $row = $sql->fetch(PDO::FETCH_ASSOC);
    //            $user_id = $row['documento'];
    //            $nombres = $row['nombre'];

    //            $token = solicitaPassword($user_id, $con);

    //             if($token !== null){
    //                 require 'clases/Mailer.php';
    //                 $mailer = new Mailer();

    //                 $url = URL . '/reset_password.php?documento' . $documento . '&token=' . $token;


    //                 $asunto = "Recuperar password - Fast";
    //                 $cuerpo = "Estimado $nombre: <br> Si has solicitado el cambio de tu contraseña da click en el 
    //                 siquiente link <a href='$url'</a>"; 
    //                 $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

    //                 if ($mailer->enviarEmail($correo, $asunto, $cuerpo)){
    //                     echo "<p><b>Correo enviado</b></p> $correo";
    //                     echo "<p>Hemos enviado un correo electronico a la siquiente diireccion $correo para restablecer la
    //                     contraseña</p>";
    //                     exit;
    //                 }
    //             }
    //         } else {
    //             $errors[] = "No existe una cuenta asociada a esta direccion de correo";
    //         }   

    //     }

    // }
}
