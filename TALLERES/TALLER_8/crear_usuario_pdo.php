<?php
require_once "config_pdo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];

    if ($accion == 'crear') {
        // Lógica para crear usuario
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "Usuario creado con éxito.";
            } else {
                echo "ERROR: No se pudo ejecutar la consulta. " . $stmt->errorInfo()[2];
            }
        }
        unset($stmt);
    } elseif ($accion == 'actualizar') {
        // Lógica para actualizar usuario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "Usuario actualizado con éxito.";
            } else {
                echo "ERROR: No se pudo ejecutar la consulta. " . $stmt->errorInfo()[2];
            }
        }
        unset($stmt);
    } elseif ($accion == 'eliminar') {
        // Lógica para eliminar usuario
        $id = $_POST['id'];

        $sql = "DELETE FROM usuarios WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Usuario eliminado con éxito.";
            } else {
                echo "ERROR: No se pudo ejecutar la consulta. " . $stmt->errorInfo()[2];
            }
        }
        unset($stmt);
    }
}

unset($pdo);
?>

<!-- Formulario para crear usuario -->
<h2>Crear Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="crear">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>

<!-- Formulario para actualizar usuario -->
<h2>Actualizar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="actualizar">
    <div><label>ID</label><input type="number" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>

<!-- Formulario para eliminar usuario -->
<h2>Eliminar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="eliminar">
    <div><label>ID</label><input type="number" name="id" required></div>
    <input type="submit" value="Eliminar Usuario">
</form>
