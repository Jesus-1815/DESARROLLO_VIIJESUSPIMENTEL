<?php
require_once 'config.php';

// Aquí puedes implementar todas las funciones de gestión de libros
// Ejemplo: Añadir un nuevo libro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $anio_publicacion = $_POST['anio_publicacion'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad) VALUES (:titulo, :autor, :isbn, :anio_publicacion, :cantidad)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':anio_publicacion' => $anio_publicacion,
        ':cantidad' => $cantidad
    ]);
    echo "Libro añadido con éxito.";
}

// Mostrar el formulario para añadir libro
?>

<form method="POST">
    Título: <input type="text" name="titulo" required><br>
    Autor: <input type="text" name="autor" required><br>
    ISBN: <input type="text" name="isbn" required><br>
    Año de Publicación: <input type="number" name="anio_publicacion" required><br>
    Cantidad Disponible: <input type="number" name="cantidad" required><br>
    <input type="submit" value="Añadir Libro">
</form>
