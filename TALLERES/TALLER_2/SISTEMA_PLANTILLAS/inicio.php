<?php
$paginaActual = 'inicio'; // Cambia esto según el archivo
require_once 'funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include_once 'encabezado.php';
?>

<h2>Bienvenido a Nuestra Página de Inicio</h2>
<p>Descubre las últimas noticias, actualizaciones y recursos que ofrecemos en nuestra página de inicio. Aquí encontrarás información relevante sobre nuestros servicios y cómo podemos ayudarte a alcanzar tus objetivos.</p>

<?php
include_once 'pie_pagina.php';
?>