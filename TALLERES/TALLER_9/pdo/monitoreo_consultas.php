<?php
require_once "config_pdo.php";

class MonitoreoConsultas {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ejecutarConsulta($sql) {
        $inicio = microtime(true);
        $stmt = $this->pdo->query($sql);
        $fin = microtime(true);
        
        $tiempo = $fin - $inicio;
        $this->registrarTiempo($sql, $tiempo);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function registrarTiempo($consulta, $tiempo) {
        // Aquí podrías guardar en un archivo o base de datos
        echo "Consulta: $consulta ejecutada en: {$tiempo}s<br>";
    }
}

// Ejemplo de uso
$monitoreo = new MonitoreoConsultas($pdo);
$resultado = $monitoreo->ejecutarConsulta("SELECT * FROM productos WHERE stock > 0");
print_r($resultado);

$pdo = null;
?>
