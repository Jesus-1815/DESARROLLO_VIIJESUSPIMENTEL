<?php
require_once 'config.php';

// Función para registrar un préstamo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_loan'])) {
    $usuario_id = $_POST['usuario_id'];
    $libro_id = $_POST['libro_id'];
    $fecha_prestamo = date('Y-m-d');

    // Comprobar si hay libros disponibles
    $sql = "SELECT cantidad FROM libros WHERE id = :libro_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':libro_id' => $libro_id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($libro['cantidad'] > 0) {
        // Registrar el préstamo
        $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (:usuario_id, :libro_id, :fecha_prestamo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':libro_id' => $libro_id,
            ':fecha_prestamo' => $fecha_prestamo
        ]);

        // Actualizar cantidad de libros
        $sql = "UPDATE libros SET cantidad = cantidad - 1 WHERE id = :libro_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':libro_id' => $libro_id]);

        echo "Préstamo registrado con éxito.";
    } else {
        echo "No hay libros disponibles.";
    }
}

// Función para listar préstamos activos
$sql = "SELECT p.*, u.nombre AS usuario_nombre, l.titulo AS libro_titulo FROM prestamos p
        JOIN usuarios u ON p.usuario_id = u.id
        JOIN libros l ON p.libro_id = l.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Lista de Préstamos Activos</h2>";
foreach ($prestamos as $prestamo) {
    echo "ID: " . $prestamo['id'] . " - Usuario: " . $prestamo['usuario_nombre'] . " - Libro: " . $prestamo['libro_titulo'] . " - Fecha de Préstamo: " . $prestamo['fecha_prestamo'] . "<br>";
}

// Formulario para registrar un préstamo
?>
<h2>Registrar Préstamo</h2>
<form method="POST">
    ID Usuario: <input type="number" name="usuario_id" required><br>
    ID Libro: <input type="number" name="libro_id" required><br>
    <input type="submit" name="add_loan" value="Registrar Préstamo">
</form>
