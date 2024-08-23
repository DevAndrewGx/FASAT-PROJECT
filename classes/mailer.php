<?php


use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer
{
    function enviarEmail($correo, $asunto, $cuerpo)
    {
        // require_once '../config/config.php';
        // require '../PHPMailer-6.9.1/src/PHPMailer.php';
        // require '../PHPMailer-6.9.1/src/SMTP.php';
        // require '../PHPMailer-6.9.1/src/Exception.php';


        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;   // SMTP::DEBUG_OFF;                  //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPDebug = 0; // Establece el nivel de depuración a 0 para desactivar la salida del log

            //Correo emisor y nombre
            $mail->setFrom(MAIL_USER, 'Software FAST');
            // Correo receptor y nombre
            $mail->addAddress($correo); // Usar la dirección de correo electrónico del formulario como destinatario

            //Contenido
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;

            // Cuerpo del correo
            $mail->Body    = utf8_decode($cuerpo);
            $mail->setLanguage('es', '../PHPMailer-6.9.1/PHPMailer/language/phpmailer.lang-es.php');

            // Enviar correo
            if($mail->send()){
                return true;
            } else {
                return false;
            }
            
        } catch (Exception $e) {
            echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
            return false;
        }
    }
}
