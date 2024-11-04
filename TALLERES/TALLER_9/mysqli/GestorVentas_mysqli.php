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
    
    $conn = new mysqli($host, $usuario, $password, $database);
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    echo "Conexión exitosa a la base de datos<br>";
    return $conn;
}

function procesarDevolucion($conn, $idVenta, $idProducto, $cantidad, $motivo) {
    echo "Intentando procesar devolución...<br>";
    
    try {
        $sql = "CALL sp_procesar_devolucion(?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación del statement: " . $conn->error);
        }
        
        $stmt->bind_param("iiis", $idVenta, $idProducto, $cantidad, $motivo);
        $resultado = $stmt->execute();
        
        if ($resultado) {
            // Verificar si hubo algún mensaje de error específico del procedimiento almacenado
            if ($stmt->affected_rows === 0) {
                echo "Devolución no procesada: Posible error de clave foránea o validación en el procedimiento almacenado<br>";
            } else {
                echo "Devolución procesada exitosamente<br>";
            }
            return true;
        } else {
            echo "Error al ejecutar la devolución: " . $stmt->error . "<br>";
            return false;
        }
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
        
        if (!$stmt) {
            throw new Exception("Error en la preparación del statement: " . $conn->error);
        }
        
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();
        
        $result = $conn->query("SELECT @descuento as descuento");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Descuento calculado: " . $row['descuento'] . "<br>";
            return $row['descuento'];
        } else {
            echo "Error al obtener el descuento: " . $conn->error . "<br>";
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
        
        if (!$stmt) {
            throw new Exception("Error en la preparación del statement: " . $conn->error);
        }
        
        $stmt->bind_param("i", $umbral);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            echo "<h3>Productos con bajo stock:</h3>";
            while ($row = $result->fetch_assoc()) {
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
        
        if (!$stmt) {
            throw new Exception("Error en la preparación del statement: " . $conn->error);
        }
        
        $stmt->bind_param("iss", $idUsuario, $fechaInicio, $fechaFin);
        $stmt->execute();
        
        $result = $conn->query("SELECT @comision as comision");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "Comisión calculada: $" . $row['comision'] . "<br>";
            return $row['comision'];
        } else {
            echo "Error al obtener la comisión: " . $conn->error . "<br>";
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
        
        if (!$stmt) {
            throw new Exception("Error en la preparación del statement: " . $conn->error);
        }
        
        $stmt->bind_param("id", $idCliente, $total); // Asumiendo que total es un decimal
        $resultado = $stmt->execute();
        
        if ($resultado) {
            echo "Venta creada exitosamente<br>";
            return true;
        } else {
            echo "Error al crear la venta: " . $stmt->error . "<br>";
            return false;
        }
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
    
    // Otras pruebas...
    
} catch (Exception $e) {
    echo "<br>Error general: " . $e->getMessage();
}


// Pruebas
try {
    echo "<h2>Iniciando pruebas de procedimientos almacenados</h2>";
    
    $conn = conectarDB();
    
    echo "<h3>1. Prueba de devolución:</h3>";
    $devolucion = procesarDevolucion($conn, 1, 1, 2, "Producto defectuoso");
    
    echo "<h3>2. Prueba de descuento:</h3>";
    $descuento = calcularDescuento($conn, 1);
    
    echo "<h3>3. Prueba de reporte de stock:</h3>";
    $productos = reporteBajoStock($conn, 10);
    
    echo "<h3>4. Prueba de comisiones:</h3>";
    $comision = calcularComisiones($conn, 1, '2024-01-01', '2024-12-31');
    
    $conn->close();
    echo "<br>Pruebas completadas";
    
} catch (Exception $e) {
    echo "<br>Error general: " . $e->getMessage();
}
?>

