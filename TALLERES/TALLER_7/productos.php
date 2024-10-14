<?php
include 'config_sesion.php';
$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 20],
    3 => ['nombre' => 'Producto 3', 'precio' => 30],
    4 => ['nombre' => 'Producto 4', 'precio' => 40],
    5 => ['nombre' => 'Producto 5', 'precio' => 50],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <ul>
        <?php foreach ($productos as $id => $producto): ?>
            <li>
                <?php echo htmlspecialchars($producto['nombre']); ?> - $<?php echo htmlspecialchars($producto['precio']); ?>
                <a href="agregar_al_carrito.php?id=<?php echo $id; ?>">Añadir al carrito</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="ver_carrito.php">Ver Carrito</a>
</body>
</html>
