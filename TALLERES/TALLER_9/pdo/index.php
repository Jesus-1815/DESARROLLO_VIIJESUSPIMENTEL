<?php
require 'config_pdo.php';
require 'base.php';
require 'cache.php';
require 'export_csv.php';

$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Caching
$cache = new Cache();
$cacheKey = "productos_page_{$page}_per_{$perPage}";
$cachedResults = $cache->get($cacheKey);

if ($cachedResults !== false) {
    $results = $cachedResults;
} else {
    $base = new base($pdo, 'productos', $perPage);
    $results = $base->getResults();
    $cache->set($cacheKey, $results);
}

$pageInfo = $base->getPageInfo();

if (isset($_GET['export']) && $_GET['export'] === '1') {
    exportToCSV($results);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
</head>
<body>
    <h1>Catálogo de Productos</h1>
    
    <form method="get" action="">
        <label for="per_page">Elementos por página:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()">
            <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?= $perPage == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50</option>
        </select>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td>$<?= number_format($row['precio'], 2) ?></td>
                <td><?= htmlspecialchars($row['categoria']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="?export=1&per_page=<?= $perPage ?>&page=<?= $page ?>">Exportar a CSV</a>

    <div class="pagination">
        <?php if ($pageInfo['current_page'] > 1): ?>
            <a href="?page=1&per_page=<?= $perPage ?>">Primera</a>
            <a href="?page=<?= $pageInfo['current_page'] - 1 ?>&per_page=<?= $perPage ?>">Anterior</a>
        <?php endif; ?>

        <span>Página <?= $pageInfo['current_page'] ?> de <?= $pageInfo['total_pages'] ?></span>

        <?php if ($pageInfo['current_page'] < $pageInfo['total_pages']): ?>
            <a href="?page=<?= $pageInfo['current_page'] + 1 ?>&per_page=<?= $perPage ?>">Siguiente</a>
            <a href="?page=<?= $pageInfo['total_pages'] ?>&per_page=<?= $perPage ?>">Última</a>
        <?php endif; ?>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                // Cargar más productos
                var nextPage = <?= $pageInfo['current_page'] ?> + 1;
                if (nextPage <= <?= $pageInfo['total_pages'] ?>) {
                    fetch(`?page=${nextPage}&per_page=<?= $perPage ?>`)
                        .then(response => response.text())
                        .then(data => {
                            document.querySelector('tbody').innerHTML += data;
                        });
                }
            }
        });
    </script>
</body>
</html>

