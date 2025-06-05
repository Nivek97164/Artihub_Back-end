<?php
require_once __DIR__ . '/../models/Payment.php';
class PaymentController {
    private $model;
    public function __construct($pdo) {
        $this->model = new Payment($pdo);
    }
    public function index() {
        echo json_encode($this->model->getAll());
    }
    public function store($data) {
        if ($this->model->create($data['user_id'], $data['amount'], $data['payment_method'], $data['status'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insertion échouée"]);
        }
    }
}
