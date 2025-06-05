<?php
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die(json_encode([
        "error" => "Autoload path not found (test __DIR__+..)",
        "tried" => $autoloadPath
    ]));
}
require_once $autoloadPath;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

const JWT_SECRET = 'artihub';

// Génère un JWT pour un utilisateur donné
function generate_jwt($userId): string {
    $payload = [
        'user_id' => $userId,
        'exp' => time() + (60 * 60 * 24 * 7) // 7 jours
    ];
    return JWT::encode($payload, JWT_SECRET, 'HS256');
}

// Vérifie un JWT et retourne le payload ou null si invalide
function verify_jwt(string $token): ?object {
    try {
        return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
    } catch (ExpiredException $e) {
        error_log("JWT expiré : " . $e->getMessage());
        return null;
    } catch (\Exception $e) {
        error_log("JWT invalide : " . $e->getMessage());
        return null;
    }
}

// Nouvelle version "compatibilité" pour tes middlewares
function validate_jwt($jwt) {
    $decoded = verify_jwt($jwt);
    // Ici, tu peux retourner l'objet décodé, ou juste l'id
    if ($decoded && isset($decoded->user_id)) {
        return $decoded->user_id;
    }
    return false;
}
