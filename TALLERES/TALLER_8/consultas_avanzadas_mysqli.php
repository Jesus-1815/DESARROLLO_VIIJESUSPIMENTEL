<?php
require_once "config_mysqli.php";

// 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
$sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . htmlspecialchars($row['nombre']) . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }
} else {
    echo "No se encontraron usuarios o publicaciones.<br>";
}
mysqli_stmt_close($stmt);

// 2. Listar todas las publicaciones con el nombre del autor
$sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha_publicacion DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . htmlspecialchars($row['titulo']) . ", Autor: " . htmlspecialchars($row['autor']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
} else {
    echo "No se encontraron publicaciones.<br>";
}
mysqli_stmt_close($stmt);

// 3. Encontrar el usuario con más publicaciones
$sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id 
        ORDER BY num_publicaciones DESC 
        LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . htmlspecialchars($row['nombre']) . ", Número de publicaciones: " . $row['num_publicaciones'] . "<br>";
} else {
    echo "No se encontraron usuarios con publicaciones.<br>";
}
mysqli_stmt_close($stmt);

// 4. Mostrar las últimas 5 publicaciones con el nombre del autor y la fecha de publicación
$sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha_publicacion DESC 
        LIMIT 5";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Últimas 5 publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . htmlspecialchars($row['titulo']) . ", Autor: " . htmlspecialchars($row['autor']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
} else {
    echo "No se encontraron publicaciones recientes.<br>";
}
mysqli_stmt_close($stmt);

// 5. Listar los usuarios que no han realizado ninguna publicación
$sql = "SELECT u.nombre 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        WHERE p.id IS NULL";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Usuarios sin publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . htmlspecialchars($row['nombre']) . "<br>";
    }
} else {
    echo "No se encontraron usuarios sin publicaciones.<br>";
}
mysqli_stmt_close($stmt);

// 6. Calcular el promedio de publicaciones por usuario
$sql = "SELECT AVG(num_publicaciones) as promedio_publicaciones 
        FROM (SELECT COUNT(p.id) as num_publicaciones 
              FROM usuarios u 
              LEFT JOIN publicaciones p ON u.id = p.usuario_id 
              GROUP BY u.id) as subquery";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
    echo "<h3>Promedio de publicaciones por usuario:</h3>";
    echo "Promedio: " . round($row['promedio_publicaciones'], 2) . "<br>";
} else {
    echo "No se pudo calcular el promedio de publicaciones.<br>";
}
mysqli_stmt_close($stmt);

// 7. Encontrar la publicación más reciente de cada usuario
$sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        WHERE p.fecha_publicacion = (SELECT MAX(p2.fecha_publicacion) 
                                     FROM publicaciones p2 
                                     WHERE p2.usuario_id = u.id)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Publicación más reciente de cada usuario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . htmlspecialchars($row['nombre']) . ", Título: " . htmlspecialchars($row['titulo']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
} else {
    echo "No se encontraron publicaciones recientes por usuario.<br>";
}
mysqli_stmt_close($stmt);

mysqli_close($conn);
?>
