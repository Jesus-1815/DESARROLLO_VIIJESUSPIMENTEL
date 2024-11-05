<?php
require_once "config_pdo.php";

class AnalizarRendimiento {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function analizarConsulta($sql) {
        $explainSql = "EXPLAIN " . $sql;
        $stmt = $this->pdo->query($explainSql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Ejemplo de uso
$analizador = new AnalizarRendimiento($pdo);

// Consultas a analizar
$consultas = [
    "SELECT * FROM productos WHERE id_categoria = 1",
    "SELECT v.id_venta, c.nombre FROM ventas v JOIN clientes c ON v.id_cliente = c.id_cliente",
    "SELECT COUNT(*) FROM ventas WHERE total > 100"
];

foreach ($consultas as $consulta) {
    $resultado = $analizador->analizarConsulta($consulta);
    echo "<h3>EXPLAIN para: $consulta</h3>";
    print_r($resultado);
}

$pdo = null;
?>
