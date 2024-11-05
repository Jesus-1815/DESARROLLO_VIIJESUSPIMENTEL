<?php
require_once "config_pdo.php";

function formatPrecio($valor) {
    return $valor !== null ? "$" . number_format($valor, 2) : "$0.00";
}

function mostrarResumenCategorias($conn) {
    $sql = "SELECT * FROM vista_resumen_categorias";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Resumen por Categorías:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Stock Total</th>
            <th>Precio Promedio</th>
            <th>Precio Mínimo</th>
            <th>Precio Máximo</th>
          </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['categoria'] ?? 'N/A') . "</td>"; // Manejo de nulos
        echo "<td>" . htmlspecialchars($row['total_productos'] ?? '0') . "</td>"; // Manejo de nulos
        echo "<td>" . htmlspecialchars($row['total_stock'] ?? '0') . "</td>"; // Manejo de nulos
        echo "<td>" . formatPrecio($row['precio_promedio']) . "</td>";
        echo "<td>" . formatPrecio($row['precio_minimo']) . "</td>";
        echo "<td>" . formatPrecio($row['precio_maximo']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function mostrarProductosPopulares($conn) {
    $sql = "SELECT * FROM vista_productos_populares LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Top 5 Productos Más Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Compradores Únicos</th>
          </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['producto'] ?? 'N/A') . "</td>"; // Manejo de nulos
        echo "<td>" . htmlspecialchars($row['categoria'] ?? 'N/A') . "</td>"; // Manejo de nulos
        echo "<td>" . htmlspecialchars($row['total_vendido'] ?? '0') . "</td>"; // Manejo de nulos
        echo "<td>" . formatPrecio($row['ingresos_totales']) . "</td>";
        echo "<td>" . htmlspecialchars($row['compradores_unicos'] ?? '0') . "</td>"; // Manejo de nulos
        echo "</tr>";
    }
    echo "</table>";
}

// Función para mostrar productos con bajo stock
function productosBajoStock($conn) {
    $sql = "SELECT * FROM vista_productos_bajo_stock_vendidos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Productos con bajo stock:</h3>";
    echo "<table border='1'>";
    echo "<tr>
        <th>Producto</th>
        <th>Categoría</th>
        <th>Stock Actual</th>
        <th>Total Vendido</th>
    </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nombre_producto']) . "</td>";
        echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
        echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_vendido']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function historialClientes($conn) {
    $sql = "SELECT * FROM vista_historial_clientes";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Historial de clientes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
            <th>Fecha Compra</th>
          </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['cliente']) . "</td>";
        echo "<td>" . htmlspecialchars($row['producto']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cantidad']) . "</td>";
        echo "<td>" . formatPrecio($row['precio_unitario']) . "</td>";
        echo "<td>" . formatPrecio($row['total']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_compra']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function metricasPorCategoria($conn) {
    $sql = "SELECT * FROM vista_metricas_categoria";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Métricas por categoría:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Unidades Vendidas</th>
            <th>Ingresos Totales</th>
            <th>Total Clientes</th>
          </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_productos']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_unidades_vendidas']) . "</td>";
        echo "<td>" . formatPrecio($row['ingresos_totales']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_clientes']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function tendenciasVentas($conn) {
    $sql = "SELECT * FROM vista_tendencias_ventas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
        die("Error en la consulta.");
    }

    echo "<h3>Tendencias de ventas por mes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Período</th>
            <th>Total Ventas</th>
            <th>Total Clientes</th>
            <th>Unidades Vendidas</th>
            <th>Ingresos Totales</th>
          </tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['periodo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_ventas']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_clientes']) . "</td>";
        echo "<td>" . htmlspecialchars($row['unidades_vendidas']) . "</td>";
        echo "<td>" . formatPrecio($row['ingresos_totales']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Mostrar los resultados
mostrarResumenCategorias($conn);
mostrarProductosPopulares($conn);
productosBajoStock($conn);
historialClientes($conn);
metricasPorCategoria($conn);
tendenciasVentas($conn);

$conn = null; // Cierra la conexión PDO
?>

