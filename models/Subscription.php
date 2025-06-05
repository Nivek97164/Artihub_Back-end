<?php
class Subscription {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        return $this->pdo->query("SELECT * FROM Subscriptions")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($user_id, $plan_id, $start_date, $end_date) {
        $stmt = $this->pdo->prepare("INSERT INTO Subscriptions (user_id, plan_id, start_date, end_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $plan_id, $start_date, $end_date]);
    }
}
