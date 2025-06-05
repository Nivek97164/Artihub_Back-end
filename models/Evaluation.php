<?php
class Evaluation {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAll() {
        return $this->pdo->query("SELECT * FROM Evaluations")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($evaluator_id, $evaluated_id, $rating, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO Evaluations (evaluator_id, evaluated_id, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$evaluator_id, $evaluated_id, $rating, $comment]);
    }
}
