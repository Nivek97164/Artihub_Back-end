<?php
header("Access-Control-Allow-Origin: http://https://artihubfront-end-production-3c59.up.railway.app");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/jwt.php';

// Données reçues
$data = json_decode(file_get_contents("php://input"), true);
// Peut être email OU téléphone
$login = $data['email'] ?? '';
$password = $data['password'] ?? '';
$role = $data['role'] ?? '';

if (!$login || !$password || !$role) {
    http_response_code(400);
    echo json_encode(["error" => "Adresse e-mail ou téléphone, mot de passe ET type de compte requis"]);
    exit;
}

$userModel = new User($pdo);
// Utilise la nouvelle méthode qui filtre aussi par rôle :
$user = $userModel->findByEmailOrPhoneAndRole($login, $role);

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["error" => "Identifiants invalides"]);
    exit;
}

// ✅ Génère le JWT
$jwt = generate_jwt($user['id']);

// Pose le cookie JWT
setcookie('jwt', $jwt, [
    'httponly' => true,
    'samesite' => 'Lax',
    'path' => '/',
    'secure' => false,
    'expires' => time() + 3600*24*7
]);

// Après login réussi, déjà dans $user
echo json_encode([
    "success" => true,
    "jwt" => $jwt, // pour debug
    "role" => $user["role"],
    "id" => $user["id"],
    "username" => $user["username"],
    // Ajoute d'autres champs si besoin
]);
