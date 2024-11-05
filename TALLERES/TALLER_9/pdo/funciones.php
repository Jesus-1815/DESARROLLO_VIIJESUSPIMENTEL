<?php
require_once "config_pdo.php";
require_once "dinamicas.php";

// Filtrado de productos
function filtrarProductos($pdo, $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('productos p')
       ->select('p.*, c.nombre as categoria')
       ->join('categorias c', 'p.categoria_id', '=', 'c.id');

    if (isset($criterios['nombre'])) {
        $qb->where('p.nombre', 'LIKE', '%' . $criterios['nombre'] . '%');
    }

    if (isset($criterios['precio_min'])) {
        $qb->where('p.precio', '>=', $criterios['precio_min']);
    }

    if (isset($criterios['precio_max'])) {
        $qb->where('p.precio', '<=', $criterios['precio_max']);
    }

    if (isset($criterios['categorias']) && is_array($criterios['categorias'])) {
        $qb->whereIn('c.id', $criterios['categorias']);
    }

    if (isset($criterios['ordenar_por'])) {
        $qb->orderBy($criterios['ordenar_por'], $criterios['orden'] ?? 'ASC');
    }

    if (isset($criterios['limite'])) {
        $qb->limit($criterios['limite'], $criterios['offset'] ?? 0);
    }

    return $qb->execute();
}

// Generador de reportes
function generarReporte($pdo, $campos, $filtros) {
    $qb = new QueryBuilder($pdo);
    $qb->table('ventas v')
       ->select($campos);

    // Aplicar filtros si existen
    if (!empty($filtros['fecha_inicio'])) {
        $qb->where('v.fecha', '>=', $filtros['fecha_inicio']);
    }
    if (!empty($filtros['fecha_fin'])) {
        $qb->where('v.fecha', '<=', $filtros['fecha_fin']);
    }
    if (!empty($filtros['cliente_id'])) {
        $qb->where('v.cliente_id', '=', $filtros['cliente_id']);
    }
    if (!empty($filtros['producto_id'])) {
        $qb->where('v.producto_id', '=', $filtros['producto_id']);
    }
    if (!empty($filtros['monto_min'])) {
        $qb->where('v.monto', '>=', $filtros['monto_min']);
    }
    if (!empty($filtros['monto_max'])) {
        $qb->where('v.monto', '<=', $filtros['monto_max']);
    }

    return $qb->execute();
}

// Búsqueda de ventas
function buscarVentas($pdo, $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('ventas v')
       ->select('v.*, c.nombre as cliente, p.nombre as producto')
       ->join('clientes c', 'v.cliente_id', '=', 'c.id')
       ->join('productos p', 'v.producto_id', '=', 'p.id');

    // Aplicar filtros
    if (isset($criterios['fecha_inicio'])) {
        $qb->where('v.fecha', '>=', $criterios['fecha_inicio']);
    }

    if (isset($criterios['fecha_fin'])) {
        $qb->where('v.fecha', '<=', $criterios['fecha_fin']);
    }

    if (isset($criterios['cliente_id'])) {
        $qb->where('v.cliente_id', '=', $criterios['cliente_id']);
    }

    if (isset($criterios['producto_id'])) {
        $qb->where('v.producto_id', '=', $criterios['producto_id']);
    }

    if (isset($criterios['monto_min'])) {
        $qb->where('v.monto', '>=', $criterios['monto_min']);
    }

    if (isset($criterios['monto_max'])) {
        $qb->where('v.monto', '<=', $criterios['monto_max']);
    }

    return $qb->execute();
}

// Actualización masiva de productos
function actualizarProductos($pdo, $cambios, $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('productos');

    // Aplicar cambios
    foreach ($cambios as $campo => $valor) {
        $qb->set([$campo => $valor]);
    }

    // Aplicar criterios para la actualización
    if (isset($criterios['categoria_id'])) {
        $qb->where('categoria_id', '=', $criterios['categoria_id']);
    }

    if (isset($criterios['precio_min'])) {
        $qb->where('precio', '>=', $criterios['precio_min']);
    }

    if (isset($criterios['precio_max'])) {
        $qb->where('precio', '<=', $criterios['precio_max']);
    }

    return $qb->execute();
}
?>
