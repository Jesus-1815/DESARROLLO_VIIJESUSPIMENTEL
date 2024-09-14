<?php
// Función para leer el inventario desde el archivo JSON y convertirlo en un array de productos
function leerInventario() {
    $contenido = file_get_contents('inventario.json'); // Lee el archivo JSON
    return json_decode($contenido, true); // Convierte el JSON a array de PHP
}

// Función para ordenar el inventario alfabéticamente por nombre del producto
function ordenarInventario(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

// Función para mostrar un resumen del inventario ordenado (nombre, precio, cantidad)
function mostrarResumen($inventario) {
    echo "Resumen del Inventario:\n";
    foreach ($inventario as $producto) {
        echo "- {$producto['nombre']}: Precio = \${$producto['precio']}, Cantidad = {$producto['cantidad']}\n";
    }
}

// Función para calcular el valor total del inventario
function calcularValorTotal($inventario) {
    $valores = array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario);

    return array_sum($valores);
}

// Función para generar un informe de productos con stock bajo (menos de 5 unidades)
function informeStockBajo($inventario) {
    $bajoStock = array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });

    if (empty($bajoStock)) {
        echo "No hay productos con stock bajo.\n";
    } else {
        echo "Productos con stock bajo:\n";
        foreach ($bajoStock as $producto) {
            echo "- {$producto['nombre']}: Cantidad = {$producto['cantidad']}\n";
        }
    }
}

// Script principal para demostrar el uso de todas las funciones

// Leer el inventario
$inventario = leerInventario();

// Ordenar el inventario alfabéticamente
ordenarInventario($inventario);

// Mostrar el resumen del inventario
mostrarResumen($inventario);

// Calcular y mostrar el valor total del inventario
$valorTotal = calcularValorTotal($inventario);
echo "\nValor total del inventario: \$$valorTotal\n";

// Generar y mostrar el informe de productos con stock bajo
echo "\n";
informeStockBajo($inventario);
?>
