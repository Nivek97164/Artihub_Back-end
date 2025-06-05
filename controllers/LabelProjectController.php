<?php
require_once __DIR__ . '/../models/LabelProject.php';
class LabelProjectController {
    private $label;
    public function __construct($pdo) {
        $this->label = new LabelProject($pdo);
    }
    public function index($project_id) {
        echo json_encode($this->label->getByProject($project_id));
    }
    public function store($data) {
        if ($this->label->add($data['project_id'], $data['label'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Label creation failed"]);
        }
    }
}
?>