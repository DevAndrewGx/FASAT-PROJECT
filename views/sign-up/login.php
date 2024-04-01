<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <a href="../html/admin/adminDashboard.html"><img src="../imgs/LOGOf.png" alt="Logo" class="logo"></a>
                <h2>Inicia sesión</h2>
            </div>
            <form method="POST" action="../../controllers/inicioSesion.php">
                <div class="input-container">
                    <input type="text" id="username" placeholder="" name="user" required>
                    <label for="username">Username</label>
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