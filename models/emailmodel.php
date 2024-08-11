<?php

class EmailModel extends Model
{

    private $token;
    private $documento;
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

    

    // Esta funcion nos permite verificar si el email ya existe en la base de datos
    function emailExiste()
    {
        try {
            $query = $this->prepare("SELECT documento FROM usuarios WHERE correo = :correo LIMIT 1");

            $query->execute([
                "correo" => $this->correo
            ]);

            if ($query->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Correo: " . $this->correo);
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

            // asiganamos el token
            $this->setToken($token);

            $query = $this->prepare("UPDATE usuarios SET token_password = :token, password_request = 1 WHERE correo = :correo"); 

            $query->execute([
                'token' => $this->token,
                'correo' => $this->correo
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
            $query = $this->prepare("SELECT documento FROM usuarios WHERE documento = :documento AND token_password LIKE :token AND password_request = 1");

            $query->execute([
                'documento' => $this->documento,
                'token' => $this->token,
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
                'documento' => $this->documento
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

    function getUserDocumento() {
        try {
            // we have to use prepare because we're going to assing
            $query = $this->prepare('SELECT * FROM usuarios WHERE correo = :correo');
            $query->execute([
                'correo' => $this->correo
            ]);
            // Como solo queremos obtener un valor, no hay necesidad de tener un while
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // en este caso no hay necesidad de crear un objeto userModel, solo podemos llamar los metodos del mismo con objeto con this
            $this->setDocumento($user['documento']);

            //retornamos this porque es el mismo objeto que ya contiene la informacion
            return $user;
        } catch (PDOException $e) {
            error_log('USERMODEL::getId->PDOException' . $e);
        }
    }


      // Create getters and setters
        public function setEmail($correo){             $this->correo = $correo;}
        public function setToken($token){             $this->token = $token;}
        public function setDocumento($documento){             $this->documento = $documento;}

        public function getEmail(){             return $this->correo;}
        public function getToken(){             return $this->token;}
        public function getDocumento(){             return $this->documento;}
}
