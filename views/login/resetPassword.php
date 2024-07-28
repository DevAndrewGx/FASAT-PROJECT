<?php

$documento = $_GET['documento'] ?? $_POST['user_id'] ?? '';
$documento = $_GET['token'] ?? $_POST['token'] ?? '';

if($documento == '' || $token == '' ){
     header("Location: index.php"); //regresa al inicio
    exit;
}


$errors = [];

if(!verificarTokenRequest($user_id, $token, $con )){

    echo "No se pudo verificar la informacion";
    exit;
}

if (!empty($_POST)) {
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    
    if (esNulo([$user_id, $token, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!validarPassword([$password, $repassword])) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if(count($errors)== 0){
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        if (actualizaPassword($user_id, $password, $conn)){
            echo "Contraseña modificada.<br><a href='login.php'>Iniciar sesion</a>";
            exit;
        }   else{
            $errors[] = "Error al modificar contraseña. Intentalo nuevamente";
        }
    }
   
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <a href="../html/admin/adminDashboard.php"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo" class="logo"></a>
            </div>
            <form id="recupera.php" method="POST" action="" autocomplete="off">

            <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>"/>
            <input type="hidden" name="token" id="" value="<?= $token; ?>"/>
                <h2>Cambiar contraseña</h2>
                <div class="input-container">
                    <input type="password"  name="password" id="password" placeholder="Nueva contraseña" required>
                    <label for="username">Nueva contraseña</label>
                </div>
                <div class="input-container">
                    <input type="password"  name="repassword" id="repassword" placeholder="Nueva contraseña" required>
                    <label for="username">Confirmar Contraseña</label>
                </div>
                <button type="submit" id="btn-login">Continuar</button>
            </form>
        </div>
    </div>

    <!-- JavaScript para el efecto de volteo y manejo del formulario adicional -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?php echo constant('URL'); ?>views/js/functions_login.js"></script>
</body>

</html>