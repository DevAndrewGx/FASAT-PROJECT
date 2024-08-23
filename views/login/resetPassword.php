<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL'); ?>">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <a href="../html/admin/adminDashboard.php"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo" class="logo"></a>
            </div>
            <form id="formCambiarPass" autocomplete="off">

            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']) ?>"/>
            <input type="hidden" name="documento" value="<?php echo htmlspecialchars($_GET['documento']) ?>"/>
                <h2>Cambiar contraseña</h2>
                <div class="input-container">
                    <input type="password" name="password" id="password" placeholder="" required>
                    <label for="username">Nueva contraseña</label>
                </div>
                <div class="input-container">
                    <input type="password" name="repassword" id="repassword" placeholder="" required>
                    <label for="username">Confirmar Contraseña</label>
                </div>
                <button type="submit" id="btn-login">Continuar</button>
            </form>
        </div>
    </div>

    <!-- JavaScript para el efecto de volteo y manejo del formulario adicional -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?php echo constant('URL'); ?>public/js/functions_login.js"></script>
</body>

</html>