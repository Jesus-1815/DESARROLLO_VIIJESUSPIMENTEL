<?php
session_start();
require_once '../controladores/LibroControlador.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: /PARCIALES/PARCIAL_4/biblioteca/auth/login.php');
    exit();
}


$libroControlador = new LibroControlador();
$librosFavoritos = $libroControlador->librosFavoritosGuardados($_SESSION['user_id']); 

// Procesar la eliminación de un libro de favoritos  
if (isset($_POST['eliminar_favorito'])) {  
    $user_id = $_SESSION['user_id'];  
    $google_books_id = $_POST['google_books_id'];  

    $libroControlador->eliminarDeFavoritos($user_id, $google_books_id);  
    // Recargar los favoritos después de la eliminación  
    $librosFavoritos = $libroControlador->librosFavoritosGuardados($user_id);   
}  
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Libros Favoritos</title>
    <link rel="stylesheet" href="/PARCIALES/PARCIAL_4/biblioteca/vistas/css/style_favoritos.css"> 
</head>
<body>
    <a href="/PARCIALES/PARCIAL_4/biblioteca/index.php" class="back-link">Volver a la página principal</a>
    <h1>Mis Libros Favoritos</h1>
    <?php
    if (!empty($librosFavoritos)) {
        echo "<ul class='book-list'>";
        foreach ($librosFavoritos as $libro) {
            $titulo = htmlspecialchars($libro->titulo ?? '');
            $autor = htmlspecialchars($libro->autor ?? '');
            $imagen = htmlspecialchars($libro->imagen_portada ?? '');
            $fecha_guardado = htmlspecialchars($libro->fecha_guardado ?? '');
            $google_books_id = htmlspecialchars($libro->google_books_id ?? ''); 
            $reseña = !empty($libro->resena_personal) ? htmlspecialchars($libro->resena_personal) : 'Sin reseña'; 

            echo "<li class='book-item'>";
            echo "<div class='book-info'>";
            echo "<img src='$imagen' alt='$titulo' class='book-thumbnail'>";
            echo "<div class='book-details'>";
            echo "<div class='book-title'>$titulo</div>";
            echo "<div class='authors'>Autor(es): $autor</div>";
            echo "<div class='reseña'>$reseña</div>"; 

            // Mostrar la fecha si está disponible
            if (!empty($fecha_guardado)) {
                echo "<div class='fecha-guardado'>Añadido a favoritos el: $fecha_guardado</div>";
            } else {
                echo "<div class='fecha-guardado'>Fecha de añadido: No disponible</div>";
            }

            // Formulario para eliminar de favoritos  
            echo "<form method='POST' action='favoritos.php' class='remove-form'>";  
            echo "<input type='hidden' name='google_books_id' value='$google_books_id'>";  
            echo "<button type='submit' name='eliminar_favorito' class='btn-remove'>Eliminar</button>";  
            echo "</form>";

            echo "</div></div>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='no-favorites'>No tienes libros en tu lista de favoritos.</p>";
    }
    ?>
</body>
</html>