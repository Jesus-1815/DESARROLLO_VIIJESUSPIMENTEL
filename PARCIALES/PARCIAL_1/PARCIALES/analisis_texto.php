<?php
include 'utilidades_texto.php';

// Definimos un array con 3 frases diferentes
$frases = [
    "Hola mundo desde PHP",
    "La programación es divertida",
    "Programacion en PHP"
];

echo "<table border='1'>";
echo "<tr>
        <th>Frase</th>
        <th>Número de Palabras</th>
        <th>Número de Vocales</th>
        <th>Palabras Invertidas</th>
      </tr>";

// Recorremos cada frase y utilizamos las funciones para procesarlas
foreach ($frases as $frase) {
    $numero_palabras = contar_palabras($frase);
    $numero_vocales = contar_vocales($frase);
    $palabras_invertidas = invertir_palabras($frase);
    
    echo "<tr>
            <td>$frase</td>
            <td>$numero_palabras</td>
            <td>$numero_vocales</td>
            <td>$palabras_invertidas</td>
          </tr>";
}

echo "</table>";
?>
