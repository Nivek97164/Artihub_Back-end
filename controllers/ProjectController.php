<?php
require_once __DIR__ . '/../models/Project.php';
class ProjectController {
    private $project;
    public function __construct($pdo) {
        $this->project = new Project($pdo);
    }
    public function index() {
        echo json_encode($this->project->getAll());
    }
    public function show($id) {
        echo json_encode($this->project->getById($id));
    }
    public function store($data) {
        if ($this->project->create($data['user_id'], $data['title'], $data['description'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Project creation failed"]);
        }
    }
}
?>
