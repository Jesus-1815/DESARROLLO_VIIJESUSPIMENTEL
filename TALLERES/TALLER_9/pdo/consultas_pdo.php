<?php
require_once "config_pdo.php";

try {
    // 1. Productos que nunca se han vendido
    $sql = "SELECT p.nombre, p.precio, c.nombre AS categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id NOT IN (
                SELECT producto_id FROM detalles_venta
            )";

    $stmt = $pdo->query($sql);
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, Categoría: {$row['categoria']}<br>";
    }

    // 2. Categorías con número de productos y valor total del inventario
    $sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS num_productos, 
            SUM(p.precio * p.stock) AS valor_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";

    $stmt = $pdo->query($sql);
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['num_productos']}, Valor total inventario: {$row['valor_inventario']}<br>";
    }

    // 3. Clientes que han comprado todos los productos de una categoría específica
    $sql = "SELECT c.nombre, c.email, cat.nombre AS categoria
            FROM clientes c
            JOIN ventas v ON c.id = v.cliente_id
            JOIN detalles_venta dv ON v.id = dv.venta_id
            JOIN productos p ON dv.producto_id = p.id
            JOIN categorias cat ON p.categoria_id = cat.id
            WHERE NOT EXISTS (
                SELECT p2.id FROM productos p2
                WHERE p2.categoria_id = cat.id
                AND p2.id NOT IN (
                    SELECT dv2.producto_id FROM detalles_venta dv2
                    JOIN ventas v2 ON dv2.venta_id = v2.id
                    WHERE v2.cliente_id = c.id
                )
            )
            GROUP BY c.id, cat.id";

    $stmt = $pdo->query($sql);
    echo "<h3>Clientes que han comprado todos los productos de una categoría:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}, Email: {$row['email']}, Categoría: {$row['categoria']}<br>";
    }

    // 4. Porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre, SUM(dv.subtotal) AS total_ventas, 
            (SUM(dv.subtotal) / (SELECT SUM(subtotal) FROM detalles_venta) * 100) AS porcentaje
            FROM productos p
            JOIN detalles_venta dv ON p.id = dv.producto_id
            GROUP BY p.id";

    $stmt = $pdo->query($sql);
    echo "<h3>Porcentaje de ventas de cada producto:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Total ventas: {$row['total_ventas']}, Porcentaje: {$row['porcentaje']}%<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
