<?php
$nombre_completo = "Jesus Pimentel";
$edad = 20;
$correo = "jesus.pimentel@utp.ac.pa";
$telefono = "66690904";

define("OCUPACION", "Estudiante");

echo "Nombre completo: " . $nombre_completo . "<br>";
echo "Edad: " . $edad . "<br>";
print "Correo: " . $correo . "<br>";
printf("Teléfono: %s<br>", $telefono);
echo "Ocupación: " . OCUPACION . "<br>";

var_dump($nombre_completo);
echo "<br>";

var_dump($edad);
echo "<br>";

var_dump($correo);
echo "<br>";

var_dump($telefono);
echo "<br>";

var_dump(OCUPACION);
echo "<br>";
?>
