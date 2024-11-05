<?php
require_once "config_pdo.php";

class QueryAnalyzer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function analyzeQuery($query) {
        $explain = $this->pdo->query("EXPLAIN " . $query)->fetchAll();
        return $explain;
    }

    public function printAnalysis($analysis) {
        foreach ($analysis as $row) {
            echo implode(", ", $row) . "<br>";
        }
    }
}

// Ejemplo de uso
$analyzer = new QueryAnalyzer($pdo);
$query = "SELECT * FROM productos WHERE stock < 10"; // Reemplaza con tu consulta
$analysis = $analyzer->analyzeQuery($query);
$analyzer->printAnalysis($analysis);
?>
