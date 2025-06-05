<?php
require_once __DIR__ . '/../middleware/auth_required.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/FavoriteController.php';

$controller = new FavoriteController($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['user_id'])) {
            $controller->index($_GET['user_id']);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "user_id required"]);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->store($data);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->delete($data);
        break;
}
?>