<?php
$servername = "localhost";  // Cambia esto según tu configuración
$username = "root";         // Cambia esto según tu configuración
$password = "";             // Cambia esto según tu configuración
$database = "taller9_db";   // Nombre de la base de datos que creaste

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configurar modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
