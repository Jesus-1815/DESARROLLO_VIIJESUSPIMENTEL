<?php
$nombre = "sesion";
$valor = "yes";
$expira = time() + (60 * 60 * 24 * 365); // 1 año de duración
$direc = "/COOKIS/";
$dominio = "localhost";
$https = false;
$http = false;

// Configura la cookie
setcookie($nombre, $valor, $expira, $direc, $dominio, $https, $http);

// Verifica si la cookie existe antes de acceder a ella
if (isset($_COOKIE['sesion'])) {
    echo $_COOKIE['sesion'];
} else {
    echo "La cookie 'sesion' aún no está disponible.";
}
?>
