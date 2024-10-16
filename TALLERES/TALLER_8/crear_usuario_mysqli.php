<?php
require_once "config_pdo.php"; // Cambia a "config_mysqli.php" si usas MySQLi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion == 'crear') {
            // Lógica para crear usuario
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];

            // Verificar si el email ya existe
            $sql_verificar = "SELECT id FROM usuarios WHERE email = :email";
            if ($stmt_verificar = $pdo->prepare($sql_verificar)) {
                $stmt_verificar->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt_verificar->execute();
                
                if ($stmt_verificar->rowCount() > 0) {
                    echo "ERROR: El correo electrónico ya está registrado.";
                } else {
                    // Si el email no existe, procedemos a crear el usuario
                    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
                    if ($stmt = $pdo->prepare($sql)) {
                        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

                        if ($stmt->execute()) {
                            echo "Usuario creado con éxito.";
                        } else {
                            echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
                        }
                    }
                    unset($stmt);
                }
            }
            unset($stmt_verificar);
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
                    echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
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
                    echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
                }
            }
            unset($stmt);
        }
    }
}

unset($pdo);
?>

<!-- Formulario para crear usuario -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="crear">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>

<!-- Formulario para actualizar usuario -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="actualizar">
    <div><label>ID</label><input type="number" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>

<!-- Formulario para eliminar usuario -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="accion" value="eliminar">
    <div><label>ID</label><input type="number" name="id" required></div>
    <input type="submit" value="Eliminar Usuario">
</form>

