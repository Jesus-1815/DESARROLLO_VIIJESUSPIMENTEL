<?php
require_once "config_pdo.php";

class CrearIndices {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function crearIndice($sql) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}

// Ejemplo de uso
$indiceCreador = new CrearIndices($pdo);

// Crear índices basados en el análisis
$indices = [
    "CREATE INDEX idx_categoria ON productos (id_categoria)",
    "CREATE INDEX idx_cliente_venta ON ventas (id_cliente)",
    "CREATE INDEX idx_fecha_venta ON ventas (fecha_venta)"
];

foreach ($indices as $indice) {
    $indiceCreador->crearIndice($indice);
    echo "Índice creado: $indice<br>";
}

$pdo = null;
?>
