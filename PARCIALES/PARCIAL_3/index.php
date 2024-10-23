<?php
session_start();

$usuarios = [
    'profesor1' => ['password' => 'prof1', 'role' => 'profesor'],
    'estudiante1' => ['password' => 'estu1', 'role' => 'estudiante'],
    'estudiante2' =>['password' => 'estu2', 'role' => 'estudiante'],
    'estudiante3' =>['password' => 'estu3', 'role' => 'estudiante'],
    'estudiante4' => ['password' => 'estu4', 'role' => 'estudiante'],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (preg_match('/^[a-zA-Z0-9]{3,}$/', $usuario) && strlen($password) >= 5) {
        if (isset($usuarios[$usuario]) && $usuarios[$usuario]['password'] === $password) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['role'] = $usuarios[$usuario]['role'];
            header("Location: " . ($_SESSION['role'] == 'profesor' ? 'dashboard_profesor.php' : 'dashboard_estudiante.php'));
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "El nombre de usuario debe tener al menos 3 caracteres y la contraseña al menos 5 caracteres.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <h2>"Inicie sesion con sus credenciales de profesor: o estudiante:"</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
