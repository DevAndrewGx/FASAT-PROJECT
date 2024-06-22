<?php

    // extendemos el modelo base e implementamos la interfaz
    class LoginModel extends Model { 
        

        function __construct() { 
            // llamamos nuestro constructor
            parent::__construct();
        }


    // esta funcion nos permitira realizar el login de nuestro aplicativo
        public function loginByCorreo($correo, $password)
        {
            // insertar datos en la BD
            error_log("loginByCorreo: inicio");
            // cuando vamos acceder a la bd siempre usamos trycatch
            try {
                //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
                $userObject = new JoinUserRolModel();
                $user = $userObject->get($correo);

                if ($user) {

                    error_log('login: user correo ' . $user->getCorreo());

                    if ($password == $user->getPassword()) {
                        error_log('login: success');
                        //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                        return $user;
                        //return $user->getId();
                    } else {
                        return NULL;
                    }
                }
            } catch (PDOException $e) {
                return NULL;
            }
        }

        public function loginByDocumento($documento, $password)
        {
            // insertar datos en la BD
            error_log("loginByDocumento: inicio");
            // cuando vamos acceder a la bd siempre usamos trycatch
            try {
                //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
                $query = $this->prepare(' SELECT u.*, r.rol FROM usuarios u JOIN roles r ON u.idRol = r.id 
                WHERE u.documento = :documento');
                $query->execute([
                    'documento' => $documento
                ]);

                if ($query->rowCount() == 1) {
                    $item = $query->fetch(PDO::FETCH_ASSOC);

                    $user = new UsersModel();
                    $user->from($item);

                    error_log('login: user documento' . $user->getDocumento());

                    if (password_verify($password, $user->getPassword())) {
                        error_log('login: success');
                        //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                        return $user;
                        //return $user->getId();
                    } else {
                        return NULL;
                    }
                }
            } catch (PDOException $e) {
                return NULL;
            }
        }
    }
?>