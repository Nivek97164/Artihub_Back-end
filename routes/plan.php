<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth_required.php';
require_once __DIR__ . '/../controllers/PlanController.php';

$controller = new PlanController($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $controller->index();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->store($data);
        break;
}
