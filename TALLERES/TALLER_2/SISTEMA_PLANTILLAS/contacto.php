<?php
$paginaActual = 'contacto'; // Cambia esto según el archivo
require_once 'funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include_once 'encabezado.php';
?>

<h2>Ponte en Contacto con Nosotros</h2>
<p>¿Tienes alguna pregunta o necesitas asistencia? Estamos aquí para ayudarte. Completa el formulario de contacto a continuación o utiliza cualquiera de nuestros canales de comunicación. Estaremos encantados de responder a tus consultas lo antes posible.</p>

<?php
include_once 'pie_pagina.php';
?>