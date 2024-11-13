<?php
session_start();

if (isset($_SESSION['access_token'])) {
    // Si el usuario ya ha iniciado sesión, redirigir a la página principal
    header('Location: /PARCIALES/PARCIAL_4/biblioteca/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión - Biblioteca</title>
    <link rel="stylesheet" href="/PARCIALES/PARCIAL_4/biblioteca/vistas/css/style_login.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Bienvenido a la Biblioteca</h1>
        <p>Para continuar, inicia sesión con tu cuenta de Google.</p>
        <a href="/PARCIALES/PARCIAL_4/biblioteca/auth/google_oauth.php" class="login-btn">Iniciar sesión con Google</a>
    </div>
</body>
</html>
