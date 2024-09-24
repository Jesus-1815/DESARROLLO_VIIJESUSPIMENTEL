<?php
include 'funciones_tienda.php';

// Array de productos con sus precios
$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Array que simula el carrito de compras
$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

// Calcular el subtotal de la compra
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    if (isset($productos[$producto]) && $cantidad > 0) {
        $subtotal += $productos[$producto] * $cantidad;
    }
}

// Calcular descuento, impuesto y total
$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal);
$total_a_pagar = calcular_total($subtotal, $descuento, $impuesto);

// Mostrar resumen de la compra en formato HTML
echo "<h2>Resumen de la compra</h2>";
echo "<table border='1'>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>";

foreach ($carrito as $producto => $cantidad) {
    if (isset($productos[$producto]) && $cantidad > 0) {
        $precio_unitario = $productos[$producto];
        $total_producto = $precio_unitario * $cantidad;
        echo "<tr>
                <td>$producto</td>
                <td>$cantidad</td>
                <td>\$$precio_unitario</td>
                <td>\$$total_producto</td>
              </tr>";
    }
}

echo "</table>";
echo "<p><strong>Subtotal:</strong> \$$subtotal</p>";
echo "<p><strong>Descuento aplicado:</strong> \$$descuento</p>";
echo "<p><strong>Impuesto (7%):</strong> \$$impuesto</p>";
echo "<p><strong>Total a pagar:</strong> \$$total_a_pagar</p>";
?>
