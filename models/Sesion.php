<?php

// para validar la secion tenemos que crear otro archivo aparte
class Sesion
{
    public function validarSesion($email, $clave)
    {
        $con = new Conexion();
        $objConexion = $con->getConexion();

        $consultar = "SELECT * FROM usuarios JOIN roles ON roles.IDROL = usuarios.idUsuario WHERE Correo=:email";
        $statement = $objConexion->prepare($consultar);

        $statement->bindParam(":email", $email);

        $statement->execute();


        // lo que hicimos anteriormente es para validar si el email del usuario esta registrado en la base de datos

        if ($f = $statement->fetch()) {
            //validamos la clave ingresada con la clave de la DB
            if ($clave == $f['Password']) {

                session_start();
                // las variables de secion son para el archivo de seguridad de rutas o de permisos de rutas...
                $_SESSION['IDROL'] = $f['IDROL'];
                $_SESSION['Rol'] = $f['Rol'];
                $_SESSION['AUTENTICADO'] = "SI";

                if ($f['Rol'] == "Administrador") {
                    echo '<script>alert("Bienvenido Admin :)")</script>';
                    echo "<script>location.href='../views/html/admin/adminDashboard.php'</script>";
                } //else {
                //     echo '<script>alert("Bienvenido Inmobiliaria")</script>';
                //     echo "<script>location.href='../Views/inmoApartamentos.php'</script>";
                // }
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
