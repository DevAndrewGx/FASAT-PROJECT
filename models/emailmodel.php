<?php

class EmailModel extends Model
{

    private $token;
    private $user_id;
    private $correo;

    // function esNulo(array $parametos)
    // {
    //     foreach ($parametos as $parameto) {
    //         if (strlen(trim($parameto)) < 1) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // function esEmail($correo)
    // {
    //     if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    //         return true;
    //     } else false;
    // }

    // function validarPassword($password, $repassword)
    // {
    //     if (strcmp($password, $repassword) === 0) {
    //         return true;
    //     }
    //     return false;
    // }


    // Esta funcion nos permite verificar si el email ya existe en la base de datos
    function emailExiste()
    {
        try {
            $query = $this->query("SELECT documento FROM usuarios WHERE correo LIKE :correo LIMIT 1");

            $query->execute([
                "correo" => $this->correo
            ]);

            if ($query->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log('EmailModel::EmailExiste->PDOException' . $e);
            return false;
        }
    }

    // Esta funcion nos ayuda a crear tokens, creando un identificador unico y aleatorio y despues 
    // convirtiendolo a un hash de 32 caracteres
    function generarToken()
    {
        return md5(uniqid(mt_rand(), false));
    }

    // Esta funcion permite solicitar una request para crear una nueva contraseña dentro de la db
    function solicitaPassword()
    {

        try {
            $token = $this->generarToken();

            $query = $this->prepare("UPDATE usuarios SET token_password = :token, password_request=1 WHERE documento = :documento");


            $query->execute([
                'token' => $this->token,
                'documento' => $this->user_id
            ]);

            if ($query) {
                return $token;
            }
            return null;
        } catch (PDOException $e) {
            error_log('EMAILMODEL::SolicitarPassword->PDOException' . $e);
            return false;
        }
    }


    function verificarTokenRequest()
    {

        try {
            $query = $this->prepare("SELECT documento FROM usuarios WHERE documento = :documento AND token_password LIKE :token AND password request = 1");

            $query->execute([
                'documento' => $this->user_id,
                'toke' => $this->token,
            ]);

            if ($query->rowCount() > 0) {

                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log('EMAILMODEL::VerificarTokenRequest->PDOException' . $e);
            return false;
        }
    }

    
    function actualizaPassword($password)
    {

        try {
            $query = $this->prepare("UPDATE usuarios SET password = :password, token_password = '', password_request= 0 WHERE documento = :documento");

            $query->execute([

                'password' => $password,
                'documento' => $this->user_id
            ]);

            if ($query->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log('EMAILMODEL::ActualizarPassword->PDOException' . $e);
            return false;
        }
    }
}
