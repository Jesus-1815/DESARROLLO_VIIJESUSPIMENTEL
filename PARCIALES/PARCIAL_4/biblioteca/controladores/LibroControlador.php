<?php
require_once('../modelo/Libro.php');
require_once('../modelo/Usuario.php');
class LibroControlador {
 
    private $libro;

    public function __construct() {
        // Crear una nueva instancia de la clase Libro
        $this->libro = new Libro();
    }

    // Obtener los libros guardados de un usuario
    public function librosFavoritosGuardados($user_id) {
        return $this->libro->librosFavoritosGuardados($user_id);
    }

    // Eliminar un libro de favoritos  
    public function eliminarDeFavoritos($user_id, $google_books_id) {  
        return $this->libro->eliminarDeFavoritos($user_id, $google_books_id);  
    }  


     // Guardar un libro en favoritos
    public function agregarAFavoritos($user_id, $google_books_id, $titulo, $autor, $imagen, $reseña) {
        return $this->libro->agregarAFavoritos($user_id, $google_books_id, $titulo, $autor, $imagen, $reseña);
    }

}
?>


