<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "biblioteca";

// Crear conexión
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
