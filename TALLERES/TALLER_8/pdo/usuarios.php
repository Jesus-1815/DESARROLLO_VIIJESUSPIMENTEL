<?php
require_once 'config.php';

// Función para añadir un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hash de la contraseña

    $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':contrasena' => $contrasena
    ]);
    echo "Usuario añadido con éxito.";
}

// Función para listar usuarios
$sql = "SELECT * FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Lista de Usuarios</h2>";
foreach ($usuarios as $usuario) {
    echo "ID: " . $usuario['id'] . " - Nombre: " . $usuario['nombre'] . " - Email: " . $usuario['email'] . "<br>";
}

// Formulario para añadir usuario
?>
<h2>Añadir Usuario</h2>
<form method="POST">
    Nombre: <input type="text" name="nombre" required><br>
    Email: <input type="email" name="email" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    <input type="submit" name="add_user" value="Añadir Usuario">
</form>
