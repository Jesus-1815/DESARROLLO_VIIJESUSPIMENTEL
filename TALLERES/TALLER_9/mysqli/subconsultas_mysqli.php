<?php
require_once "config_mysqli.php"; // Asegúrate de que este archivo esté configurado correctamente

// 1. Productos con precio mayor al promedio de su categoría
$sql = "SELECT p.nombre, p.precio, c.nombre AS categoria, AVG(p.precio) OVER (PARTITION BY c.id) AS promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (SELECT AVG(precio) FROM productos WHERE categoria_id = c.id)";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, Categoría: {$row['categoria']}, Promedio categoría: " . round($row['promedio_categoria'], 2) . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error en la consulta de productos con precio mayor al promedio: " . mysqli_error($conn);
}

// 2. Clientes con compras superiores al promedio
$sql = "SELECT c.nombre, SUM(dv.subtotal) AS total_compras, 
        (SELECT AVG(subtotal) FROM detalles_venta) AS promedio_general
        FROM clientes c
        JOIN ventas v ON c.id = v.cliente_id
        JOIN detalles_venta dv ON v.id = dv.venta_id
        GROUP BY c.id
        HAVING total_compras > promedio_general";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: " . round($row['total_compras'], 2) . ", Promedio general: " . round($row['promedio_general'], 2) . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error en la consulta de clientes: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

