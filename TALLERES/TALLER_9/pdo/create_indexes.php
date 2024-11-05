<?php
require_once "config_pdo.php";

class IndexManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function indexExists($table, $indexName) {
        $query = "SHOW INDEX FROM $table WHERE Key_name = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$indexName]);
        return $stmt->rowCount() > 0;
    }

    public function columnExists($table, $columnName) {
        $query = "SHOW COLUMNS FROM $table LIKE ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$columnName]);
        return $stmt->rowCount() > 0;
    }

    public function createIndex($table, $column) {
        $indexName = "idx_$column";
        
        // Verificar si la columna existe
        if (!$this->columnExists($table, $column)) {
            echo "La columna '$column' no existe en la tabla '$table'.<br>";
            return;
        }

        // Verificar si el índice ya existe
        if ($this->indexExists($table, $indexName)) {
            echo "El índice '$indexName' ya existe en la tabla '$table'.<br>";
            return;
        }

        // Crear el índice
        $query = "CREATE INDEX $indexName ON $table ($column)";
        $this->pdo->exec($query);
        echo "Índice creado en $table($column)<br>";
    }
}

// Ejemplo de uso
$indexManager = new IndexManager($pdo);
$indexManager->createIndex('productos', 'stock'); // Cambia 'productos' y 'stock' según tus necesidades

// Cambia 'detalles_venta' y 'venta_id' según lo que hayas verificado en tu estructura
$indexManager->createIndex('detalles_venta', 'id_venta'); // Asegúrate de que la columna exista
?>
