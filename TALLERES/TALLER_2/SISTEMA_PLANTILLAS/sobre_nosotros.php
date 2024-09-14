<?php
$paginaActual = 'sobre_nosotros'; // Cambia esto según el archivo
require_once 'funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include_once 'encabezado.php';
?>

<h2>Conoce Más Sobre Nosotros</h2>
<p>Somos una empresa dedicada a ofrecer soluciones innovadoras. Nuestro equipo está comprometido con la excelencia y la satisfacción del cliente. Descubre nuestra historia, nuestros valores y lo que nos motiva a seguir creciendo.</p>

<?php
include_once 'pie_pagina.php';
?>