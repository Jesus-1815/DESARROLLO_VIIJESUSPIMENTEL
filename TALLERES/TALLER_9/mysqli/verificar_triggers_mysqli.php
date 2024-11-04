<?php
require_once "config_mysqli.php"; // Asegúrate de que esta ruta es correcta

// Establecer conexión con mysqli
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar conexión
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function verificarCambiosPrecio($mysqli, $producto_id, $nuevo_precio) {
    try {
        // Actualizar precio
        $stmt = $mysqli->prepare("UPDATE productos SET precio = ? WHERE id_producto = ?");
        $stmt->bind_param("di", $nuevo_precio, $producto_id); // d = decimal, i = integer
        $stmt->execute();

        // Verificar log de cambios
        $stmt = $mysqli->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->bind_param("i", $producto_id); // i = integer
        $stmt->execute();
        $result = $stmt->get_result();
        $log = $result->fetch_assoc();
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
        
        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($mysqli, $producto_id, $nueva_cantidad) {
    try {
        // Actualizar stock
        $stmt = $mysqli->prepare("UPDATE productos SET stock = ? WHERE id_producto = ?");
        $stmt->bind_param("ii", $nueva_cantidad, $producto_id); // i = integer
        $stmt->execute();

        // Verificar movimientos de inventario
        $stmt = $mysqli->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->bind_param("i", $producto_id); // i = integer
        $stmt->execute();
        $result = $stmt->get_result();
        $movimiento = $result->fetch_assoc();
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
        
        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Probar los triggers
verificarCambiosPrecio($mysqli, 1, 999.99);
verificarMovimientoInventario($mysqli, 1, 15);

// Cerrar conexión
$mysqli->close();
?>

