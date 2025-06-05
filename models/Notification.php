<?php
class Notification {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getByUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Notifications WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    public function create($user_id, $type, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO Notifications (user_id, type, message) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $type, $message]);
    }
}
?>