<?php
header("Access-Control-Allow-Origin: http://https://www.artihub.fr");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once __DIR__ . '/../utils/jwt.php';

if (!isset($_COOKIE['jwt'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized, no token"]);
    exit;
}
$userId = validate_jwt($_COOKIE['jwt']);
if (!$userId) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized, invalid token"]);
    exit;
}
// Ici, $userId contient l’id du user authentifié !
// Tu peux faire une requête BDD ou passer à la suite.

?>
