<?php
require_once __DIR__ . '/../models/Evaluation.php';
class EvaluationController {
    private $model;
    public function __construct($pdo) {
        $this->model = new Evaluation($pdo);
    }
    public function index() {
        echo json_encode($this->model->getAll());
    }
    public function store($data) {
        if ($this->model->create($data['evaluator_id'], $data['evaluated_id'], $data['rating'], $data['comment'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insertion échouée"]);
        }
    }
}
