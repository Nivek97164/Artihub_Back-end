<?php
class Project {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Projects");
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($user_id, $title, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO Projects (user_id, title, description) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $title, $description]);
    }
}
?>
