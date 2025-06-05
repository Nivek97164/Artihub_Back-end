<?php
require_once __DIR__ . '/../models/Subscription.php';
class SubscriptionController {
    private $model;
    public function __construct($pdo) {
        $this->model = new Subscription($pdo);
    }
    public function index() {
        echo json_encode($this->model->getAll());
    }
    public function store($data) {
        if ($this->model->create($data['user_id'], $data['plan_id'], $data['start_date'], $data['end_date'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insertion échouée"]);
        }
    }
}
