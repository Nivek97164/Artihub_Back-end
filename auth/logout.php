<?php
// CORS headers
header("Access-Control-Allow-Origin: https://www.artihub.fr");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Pré-flight OPTIONS (important pour CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);
    exit;
}

// Supprimer le cookie JWT
setcookie('jwt', '', [
    'httponly' => true,
    'samesite' => 'None',     
    'secure' => true,        
    'path' => '/',
    'expires' => time() - 3600
]);

echo json_encode(["success" => true]);
