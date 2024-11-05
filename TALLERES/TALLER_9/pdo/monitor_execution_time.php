<?php
require_once "config_pdo.php";

class ExecutionTimeMonitor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function executeWithTiming($query) {
        $start = microtime(true);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $executionTime = microtime(true) - $start;

        echo "Tiempo de ejecución: " . round($executionTime, 4) . " segundos<br>";
        return $stmt->fetchAll();
    }
}

// Ejemplo de uso
$monitor = new ExecutionTimeMonitor($pdo);
$query = "SELECT * FROM productos"; // Reemplaza con tu consulta crítica
$results = $monitor->executeWithTiming($query);
?>
