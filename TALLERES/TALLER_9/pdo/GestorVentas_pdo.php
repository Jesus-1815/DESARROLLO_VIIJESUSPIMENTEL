<?php
// Activar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para conectar a la base de datos
function conectarDB() {
    $host = "localhost";
    $usuario = "root"; // Cambia esto por tu usuario
    $password = ""; // Cambia esto por tu contraseña
    $database = "taller9_db";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Conexión exitosa a la base de datos<br>";
        return $conn;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function procesarDevolucion($conn, $idVenta, $idProducto, $cantidad, $motivo) {
    echo "Intentando procesar devolución...<br>";

    try {
        $sql = "CALL sp_procesar_devolucion(?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idVenta, $idProducto, $cantidad, $motivo]);

        // Verificar si hubo algún mensaje de error específico del procedimiento almacenado
        if ($stmt->rowCount() === 0) {
            echo "Devolución no procesada: Posible error de clave foránea o validación en el procedimiento almacenado<br>";
        } else {
            echo "Devolución procesada exitosamente<br>";
        }
        return true;
    } catch (Exception $e) {
        echo "Error en procesarDevolucion: " . $e->getMessage() . "<br>";
        return false;
    }
}

function calcularDescuento($conn, $idCliente) {
    echo "Calculando descuento para cliente $idCliente...<br>";

    try {
        $sql = "CALL sp_calcular_descuento(?, @descuento)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idCliente]);

        $result = $conn->query("SELECT @descuento as descuento")->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo "Descuento calculado: " . $result['descuento'] . "<br>";
            return $result['descuento'];
        } else {
            echo "Error al obtener el descuento<br>";
            return 0;
        }
    } catch (Exception $e) {
        echo "Error en calcularDescuento: " . $e->getMessage() . "<br>";
        return 0;
    }
}

function reporteBajoStock($conn, $umbral) {
    echo "Generando reporte de bajo stock (umbral: $umbral)...<br>";

    try {
        $sql = "CALL sp_reporte_bajo_stock(?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$umbral]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result && count($result) > 0) {
            echo "<h3>Productos con bajo stock:</h3>";
            foreach ($result as $row) {
                echo "Producto: " . $row['nombre'] . 
                     " - Stock actual: " . $row['stock'] . 
                     " - Categoría: " . $row['categoria'] . "<br>";
            }
            return $result;
        } else {
            echo "No se encontraron productos con bajo stock<br>";
            return false;
        }
    } catch (Exception $e) {
        echo "Error en reporteBajoStock: " . $e->getMessage() . "<br>";
        return false;
    }
}

function calcularComisiones($conn, $idUsuario, $fechaInicio, $fechaFin) {
    echo "Calculando comisiones para usuario $idUsuario...<br>";

    try {
        $sql = "CALL sp_calcular_comisiones(?, ?, ?, @comision)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idUsuario, $fechaInicio, $fechaFin]);

        $result = $conn->query("SELECT @comision as comision")->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo "Comisión calculada: $" . $result['comision'] . "<br>";
            return $result['comision'];
        } else {
            echo "Error al obtener la comisión<br>";
            return 0;
        }
    } catch (Exception $e) {
        echo "Error en calcularComisiones: " . $e->getMessage() . "<br>";
        return 0;
    }
}

function crearVenta($conn, $idCliente, $total) {
    echo "Creando nueva venta para el cliente $idCliente...<br>";

    try {
        $sql = "INSERT INTO ventas (id_cliente, fecha_venta, total) VALUES (?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idCliente, $total]); // Asumiendo que total es un decimal

        echo "Venta creada exitosamente<br>";
        return true;
    } catch (Exception $e) {
        echo "Error en crearVenta: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Pruebas
try {
    echo "<h2>Iniciando pruebas de procedimientos almacenados</h2>";

    $conn = conectarDB();

    // Crear una nueva venta antes de procesar la devolución
    $ventaCreada = crearVenta($conn, 1, 100.00);

    echo "<h3>1. Prueba de devolución:</h3>";
    $devolucion = procesarDevolucion($conn, 1, 1, 2, "Producto defectuoso");

    echo "<h3>2. Prueba de descuento:</h3>";
    $descuento = calcularDescuento($conn, 1);

    echo "<h3>3. Prueba de reporte de stock:</h3>";
    $productos = reporteBajoStock($conn, 10);

    echo "<h3>4. Prueba de comisiones:</h3>";
    $comision = calcularComisiones($conn, 1, '2024-01-01', '2024-12-31');

    $conn = null; // Cierra la conexión
    echo "<br>Pruebas completadas";

} catch (Exception $e) {
    echo "<br>Error general: " . $e->getMessage();
}
?>
