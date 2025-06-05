<?php
require_once __DIR__ . '/../middleware/auth_required.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProjectController.php';

$controller = new ProjectController($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->show($_GET['id']);
        } else {
            $controller->index();
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->store($data);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
?>
