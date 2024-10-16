<?php
require_once "config_pdo.php";

function log_error($message) {
    $log_file = 'error_log.txt'; // El archivo donde se guardarán los logs
    $current_time = date('Y-m-d H:i:s'); // Tiempo actual
    $formatted_message = "[$current_time] ERROR: $message\n"; // Mensaje formateado
    file_put_contents($log_file, $formatted_message, FILE_APPEND); // Escribir en el archivo
}

try {
    $pdo->beginTransaction();

    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    
    if (!$stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com'])) {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }
    
    $usuario_id = $pdo->lastInsertId();

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    
    if (!$stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ])) {
        throw new Exception("Error en la consulta: " . $stmt->errorInfo()[2]);
    }

    $pdo->commit();
    echo "Transacción completada con éxito.";
} catch (Exception $e) {
    $pdo->rollBack();
    log_error($e->getMessage()); // Registro de error
    echo "Error en la transacción: " . $e->getMessage();
}
?>
