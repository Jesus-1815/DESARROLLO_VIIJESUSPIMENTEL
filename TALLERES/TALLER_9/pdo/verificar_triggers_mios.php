<?php
require_once "config_pdo.php"; // Asegúrate de que esta ruta es correcta

function verificarActualizacionMembresia($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT nivel_membresia FROM clientes WHERE id_cliente = ?");
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Nivel de Membresía Actualizado:</h3>";
    if ($cliente) {
        echo "Cliente ID: " . $cliente_id . "<br>";
        echo "Nivel de Membresía: " . $cliente['nivel_membresia'] . "<br>";
    } else {
        echo "Cliente no encontrado.<br>";
    }
}

function verificarEstadisticasCategoria($pdo, $categoria_id) {
    $stmt = $pdo->prepare("SELECT total_ventas FROM estadisticas WHERE id_categoria = ?");
    $stmt->execute([$categoria_id]);
    $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Estadísticas de Ventas por Categoría:</h3>";
    if ($estadisticas) {
        echo "Categoría ID: " . $categoria_id . "<br>";
        echo "Total Ventas: $" . $estadisticas['total_ventas'] . "<br>";
    } else {
        echo "Categoría no encontrada.<br>";
    }
}

function verificarAlertasStock($pdo, $producto_id) {
    $stmt = $pdo->prepare("SELECT * FROM alertas_stock WHERE producto_id = ?");
    $stmt->execute([$producto_id]);
    $alertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Alertas de Stock:</h3>";
    if ($alertas) {
        foreach ($alertas as $alerta) {
            echo "Producto ID: " . $alerta['producto_id'] . "<br>";
            echo "Mensaje: " . $alerta['mensaje'] . "<br>";
            echo "Fecha: " . $alerta['fecha'] . "<br><br>";
        }
    } else {
        echo "No hay alertas para este producto.<br>";
    }
}

function verificarHistorialEstadoCliente($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT * FROM log_estado_cliente WHERE id_cliente = ?");
    $stmt->execute([$cliente_id]);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Historial de Cambios de Estado de Cliente:</h3>";
    if ($logs) {
        foreach ($logs as $log) {
            echo "Cliente ID: " . $log['id_cliente'] . "<br>";
            echo "Estado Anterior: " . $log['estado_anterior'] . "<br>";
            echo "Estado Nuevo: " . $log['estado_nuevo'] . "<br>";
            echo "Fecha: " . $log['fecha_cambio'] . "<br><br>";
        }
    } else {
        echo "No hay cambios de estado registrados para este cliente.<br>";
    }
}

// Probar los triggers
verificarActualizacionMembresia($pdo, 1); // Cambiar por el ID de cliente real
verificarEstadisticasCategoria($pdo, 1); // Cambiar por el ID de categoría real
verificarAlertasStock($pdo, 1); // Cambiar por el ID de producto real
verificarHistorialEstadoCliente($pdo, 1); // Cambiar por el ID de cliente real

$pdo = null;
?>
