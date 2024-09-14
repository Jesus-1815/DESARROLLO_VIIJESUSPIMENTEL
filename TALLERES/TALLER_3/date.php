<?php
// Ejemplo de uso de date()
echo "Fecha actual: " . date("Y-m-d") . "</br>";
echo "Hora actual: " . date("H:i:s") . "</br>";
echo "Fecha y hora actuales: " . date("Y-m-d H:i:s") . "</br>";

// Ejercicio: Usa date() para mostrar la fecha actual en el formato "Día de la semana, día de mes de año"
// Por ejemplo: "Lunes, 15 de agosto de 2023"
$fechaFormateada = date("l, j \de F \de Y");
echo "Fecha formateada: $fechaFormateada</br>";

// Experimenta con diferentes formatos de fecha
echo "</br>Formato 1: " . date("d/m/Y") . "</br>";
echo "Formato 2: " . date("F j, Y") . "</br>";
echo "Formato 3: " . date("D, M j, Y") . "</br>";
echo "Formato 4: " . date("l, jS \of F Y h:i:s A") . "</br>";

// Bonus: Crea una función que devuelva la diferencia en días entre dos fechas
function diasEntre($fecha1, $fecha2) {
    $timestamp1 = strtotime($fecha1);
    $timestamp2 = strtotime($fecha2);
    $diferencia = abs($timestamp2 - $timestamp1);
    return floor($diferencia / (60 * 60 * 24));
}

// Modifica la función diasEntre() para calcular la diferencia entre otras fechas
$fechaInicio = "2023-01-01";
$fechaFin = date("Y-m-d"); // Fecha actual
$diasTranscurridos = diasEntre($fechaInicio, $fechaFin);

echo "</br>Días transcurridos desde el $fechaInicio hasta hoy: $diasTranscurridos días</br>";

$otraFechaInicio = "2022-05-10";
$otraFechaFin = "2023-08-29";
$diasEntreFechas = diasEntre($otraFechaInicio, $otraFechaFin);
echo "Días entre $otraFechaInicio y $otraFechaFin: $diasEntreFechas días</br>";

// Extra: Mostrar zona horaria actual
echo "</br>Zona horaria actual: " . date_default_timezone_get() . "</br>";

// Cambiar zona horaria y mostrar la hora
date_default_timezone_set("America/New_York");
echo "Hora en New York: " . date("H:i:s") . "</br>";

// Prueba a cambiar la zona horaria a diferentes regiones y observa cómo afecta a la hora mostrada
date_default_timezone_set("Europe/London");
echo "Hora en Londres: " . date("H:i:s") . "</br>";

date_default_timezone_set("Asia/Tokyo");
echo "Hora en Tokio: " . date("H:i:s") . "</br>";

date_default_timezone_set("Australia/Sydney");
echo "Hora en Sídney: " . date("H:i:s") . "</br>";

?>

