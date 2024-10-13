<?php
// Leer el archivo JSON de registros
$archivoJson = 'uploads/registros.json';

if (file_exists($archivoJson)) {
    $registros = json_decode(file_get_contents($archivoJson), true);
} else {
    $registros = [];
}

echo "<h2>Resumen de Registros</h2>";

if (!empty($registros)) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Fecha de Nacimiento</th>
            <th>Edad</th>
            <th>Género</th>
            <th>Intereses</th>
            <th>Comentarios</th>
            <th>Foto de Perfil</th>
          </tr>";
    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($registro['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['email']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['fecha_nacimiento']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['edad']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['genero']) . "</td>";
        echo "<td>" . implode(", ", $registro['intereses']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['comentarios']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($registro['foto_perfil']) . "' width='100'></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay registros disponibles.</p>";
}

echo "<br><a href='formulario.html'>Volver al formulario</a>";
?>
