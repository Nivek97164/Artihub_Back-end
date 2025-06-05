<?php
require_once __DIR__ . '/../models/Blacklist.php';
class BlacklistController {
    private $model;
    public function __construct($pdo) {
        $this->model = new Blacklist($pdo);
    }
    public function index() {
        echo json_encode($this->model->getAll());
    }
    public function store($data) {
        if ($this->model->block($data['user_id'], $data['reason'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insertion échouée"]);
        }
    }
}
