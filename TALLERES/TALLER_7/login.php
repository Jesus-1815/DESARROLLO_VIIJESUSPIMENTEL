<?php
session_start();
include 'config_sesion.php'; // Asegúrate de que este archivo exista y esté configurado correctamente.

// Si ya hay una sesión activa, redirigir al panel
if (isset($_SESSION['usuario'])) {
    header("Location: panel.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación CSRF");
    }

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // En un caso real, verificaríamos contra una base de datos
    if ($usuario === "admin" && $contrasena === "1234") {
        $_SESSION['usuario'] = $usuario;
        header("Location: panel.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Generar token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    // Mostrar mensaje de error si existe
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="usuario">Usuario:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <!-- Token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
