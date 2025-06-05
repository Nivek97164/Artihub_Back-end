<?php
require_once __DIR__ . '/../models/Plan.php';
class PlanController {
    private $model;
    public function __construct($pdo) {
        $this->model = new Plan($pdo);
    }
    public function index() {
        echo json_encode($this->model->getAll());
    }
    public function store($data) {
        if ($this->model->create($data['name'], $data['description'], $data['price'], $data['duration_days'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insertion échouée"]);
        }
    }
}
