
<?php
class Conexion {
    private $host = 'localhost'; 
    private $db = 'biblioteca_google';  
    private $user = 'root';    
    private $pass = '';       
    private $charset = 'utf8mb4';
    public $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    // Método para obtener la conexión
    public function getConnection() {
        return $this->pdo;
    }
}
?>
