<?php
function exportToCSV($results, $filename = 'export.csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    // Header
    fputcsv($output, ['ID', 'Nombre', 'Precio', 'Categoría']);

    // Data
    foreach ($results as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}
?>
