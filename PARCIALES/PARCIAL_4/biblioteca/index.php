
<?php
session_start();

// Verificar si el usuario tiene un token de acceso
if (!isset($_SESSION['access_token'])) {
    
    header('Location: ../auth/login.php');
    exit();
}
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="/PARCIALES/PARCIAL_4/biblioteca/vistas/css/style_index.css">
</head>
<body> 
    <div class="container">
        <h1>Menú Principal</h1>
        <div class="menu">
            <a href="vistas/buscar_libro.php">Buscar Libros</a>
            <a href="vistas/favoritos.php">Ver Favoritos</a>
        </div>
    </div>

    <footer>
        <?php include 'vistas/footer.php'; ?>
    </footer>
</body>
</html>