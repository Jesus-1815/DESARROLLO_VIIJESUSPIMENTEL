<?php
require_once "config_pdo.php";

class OptimizarConsultas {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function consultaOptimizada() {
        $sql = "SELECT p.id_producto, p.nombre, SUM(dv.cantidad) AS total_vendido
                FROM productos p
                JOIN detalles_venta dv ON p.id_producto = dv.id_producto
                GROUP BY p.id_producto
                HAVING total_vendido > 0";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Ejemplo de uso
$optimizador = new OptimizarConsultas($pdo);
$resultado = $optimizador->consultaOptimizada();
echo "<h3>Consulta optimizada:</h3>";
print_r($resultado);

$pdo = null;
?>
