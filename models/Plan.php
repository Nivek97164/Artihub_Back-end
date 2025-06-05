<?php
class Plan {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        return $this->pdo->query("SELECT * FROM Plans")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($name, $description, $price, $duration_days) {
        $stmt = $this->pdo->prepare("INSERT INTO Plans (name, description, price, duration_days) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $duration_days]);
    }
}
