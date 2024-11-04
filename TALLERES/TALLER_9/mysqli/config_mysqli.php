<?php
// Configuración de la base de datos
$host = "localhost"; // Cambia esto si tu servidor no está en localhost
$usuario = "root"; // Tu nombre de usuario de MySQL
$contraseña = ""; // Tu contraseña de MySQL
$basededatos = "taller9_db"; // El nombre de tu base de datos

// Crear conexión
$conn = mysqli_connect($host, $usuario, $contraseña, $basededatos);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>



