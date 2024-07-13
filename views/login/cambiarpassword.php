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
            <form id="formCambiarPass" name="formCambiarPass" method="POST" action="<?php echo constant('URL'); ?>login/setPassword">
            <input type="hidden" id="idUsuario" name="identificacion" value="<?= $data['identificacion']; ?>" required>
                <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
                <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
                <h2>Cambiar contraseña</h2>
                <div class="input-container">
                    <input type="text" id="txtPassword" placeholder="" name="txtPassword" required>
                    <label for="username">Contraseña</label>
                </div>
                <div class="input-container">
                    <input type="password" id="txtPasswordConfirm" placeholder="" name="txtPasswordConfirm" required>
                    <label for="password">Confirmar contraseña</label>
                </div>
                <button type="submit" id="btn-login">Reiniciar</button>
            </form>
        </div>
    </div>

    <!-- JavaScript para el efecto de volteo y manejo del formulario adicional -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?php echo constant('URL'); ?>views/js/functions_login.js"></script>
</body>

</html>