<?php
// Parte 1: Patrón de triángulo rectángulo usando un bucle for
echo "<pre>";  // Usamos <pre> para mantener el formato en HTML
echo "Patrón de triángulo rectángulo:\n";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "\n"; // Nueva línea después de cada fila
}
echo "</pre>";

echo "<br>"; // Espacio entre patrones

// Parte 2: Secuencia de números impares del 1 al 20 usando un bucle while
echo "Números impares del 1 al 20:<br>";
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {
        echo $numero . " ";
    }
    $numero++;
}

echo "<br><br>"; // Espacio entre patrones

// Parte 3: Contador regresivo desde 10 hasta 1, saltando el número 5, usando un bucle do-while
echo "Contador regresivo desde 10 hasta 1 (sin el número 5):<br>";
$contador = 10;
do {
    if ($contador != 5) {
        echo $contador . " ";
    }
    $contador--;
} while ($contador >= 1);

echo "<br>"; // Final del programa
?>
