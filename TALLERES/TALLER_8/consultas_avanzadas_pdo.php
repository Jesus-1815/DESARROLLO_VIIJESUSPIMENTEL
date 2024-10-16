<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
    $sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "<h3>Usuarios y número de publicaciones:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Usuario: " . htmlspecialchars($row['nombre']) . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
        }
    } else {
        echo "No se encontraron usuarios o publicaciones.<br>";
    }

    // 2. Listar todas las publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "<h3>Publicaciones con nombre del autor:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Título: " . htmlspecialchars($row['titulo']) . ", Autor: " . htmlspecialchars($row['autor']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }
    } else {
        echo "No se encontraron publicaciones.<br>";
    }

    // 3. Encontrar el usuario con más publicaciones
    $sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY num_publicaciones DESC 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Usuario con más publicaciones:</h3>";
    if ($row) {
        echo "Nombre: " . htmlspecialchars($row['nombre']) . ", Número de publicaciones: " . $row['num_publicaciones'] . "<br>";
    } else {
        echo "No se encontraron usuarios con publicaciones.<br>";
    }

    // 4. Mostrar las últimas 5 publicaciones con el nombre del autor y la fecha de publicación
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC 
            LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "<h3>Últimas 5 publicaciones:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Título: " . htmlspecialchars($row['titulo']) . ", Autor: " . htmlspecialchars($row['autor']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }
    } else {
        echo "No se encontraron publicaciones recientes.<br>";
    }

    // 5. Listar los usuarios que no han realizado ninguna publicación
    $sql = "SELECT u.nombre 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            WHERE p.id IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "<h3>Usuarios sin publicaciones:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Usuario: " . htmlspecialchars($row['nombre']) . "<br>";
        }
    } else {
        echo "No se encontraron usuarios sin publicaciones.<br>";
    }

    // 6. Calcular el promedio de publicaciones por usuario
    $sql = "SELECT AVG(num_publicaciones) as promedio_publicaciones 
            FROM (SELECT COUNT(p.id) as num_publicaciones 
                  FROM usuarios u 
                  LEFT JOIN publicaciones p ON u.id = p.usuario_id 
                  GROUP BY u.id) as subquery";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Promedio de publicaciones por usuario:</h3>";
    if ($row) {
        echo "Promedio: " . round($row['promedio_publicaciones'], 2) . "<br>";
    } else {
        echo "No se pudo calcular el promedio de publicaciones.<br>";
    }

    // 7. Encontrar la publicación más reciente de cada usuario
    $sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            WHERE p.fecha_publicacion = (SELECT MAX(p2.fecha_publicacion) 
                                         FROM publicaciones p2 
                                         WHERE p2.usuario_id = u.id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "<h3>Publicación más reciente de cada usuario:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Usuario: " . htmlspecialchars($row['nombre']) . ", Título: " . htmlspecialchars($row['titulo']) . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }
    } else {
        echo "No se encontraron publicaciones recientes por usuario.<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
