<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'profesor') {
    header('Location: index.php');
    exit;
}

$calificaciones = [
    'estudiante1' => 85,
    'estudiante2' => 90,
    'estudiante3' => 78,
    'estudiante4' => 22,
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Profesor</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Profesor)</h2>
    <h3>Lista de Calificaciones:</h3>
    <ul>
        <?php foreach ($calificaciones as $estudiante => $nota): ?>
            <li><?php echo "$estudiante: $nota"; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
