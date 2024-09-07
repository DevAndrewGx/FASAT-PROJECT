<?php

// extendemos el modelo base e implementamos la interfaz
class LoginModel extends Model
{


    function __construct()
    {
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

                // if ($this->isUserBlocked($correo)) {
                //     return json_encode(['status' => false, 'message' => 'Cuenta bloqueada.']);
                // }

                if (password_verify($password, $user->getPassword())) {
                    error_log('login: success');
                    //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                    $this->resetLoginAttempts($correo);
                    return $user;
                    //return $user->getId();
                } else {
                    $this->incrementLoginAttempts($correo);
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

                if ($this->isUserBlocked($user->getCorreo())) {
                    return json_encode(['status' => false, 'message' => 'Cuenta bloqueada.']);
                }

                if (password_verify($password, $user->getPassword())) {
                    error_log('login: success');
                    //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                    $this->resetLoginAttempts($user->getCorreo());
                    return $user;
                    //return $user->getId();
                } else {
                    $this->incrementLoginAttempts($user->getCorreo());
                    return NULL;
                }
            }
        } catch (PDOException $e) {
            return NULL;
        }
    }
    // Incrementar el conteo de intentos fallidos
    private function incrementLoginAttempts($correo)
    {
        $query = $this->prepare('UPDATE usuarios SET intentos_fallidos = intentos_fallidos + 1 WHERE correo = :correo');
        $query->execute(['correo' => $correo]);

        $this->blockUserIfNecessary($correo);
    }

    // Reiniciar los intentos fallidos
    private function resetLoginAttempts($correo)
    {
        $query = $this->prepare('UPDATE usuarios SET intentos_fallidos = 0 WHERE correo = :correo');
        $query->execute(['correo' => $correo]);
    }

    // Bloquear al usuario si supera el límite de intentos fallidos
    private function blockUserIfNecessary($correo)
    {
        $query = $this->prepare('SELECT intentos_fallidos FROM usuarios WHERE correo = :correo');
        $query->execute(['correo' => $correo]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['intentos_fallidos'] >= 3) {
            $query = $this->prepare('UPDATE usuarios SET id_estado = 2 WHERE correo = :correo');
            $query->execute(['correo' => $correo]);
        }
    }

    // Verificar si el usuario está bloqueado
    private function isUserBlocked($correo)
    {

        $query = $this->prepare('SELECT u.correo, e.tipo FROM usuarios u JOIN estados_usuarios e ON u.id_estado = e.id_estado WHERE correo = :correo');

        $query->execute(['correo' => $correo]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result['tipo'] === 'Inactivo') {
            return true;
        }

        return false;

        // return $result && $result['id_estado'] == 2;
    }
}
