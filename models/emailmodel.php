<?php

    class EmailModel extends Model {

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

        function emailExiste()
        {

            $sql = $this->query("SELECT documento FROM usuarios WHERE correo LIKE ? LIMIT 1");

            if ($sql->fetchColumn() > 0) {
                return true;
            }

            return false;
        }

        // function generarToken()
        // {

        //     return md5(uniqid(mt_rand(), false));
        // }


        function solicitaPassword($user_id, $con)
        {

            $token = $this->generarToken();

            $sql = $this->prepare("UPDATE usuarios SET token_password, password_request=1 WHERE documento =?");
            if ($sql->execute([$token, $user_id])) {
                return $token;
            }
            return null;
        }

        function verificarTokenRequest($user_id, $token, $con)
        {

            $sql = $this->prepare("SELECT documento FROM usuarios WHERE id = ? AND token_password LIKE ? AND
        password request=1 ");
            $sql->execute([$user_id, $token]);
            if ($sql->fetchColumn() > 0) {

                return true;
            }
            return false;
        }

        function actualizaPassword($user_id, $password, $conn)
        {

            $sql = $this->prepare("UPDATE usuarios SET password=?, token_password = '', password_request= 0 WHERE documento = ?");
            if ($sql->execute([$password, $user_id])) {
                return true;
            }
            return false;
        }
    }
