<?php
// Declarar la variable $calificacion
$calificacion = 85;

// Determinar la letra correspondiente a la calificación
if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = 'A';
} elseif ($calificacion >= 80 && $calificacion < 90) {
    $letra = 'B';
} elseif ($calificacion >= 70 && $calificacion < 80) {
    $letra = 'C';
} elseif ($calificacion >= 60 && $calificacion < 70) {
    $letra = 'D';
} else {
    $letra = 'F';
}

// Imprimir el mensaje con la letra de la calificación
echo "Tu calificación es $letra. ";

// Usar el operador ternario para determinar si es "Aprobado" o "Reprobado"
$estado = ($letra != 'F') ? 'Aprobado' : 'Reprobado';
echo $estado;

// Usar el switch para imprimir un mensaje adicional
switch ($letra) {
    case 'A':
        echo ". Excelente trabajo";
        break;
    case 'B':
        echo ". Buen trabajo";
        break;
    case 'C':
        echo ". Trabajo aceptable";
        break;
    case 'D':
        echo ". Necesitas mejorar";
        break;
    case 'F':
        echo ". Debes esforzarte más";
        break;
}

?>
