<?php

// para validar la secion tenemos que crear otro archivo aparte
class Sesion
{
    public function validarSesion($email, $clave)
    {
        $con = new Conexion();
        $objConexion = $con->getConexion();

        $consultar = "SELECT * FROM usuarios WHERE correo=:email";
        $statement = $objConexion->prepare($consultar);

        $statement->bindParam(":email", $email);

        $statement->execute();


        // lo que hicimos anteriormente es para validar si el email del usuario esta registrado en la base de datos

        if ($f = $statement->fetch()) {
            //validamos la clave ingresada con la clave de la DB
            if ($clave == $f['password']) {

                session_start();
                // las variables de secion son para el archivo de seguridad de rutas o de permisos de rutas...
                $_SESSION['id_usuario'] = $f['id_usuario'];
                $_SESSION['msg'] = 'mensaje';
                $_SESSION['rol'] = $f['rol'];
                $_SESSION['autenticado'] = "SI";

                if ($f['rol'] == "Administrador") {
                    echo '<script>alert("Bienvenido Admin :)")</script>';
                    echo $_SESSION['autenticado'];
                    echo "<script>location.href='../views/html/admin/adminDashboard.php'</script>";
                }else if($f['rol'] == "Camarero") {
                    echo '<script>alert("Bienvenido Mesero")</script>';
                    echo "<script>location.href='../views/html/mesero/meseroDashboard.php'</script>";
                }
            } else {
                echo '<script>alert("La clave es incorrecta")</script>';
                echo "<script>location.href='../views/sign-up/login.php'</script>";
            }
        } else {
            echo '<script>alert("El email no se encuentra registrado en el sistema, verifique los datos")</script>';
            echo "<script>location.href='../views/sign-up/login.php'</script>";
        }
    }

    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        echo "<script>alert('Testing message for log-out')</script>";
        echo "<script>location.href='../views/sign-up/login.php'</script>";
    }
}
