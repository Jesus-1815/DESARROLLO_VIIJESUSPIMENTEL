<?php
include 'config_sesion.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    if (!isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] = 0;
    }
    $_SESSION['carrito'][$id]++;
}

header('Location: ver_carrito.php');
exit;
?>
