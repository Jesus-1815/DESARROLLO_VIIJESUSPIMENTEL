<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['role'] !== 'estudiante') {
    header('Location: index.php');
    exit;
}

$calificaciones = [
    'estudiante1' => 85,
    'estudiante2' => 90,
    'estudiante3' => 78,
    'estudiante4' => 22,
];

$usuario = $_SESSION['usuario'];
$nota = $calificaciones[$usuario] ?? 'Sin calificación';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Estudiante</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Estudiante)</h2>
    <h3>Tu Calificación: <?php echo $nota; ?></h3>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
