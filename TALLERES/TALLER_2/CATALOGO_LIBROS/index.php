<?php
// Incluir los archivos necesarios
require_once 'includes/funciones.php';
require_once 'includes/header.php';
require_once 'includes/footer.php';

// Obtener la lista de libros
$libros = obtenerLibros();

// Mostrar los detalles de cada libro
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}
?>
