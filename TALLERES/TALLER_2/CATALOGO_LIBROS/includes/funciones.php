<?php
// Función que simula una base de datos y retorna un array de libros
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'Un clásico de la literatura española.'
        ],
        [
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'anio' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'Obra maestra de Gabriel García Márquez.'
        ],
        [
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'anio' => 1949,
            'genero' => 'Distopía',
            'descripcion' => 'Una novela distópica que critica los regímenes totalitarios.'
        ],
        [
            'titulo' => 'Moby Dick',
            'autor' => 'Herman Melville',
            'anio' => 1851,
            'genero' => 'Aventura',
            'descripcion' => 'La búsqueda obsesiva del capitán Ahab por la ballena blanca.'
        ],
        [
            'titulo' => 'Don Juan Tenorio',
            'autor' => 'José Zorrilla',
            'anio' => 1844,
            'genero' => 'Teatro',
            'descripcion' => 'Una obra teatral fundamental del romanticismo español.'
        ]
    ];
}

// Función que recibe un array de un libro y retorna una cadena HTML con los detalles formateados
function mostrarDetallesLibro($libro) {
    return "
    <div class='libro'>
        <h2>{$libro['titulo']}</h2>
        <p><strong>Autor:</strong> {$libro['autor']}</p>
        <p><strong>Año de Publicación:</strong> {$libro['anio']}</p>
        <p><strong>Género:</strong> {$libro['genero']}</p>
        <p><strong>Descripción:</strong> {$libro['descripcion']}</p>
    </div>
    ";
}
?>
