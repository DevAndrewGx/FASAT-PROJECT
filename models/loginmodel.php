<?php

    // extendemos el modelo base e implementamos la interfaz
    class LoginModel extends Model { 
        

        function __construct() { 
            // llamamos nuestro constructor
            parent::__construct();
        }


    // esta funcion nos permitira realizar el login de nuestro aplicativo
    public function login($username, $password)
    {
        // insertar datos en la BD
        error_log("login: inicio");
        // cuando vamos acceder a la bd siempre usamos trycatch
        try {
            //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
            $query = $this->prepare('SELECT * FROM usuarios WHERE documento = :documento');
            $query->execute(['username' => $username]);

            if ($query->rowCount() == 1) {
                $item = $query->fetch(PDO::FETCH_ASSOC);

                $user = new UserModel();
                $user->from($item);

                error_log('login: user id ' . $user->getDocumnto());

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