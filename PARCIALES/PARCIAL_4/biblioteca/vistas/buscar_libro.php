<?php
require_once '../api/google_books.php';
require_once '../controladores/LibroControlador.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "No has iniciado sesión. Por favor, inicie sesión para continuar.";
    exit;
}

$libroControlador = new LibroControlador();

// Limpiamos los datos de la sesión 
if (!isset($_POST['buscar']) && !isset($_POST['agregar_favorito'])) {
    unset($_SESSION['resultados_busqueda']);
    unset($_SESSION['mensajes']);
}


if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    // Llamar a la función para obtener los libros desde la API
    $libros = buscarLibros($busqueda);
    // Guardar los resultados en la sesión
    $_SESSION['resultados_busqueda'] = $libros;
}

// Verificar si se ha enviado la solicitud para agregar a favoritos
if (isset($_POST['agregar_favorito'])) {
    $user_id = $_SESSION['user_id'] ?? null;
    $google_books_id = $_POST['google_books_id'] ?? null;
    $titulo = $_POST['titulo'] ?? null;
    $autor = $_POST['autor'] ?? null;
    $imagen = $_POST['imagen_portada'] ?? null;
    $reseña = $_POST['reseña'] ?? ''; 

    if ($user_id && $google_books_id && $titulo && $autor && $imagen) {
        $resultado = $libroControlador->agregarAFavoritos($user_id, $google_books_id, $titulo, $autor, $imagen, $reseña);
        if ($resultado) {
            $_SESSION['mensajes'][$google_books_id] = "Añadido a favoritos!";
        } else {
            $_SESSION['mensajes'][$google_books_id] = "¡Ya está en tu lista de favoritos!";
        }
    } 

}

// Obtener los resultados de la sesión
$libros = $_SESSION['resultados_busqueda'] ?? null;
$mensajes = $_SESSION['mensajes'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Buscar Libro</title>
    <link rel="stylesheet" href="/PARCIALES/PARCIAL_4/biblioteca/vistas/css/style_buscar.css">
</head>
<body>
<a href="/PARCIALES/PARCIAL_4/biblioteca/index.php" class="back-link">Ir a la página principal</a>
    <h1>Buscar Libro</h1>
    <form method="POST" action="">
        <input type="text" id="busqueda" name="busqueda" placeholder="Buscar Libro" required>
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <?php
    if (isset($libros)) {
        if (!empty($libros)) {
            echo "<h2>Resultados de la búsqueda:</h2>";
            echo "<ul class='book-list'>";
            foreach ($libros as $item) {
                $title = $item['volumeInfo']['title'];
                $authors = isset($item['volumeInfo']['authors']) ? implode(", ", $item['volumeInfo']['authors']) : "Autor no disponible";
                $thumbnail = isset($item['volumeInfo']['imageLinks']['thumbnail']) ? $item['volumeInfo']['imageLinks']['thumbnail'] : 'https://via.placeholder.com/150';
                $infoLink = isset($item['volumeInfo']['infoLink']) ? $item['volumeInfo']['infoLink'] : '#';
                $google_books_id = $item['id'];

                echo "<li class='book-item'>";
                echo "<div class='book-info'>";
                echo "<img src='$thumbnail' alt='$title' class='book-image'>";
                echo "<div class='book-details'>";
                echo "<div class='book-title'>$title</div>";
                echo "<div class='authors'>Autor(es): $authors</div>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='google_books_id' value='$google_books_id'>";
                echo "<input type='hidden' name='titulo' value='$title'>";
                echo "<input type='hidden' name='autor' value='$authors'>";
                echo "<input type='hidden' name='imagen_portada' value='$thumbnail'>";
                
                echo "<textarea name='reseña' placeholder='Escribe una reseña'></textarea>";

                if (isset($mensajes[$google_books_id])) {
                    echo "<p class='mensaje'>" . $mensajes[$google_books_id] . "</p>";
                }
                echo "<br>";
                echo "<button type='submit' name='agregar_favorito' class='btn-favorito'>Añadir a Favoritos</button>";
                echo "</form>";
                echo "<a href='$infoLink' class='details-link' target='_blank'>Ver más detalles</a>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron libros con esa búsqueda.</p>";
        }
    }
    ?>
</body>
</html>

