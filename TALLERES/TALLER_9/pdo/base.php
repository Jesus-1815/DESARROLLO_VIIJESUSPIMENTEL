<?php
class Paginator {
    protected $pdo;
    protected $table;
    protected $perPage;
    protected $currentPage;
    protected $conditions = [];
    protected $params = [];
    protected $orderBy = '';

    public function __construct(PDO $pdo, $table, $perPage = 10) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->perPage = $perPage;
        $this->currentPage = 1;
    }

    public function where($condition, $params = []) {
        $this->conditions[] = $condition;
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function orderBy($orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setPage($page) {
        $this->currentPage = max(1, (int)$page);
        return $this;
    }

    public function getTotalRecords() {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchColumn();
    }

    public function getResults() {
        $offset = ($this->currentPage - 1) * $this->perPage;
        
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }
        
        $sql .= " LIMIT {$this->perPage} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageInfo() {
        $totalRecords = $this->getTotalRecords();
        $totalPages = ceil($totalRecords / $this->perPage);

        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
        ];
    }
}
?>
