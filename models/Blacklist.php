<?php
class Blacklist {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        return $this->pdo->query("SELECT * FROM BlacklistSystem")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function block($user_id, $reason) {
        $stmt = $this->pdo->prepare("INSERT INTO BlacklistSystem (user_id, reason) VALUES (?, ?)");
        return $stmt->execute([$user_id, $reason]);
    }
}
