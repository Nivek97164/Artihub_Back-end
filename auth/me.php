<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: http://https://artihubfront-end-production-3c59.up.railway.app");
    header("Access-Control-Allow-Credentials: true"); // AJOUTE MOI ÇA !
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit;
}


header("Access-Control-Allow-Origin: http://https://artihubfront-end-production-3c59.up.railway.app");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/jwt.php';

$token = $_COOKIE['jwt'] ?? null;

if (!$token) {
    http_response_code(401);
    echo json_encode(['error' => 'Token manquant']);
    exit;
}

$decoded = verify_jwt($token);
if (!$decoded || empty($decoded->user_id)) {
    http_response_code(401);
    echo json_encode(['error' => 'Token invalide ou expiré']);
    exit;
}
if (!isset($_COOKIE['jwt'])) {
    http_response_code(401);
    echo json_encode(["error" => "Non authentifié"]);
    exit;
}
// ...puis decode le JWT, récupère l'user, etc.


$userId = $decoded->user_id;

$userModel = new User($pdo);
$user = $userModel->findById($userId);

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'Utilisateur introuvable']);
    exit;
}

echo json_encode([
    "id" => $user["id"],
    "username" => $user["username"],
    "email" => $user["email"],
    "role" => $user["role"],
    "phone" => $user["phone"] ?? "",
    "address" => $user["address"] ?? "",
    "postal_code" => $user["postal_code"] ?? "",
    "geolocalisation_enable" => $user["geolocalisation_enable"] ?? 0,
    "created_at" => $user["created_at"] ?? ""
]);
