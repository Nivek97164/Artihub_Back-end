<?php
require_once __DIR__ . '/../models/ServiceRequest.php';
class ServiceRequestController {
    private $serviceRequest;
    public function __construct($pdo) {
        $this->serviceRequest = new ServiceRequest($pdo);
    }
    public function index() {
        echo json_encode($this->serviceRequest->getAll());
    }
    public function show($id) {
        echo json_encode($this->serviceRequest->getById($id));
    }
    public function store($data) {
        if ($this->serviceRequest->create($data['user_id'], $data['service_id'], $data['description'], $data['status'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Service request creation failed"]);
        }
    }
}
?>
