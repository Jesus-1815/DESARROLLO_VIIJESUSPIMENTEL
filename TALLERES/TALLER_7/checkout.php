<?php
include 'config_sesion.php';

if (!empty($_SESSION['carrito'])) {
    // Aquí podrías procesar el pago y guardar la compra en la base de datos
    setcookie('usuario', 'Nombre del Usuario', time() + 86400, '', '', true, true);
    $_SESSION['carrito'] = [];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Compra Finalizada</h1>
    <p>Gracias por tu compra.</p>
    <a href="productos.php">Volver a Productos</a>
</body>
</html>
