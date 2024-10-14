<?php
include 'config_sesion.php';
$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 20],
    3 => ['nombre' => 'Producto 3', 'precio' => 30],
    4 => ['nombre' => 'Producto 4', 'precio' => 40],
    5 => ['nombre' => 'Producto 5', 'precio' => 50],
];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <ul>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <?php foreach ($_SESSION['carrito'] as $id => $cantidad): ?>
                <li>
                    <?php echo htmlspecialchars($productos[$id]['nombre']); ?> - Cantidad: <?php echo $cantidad; ?> - Precio: $<?php echo $productos[$id]['precio'] * $cantidad; ?>
                    <a href="eliminar_del_carrito.php?id=<?php echo $id; ?>">Eliminar</a>
                </li>
                <?php $total += $productos[$id]['precio'] * $cantidad; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <li>El carrito está vacío.</li>
        <?php endif; ?>
    </ul>
    <p>Total: $<?php echo $total; ?></p>
    <a href="productos.php">Seguir Comprando</a>
    <a href="checkout.php">Finalizar Compra</a>
</body>
</html>
