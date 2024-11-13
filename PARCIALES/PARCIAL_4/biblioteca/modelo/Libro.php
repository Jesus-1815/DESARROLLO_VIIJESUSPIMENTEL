<?php
require_once('../db/conexion.php');

class Libro {

    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getConnection(); 
    } 

    // Obtener libros guardados por el usuario
    public function librosFavoritosGuardados($user_id) {
        // Sanitizar $user_id antes de usarlo
        $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');
        
        $sql = "SELECT * FROM libros_guardados WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR); 
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }

    public function eliminarDeFavoritos($user_id, $google_books_id) {  
        // Sanitizar entradas
        $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');
        $google_books_id = htmlspecialchars($google_books_id, ENT_QUOTES, 'UTF-8');
        
        $sql = "DELETE FROM libros_guardados WHERE user_id = :user_id AND google_books_id = :google_books_id";  
        $stmt = $this->pdo->prepare($sql);  
        $stmt->bindParam(':user_id', $user_id);  
        $stmt->bindParam(':google_books_id', $google_books_id);  
        
        return $stmt->execute(); // Devuelve verdadero o falso según el resultado  
    }   

    public function agregarAFavoritos($user_id, $google_books_id, $titulo, $autor, $imagen, $reseña) {
        try {
            // Sanitizar entradas
            $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');
            $google_books_id = htmlspecialchars($google_books_id, ENT_QUOTES, 'UTF-8');
            $titulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
            $autor = htmlspecialchars($autor, ENT_QUOTES, 'UTF-8');
            $imagen = htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8');
            $reseña = htmlspecialchars($reseña, ENT_QUOTES, 'UTF-8');
            
            // Verificar si el libro ya está en los favoritos del usuario
            $sql = "SELECT COUNT(*) FROM libros_guardados WHERE user_id = :user_id AND google_books_id = :google_books_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':google_books_id', $google_books_id, PDO::PARAM_STR);
            $stmt->execute();
            $existing_book_count = $stmt->fetchColumn();
    
            if ($existing_book_count > 0) {
                return false;  
            }
    
            $sql = "INSERT INTO libros_guardados (user_id, google_books_id, titulo, autor, imagen_portada, resena_personal) 
                    VALUES (:user_id, :google_books_id, :titulo, :autor, :imagen_portada, :resena_personal)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':google_books_id', $google_books_id, PDO::PARAM_STR);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':autor', $autor, PDO::PARAM_STR);
            $stmt->bindParam(':imagen_portada', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':resena_personal', $reseña, PDO::PARAM_STR);
            $stmt->execute();
            // Retornar verdadero si la inserción es exitosa
            return true; 
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
}
?>



