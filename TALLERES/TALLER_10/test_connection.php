<?php
require_once 'config.php';

try {
    // Obtener información del usuario autenticado
    $user = $github->get('/user');
    
    echo "<h2>Conexión exitosa</h2>";
    echo "<p>Usuario autenticado: " . htmlspecialchars($user['login']) . "</p>";
    echo "<p>Nombre: " . htmlspecialchars($user['name'] ?? 'No especificado') . "</p>";
    echo "<p>Repositorios públicos: " . htmlspecialchars($user['public_repos'] ?? '0') . "</p>";
    
} catch (Exception $e) {
    echo "<h2>Error de conexión</h2>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
