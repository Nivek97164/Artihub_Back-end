<?php
header("Access-Control-Allow-Origin: https://artihubfront-end-production-3c59.up.railway.app");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

// Supprime le cookie JWT
setcookie('jwt', '', [
    'httponly' => true,
    'samesite' => 'Lax',
    'path' => '/',
    'secure' => false, // true en production HTTPS
    'expires' => time() - 3600 // Date passée = supprime
]);

echo json_encode(["success" => true]);
