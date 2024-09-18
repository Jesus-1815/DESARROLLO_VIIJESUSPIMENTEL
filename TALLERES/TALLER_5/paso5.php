<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        // Usar correctamente la interpolación de variables
        echo "{$producto['nombre']} - \${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);

echo "\nValor total del inventario: $$valorTotal\n";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "\nProducto más caro: {$productoMasCaro['nombre']} (\${$productoMasCaro['precio']})\n";

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Convertir el arreglo actualizado de vuelta a JSON
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";

// TAREA: Implementa una función que genere un resumen de ventas
// Crea un arreglo de ventas (producto_id, cliente_id, cantidad, fecha)
// y genera un informe que muestre:
// - Total de ventas
// - Producto más vendido
// - Cliente que más ha comprado

// Arreglo de ventas (producto_id, cliente_id, cantidad, fecha)
$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 2, "fecha" => "2024-09-01"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2024-09-02"],
    ["producto_id" => 3, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2024-09-03"],
    ["producto_id" => 1, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2024-09-04"],
    ["producto_id" => 4, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2024-09-05"]
];

// Función para generar un informe de ventas
function generarInformeVentas($ventas, $productos, $clientes) {
    $informe = [
        'total_ventas' => 0,
        'productos_vendidos' => [],
        'clientes_compras' => []
    ];

    foreach ($ventas as $venta) {
        // Sumar el valor total de las ventas
        $producto = array_filter($productos, function($p) use ($venta) {
            return $p['id'] == $venta['producto_id'];
        });
        $producto = array_values($producto)[0];
        $informe['total_ventas'] += $producto['precio'] * $venta['cantidad'];

        // Sumar la cantidad vendida por producto
        if (!isset($informe['productos_vendidos'][$producto['id']])) {
            $informe['productos_vendidos'][$producto['id']] = [
                'nombre' => $producto['nombre'],
                'cantidad' => 0
            ];
        }
        $informe['productos_vendidos'][$producto['id']]['cantidad'] += $venta['cantidad'];

        // Sumar la cantidad de compras por cliente
        if (!isset($informe['clientes_compras'][$venta['cliente_id']])) {
            $cliente = array_filter($clientes, function($c) use ($venta) {
                return $c['id'] == $venta['cliente_id'];
            });
            $cliente = array_values($cliente)[0];
            $informe['clientes_compras'][$venta['cliente_id']] = [
                'nombre' => $cliente['nombre'],
                'cantidad' => 0
            ];
        }
        $informe['clientes_compras'][$venta['cliente_id']]['cantidad'] += $venta['cantidad'];
    }

    // Determinar el producto más vendido
    usort($informe['productos_vendidos'], function($a, $b) {
        return $b['cantidad'] - $a['cantidad'];
    });
    $informe['producto_mas_vendido'] = $informe['productos_vendidos'][0];

    // Determinar el cliente que más ha comprado
    usort($informe['clientes_compras'], function($a, $b) {
        return $b['cantidad'] - $a['cantidad'];
    });
    $informe['cliente_que_mas_compro'] = $informe['clientes_compras'][0];

    return $informe;
}

// Generar el informe de ventas
$informeVentas = generarInformeVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);
echo "\nInforme de ventas:\n";
echo "Total de ventas: $" . $informeVentas['total_ventas'] . "\n";
echo "Producto más vendido: " . $informeVentas['producto_mas_vendido']['nombre'] . 
     " (Cantidad: " . $informeVentas['producto_mas_vendido']['cantidad'] . ")\n";
echo "Cliente que más ha comprado: " . $informeVentas['cliente_que_mas_compro']['nombre'] . 
     " (Cantidad: " . $informeVentas['cliente_que_mas_compro']['cantidad'] . ")\n";

?>

