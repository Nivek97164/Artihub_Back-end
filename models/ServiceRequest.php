<?php
class ServiceRequest {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM ServiceRequests");
        return $stmt->fetchAll();
    }
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ServiceRequests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($user_id, $service_id, $description, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO ServiceRequests (user_id, service_id, description, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $service_id, $description, $status]);
    }
}
?>
