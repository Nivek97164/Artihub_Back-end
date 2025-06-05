<?php
require_once __DIR__ . '/../middleware/auth_required.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/LabelProjectController.php';

$controller = new LabelProjectController($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['project_id'])) {
            $controller->index($_GET['project_id']);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "project_id required"]);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->store($data);
        break;
}
?>