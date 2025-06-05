<?php
class Payment {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        return $this->pdo->query("SELECT * FROM Payments")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($user_id, $amount, $payment_method, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO Payments (user_id, amount, payment_method, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $amount, $payment_method, $status]);
    }
}
