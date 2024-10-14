<?php
// creaconfig_sesion.php
session_start([
    'cookie_lifetime' => 86400, // 24 horas
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
]);
?>
