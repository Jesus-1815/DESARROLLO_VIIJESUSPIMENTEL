
<?php

class UsuarioControlador {

    public static function registrarUsuario($usuario) {
        // Verificar si el usuario ya está registrado usando su google_id
        if (Usuario::existeEnBaseDeDatos($usuario->google_id)) {
            return false; 
        }
    
        if (!filter_var($usuario->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo electrónico no es válido");
        }
    
        $nombre = htmlspecialchars($usuario->nombre);
    
        $conexion = new Conexion();
        $db = $conexion->getConnection();
    
        try {
            // Usamos transacción para asegurar que el registro se haga de forma segura
            $db->beginTransaction();
    
            // Preparar la consulta para insertar el nuevo usuario
            $query = $db->prepare("INSERT INTO usuario (nombre, email, google_id) VALUES (?, ?, ?)");
            $query->execute([$nombre, $usuario->email, $usuario->google_id]);
    
            // Confirmar la transacción
            $db->commit();
    
            // Retorna true si el usuario fue insertado correctamente
            return $query->rowCount() > 0;
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $db->rollBack();
            throw new Exception("Error al registrar el usuario: " . $e->getMessage());
        }
    }
    
// Método para obtener un usuario por su ID
public static function obtenerUsuarioPorId($id) {
    $conexion = new Conexion();
    $db = $conexion->getConnection();

    $query = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
    $query->execute([$id]);

    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        return new Usuario($resultado['id'], $resultado['nombre'], $resultado['email'], $resultado['google_id']);
    }
    // Si no se encontró el usuario
    return null; 
}

// Método para obtener un usuario por su google_id
public static function obtenerUsuarioPorGoogleId($google_id) {
    $conexion = new Conexion();
    $db = $conexion->getConnection();

    $query = $db->prepare("SELECT * FROM usuarios WHERE google_id = ?");
    $query->execute([$google_id]);

    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        return new Usuario($resultado['id'], $resultado['nombre'], $resultado['email'], $resultado['google_id']);
    }
    // Si no se encontró el usuario
    return null; 
}
}
