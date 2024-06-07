<!-- este archivo va ser siempre el primero en que se cargue cuando accedamos al controlador del login -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <a href="../html/admin/adminDashboard.php"><img src="<?php echo constant('URL'); ?>public/imgs/LOGOf.png" alt="Logo" class="logo"></a>
                <h2>Inicia sesión</h2>
            </div>
            <form method="POST" action="<?php echo constant("URL")?>login/authenticate">
                <div class="input-container">
                    <input type="text" id="username" placeholder="" name="correo" required>
                    <label for="username">Correo</label>
                </div>
                <div class="input-container">
                    <input type="password" id="password" placeholder="" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" id="btn-login">Login</button>
            </form>
            <p class="bottom-text">Eres nuevo? Deseas iniciar prueba? Haz click <a href="signup.html">aquí</a>.</p>
        </div>
    </div>

</body>

</html>