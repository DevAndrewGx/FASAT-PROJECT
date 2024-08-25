<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo constant('URL');?>">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <a href="../html/admin/adminDashboard.php"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo" class="logo"></a>

            </div>
            <form id="formLogin" method="POST" action="<?php echo constant("URL") ?>login/authenticate">
                <h2>Inicia sesión</h2>
                <div class="input-container">
                    <input type="text" id="username" placeholder="" name="correo" required>
                    <label for="username">Correo</label>
                </div>
                <div class="input-container">
                    <input type="password" id="password" placeholder="" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" id="btn-login">Login</button>
                <p class="bottom-text">¿Olvidaste tu contraseña? Haz click <a href="#" id="btn-olvido-pass">aquí</a>.</p>
            </form>


            <form id="formOlvidoPass" class="forget-form" style="display: none;">
                <h2>Olvidaste tu contraseña?</h2>
                <?php //mostrarMensajes($errors);
                ?>
                <div class="input-container">
                    <input name="email" type="email" id="email" required>
                    <label for="txtEmailReset">Email</label>
                </div>
                <button type="submit" id="btn-reset" class="btn-reset">Enviar correo</button>
                <p class="bottom-text">Volver a <a href="#" id="btn-back-login">Iniciar sesión</a>.</p>
            </form>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="<?php echo constant('URL'); ?>public/js/functions_login.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

</body>

</html>